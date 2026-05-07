<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Support\Facades\File;

class SyncDatabase extends Command
{
    protected $signature = 'db:sync {--no-git : Skip git operations}';
    protected $description = 'Export database to SQL file and update seeder';

    public function handle()
    {
        $this->info('Syncing database...');

        // Update the seeder
        $this->updateSeeder();

        // Export SQL backup
        $this->exportSqlBackup();

        if (!$this->option('no-git')) {
            // Git operations
            $this->info('Committing and pushing to Git...');

            exec('git add database/seeders/DatabaseSeeder.php database/backup.sql', $output, $returnCode);
            exec('git commit -m "Sync database"', $output, $returnCode);
            exec('git push', $output, $returnCode);

            $this->info('Database synced successfully!');
            $this->info('Your friend should run: git pull && php artisan migrate --seed');
        } else {
            $this->info('Database files updated. Run: git add database/ && git commit && git push');
        }

        return 0;
    }

    protected function updateSeeder()
    {
        $this->info('Updating seeder...');

        $seederPath = database_path('seeders/DatabaseSeeder.php');
        $content = File::get($seederPath);

        // Build new seeder content
        $newContent = '<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
';

        // Add users
        $users = User::all();
        foreach ($users as $user) {
            $name = addslashes($user->name);
            $email = addslashes($user->email);
            $phone = addslashes($user->phone ?? '');
            $newContent .= "        User::updateOrCreate(['username' => '{$user->username}'], [
            'name' => '{$name}',
            'email' => '{$email}',
            'password' => '{$user->password}',
            'role' => '{$user->role}',
            'phone' => '{$phone}',
            'status' => '{$user->status}',
        ]);\n\n";
        }

        // Add menu items
        $newContent .= '        // Menu Items
';
        $menuItems = MenuItem::all();
        foreach ($menuItems as $item) {
            $desc = addslashes($item->description ?? '');
            $name = addslashes($item->name);
            $newContent .= "        MenuItem::updateOrCreate(['name' => '{$name}'], [
            'description' => '{$desc}',
            'price' => {$item->price},
            'category' => '{$item->category}',
            'status' => '{$item->status}',
        ]);\n\n";
        }

        // Add orders
        $newContent .= '        // Orders
';
        $orders = Order::all();
        foreach ($orders as $order) {
            $items = addslashes($order->items);
            $newContent .= "        Order::updateOrCreate(['order_id' => '{$order->order_id}'], [
            'table_number' => '{$order->table_number}',
            'items' => '{$items}',
            'total' => {$order->total},
            'status' => '{$order->status}',
            'order_time' => '{$order->order_time}',
        ]);\n\n";
        }

        // Add feedback
        $newContent .= '        // Feedback
';
        $feedbacks = Feedback::all();
        foreach ($feedbacks as $fb) {
            $message = addslashes($fb->message);
            $customer = addslashes($fb->customer_name);
            $newContent .= "        Feedback::updateOrCreate(['customer_name' => '{$customer}'], [
            'rating' => {$fb->rating},
            'message' => '{$message}',
            'feedback_date' => '{$fb->feedback_date}',
        ]);\n\n";
        }

        $newContent .= '    }
}';

        File::put($seederPath, $newContent);
        $this->info('Seeder updated.');
    }

    protected function exportSqlBackup()
    {
        $this->info('Exporting SQL backup...');

        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPassword = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');

        $outputFile = database_path('backup.sql');

        $mysqldump = 'mysqldump';
        if (file_exists('C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe')) {
            $mysqldump = '"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe"';
        } elseif (file_exists('C:\xampp\mysql\bin\mysqldump.exe')) {
            $mysqldump = '"C:\xampp\mysql\bin\mysqldump.exe"';
        } elseif (file_exists('C:\wamp64\bin\mysql\mysql8.0.30\bin\mysqldump.exe')) {
            $mysqldump = '"C:\wamp64\bin\mysql\mysql8.0.30\bin\mysqldump.exe"';
        }

        $passwordOption = $dbPassword ? "--password=" . escapeshellarg($dbPassword) : '';

        $command = sprintf(
            '%s --user=%s %s --host=%s %s --result-file=%s',
            $mysqldump,
            escapeshellarg($dbUser),
            $passwordOption ?: '',
            escapeshellarg($dbHost),
            escapeshellarg($dbName),
            escapeshellarg($outputFile)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            $this->warn('Could not export SQL backup. Make sure mysqldump is available.');
        } else {
            $this->info('SQL backup exported.');
        }
    }
}
