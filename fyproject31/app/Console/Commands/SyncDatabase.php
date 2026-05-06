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
            $newContent .= "        User::updateOrCreate(['username' => '{$user->username}'], [
            'name' => '{$user->name}',
            'email' => '{$user->email}',
            'password' => '{$user->password}',
            'role' => '{$user->role}',
            'phone' => '{$user->phone}',
            'status' => '{$user->status}',
        ]);\n\n";
        }

        // Add menu items
        $newContent .= '        // Menu Items - Food
';
        $menuItems = MenuItem::where('category', 'food')->get();
        foreach ($menuItems as $item) {
            $newContent .= "        MenuItem::updateOrCreate(['name' => '{$item->name}'], [
            'description' => '{$item->description}',
            'price' => {$item->price},
            'category' => '{$item->category}',
            'status' => '{$item->status}',
        ]);\n\n";
        }

        // Add drinks
        $newContent .= '        // Menu Items - Drinks
';
        $drinks = MenuItem::where('category', 'drink')->get();
        foreach ($drinks as $item) {
            $newContent .= "        MenuItem::updateOrCreate(['name' => '{$item->name}'], [
            'description' => '{$item->description}',
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
            $newContent .= "        Order::updateOrCreate(['order_id' => '{$order->order_id}'], [
            'table_number' => '{$order->table_number}',
            'items' => '{$order->items}',
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
            $newContent .= "        Feedback::updateOrCreate(['customer_name' => '{$fb->customer_name}'], [
            'rating' => {$fb->rating},
            'message' => '{$fb->message}',
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
        if (file_exists('C:\xampp\mysql\bin\mysqldump.exe')) {
            $mysqldump = 'C:\xampp\mysql\bin\mysqldump.exe';
        } elseif (file_exists('C:\wamp64\bin\mysql\mysql8.0.30\bin\mysqldump.exe')) {
            $mysqldump = 'C:\wamp64\bin\mysql\mysql8.0.30\bin\mysqldump.exe';
        }

        $passwordOption = $dbPassword ? "--password=" . $dbPassword : '';

        $command = sprintf(
            '%s --user=%s %s --host=%s %s > %s',
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
