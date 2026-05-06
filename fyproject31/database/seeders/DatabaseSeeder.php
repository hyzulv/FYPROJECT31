<?php

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
        User::updateOrCreate(['username' => 'admin'], [
            'name' => 'Admin User',
            'email' => 'matrock.admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+60 11-123 4567',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'ahmad'], [
            'name' => 'Ahmad Faizal',
            'email' => 'ahmad.faizal@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 12-345 6789',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'nurul'], [
            'name' => 'Nurul Aisyah',
            'email' => 'nurul.aisyah@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 13-456 7890',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'raj'], [
            'name' => 'Raj Kumar',
            'email' => 'raj.kumar@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 14-567 8901',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'lim'], [
            'name' => 'Lim Wei Jie',
            'email' => 'lim.weijie@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 16-678 9012',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'sarah'], [
            'name' => 'Sarah Tan',
            'email' => 'sarah.tan@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 17-789 0123',
            'status' => 'inactive',
        ]);

        User::updateOrCreate(['username' => 'zulkifli'], [
            'name' => 'Zulkifli Hassan',
            'email' => 'zulkifli.h@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 18-890 1234',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'farah'], [
            'name' => 'Farah Diana',
            'email' => 'farah.diana@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone' => '+60 19-901 2345',
            'status' => 'active',
        ]);

        // Menu Items - Food
        MenuItem::updateOrCreate(['name' => 'Ayam Goreng Kunyit'], [
            'description' => 'Turmeric fried chicken served with rice and sambal',
            'price' => 12.00,
            'category' => 'food',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Goreng'], [
            'description' => 'Fried rice with egg and vegetables',
            'price' => 10.00,
            'category' => 'food',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Mee Goreng'], [
            'description' => 'Stir-fried noodles with prawns and vegetables',
            'price' => 11.00,
            'category' => 'food',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Roti Canai'], [
            'description' => 'Crispy flatbread served with dhal curry',
            'price' => 5.00,
            'category' => 'food',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak'], [
            'description' => 'Coconut rice with sambal, egg, and anchovies',
            'price' => 9.00,
            'category' => 'food',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Char Kuey Teow'], [
            'description' => 'Stir-fried rice noodles with dark soy sauce',
            'price' => 10.00,
            'category' => 'food',
            'status' => 'available',
        ]);

        // Menu Items - Drinks
        MenuItem::updateOrCreate(['name' => 'Kopi O'], [
            'description' => 'Black coffee with sugar',
            'price' => 3.50,
            'category' => 'drink',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Teh Tarik'], [
            'description' => 'Pulled milk tea',
            'price' => 3.50,
            'category' => 'drink',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Teh O'], [
            'description' => 'Black tea with sugar',
            'price' => 3.00,
            'category' => 'drink',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Milo'], [
            'description' => 'Malted chocolate drink',
            'price' => 4.00,
            'category' => 'drink',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Air Kosong'], [
            'description' => 'Plain water',
            'price' => 1.00,
            'category' => 'drink',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Air Kelapa'], [
            'description' => 'Fresh coconut water',
            'price' => 5.00,
            'category' => 'drink',
            'status' => 'available',
        ]);

        // Orders
        Order::updateOrCreate(['order_id' => '#ORD-001'], [
            'table_number' => 'T05',
            'items' => 'Nasi Goreng, Teh O',
            'total' => 13.00,
            'status' => 'pending',
            'order_time' => '10:30:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-002'], [
            'table_number' => 'T03',
            'items' => 'Ayam Goreng Kunyit',
            'total' => 12.00,
            'status' => 'processing',
            'order_time' => '10:45:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-003'], [
            'table_number' => 'T01',
            'items' => 'Mee Goreng, Kopi O',
            'total' => 14.50,
            'status' => 'completed',
            'order_time' => '11:00:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-004'], [
            'table_number' => 'T08',
            'items' => 'Roti Canai, Teh Tarik',
            'total' => 8.50,
            'status' => 'completed',
            'order_time' => '11:15:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-005'], [
            'table_number' => 'T02',
            'items' => 'Nasi Lemak, Milo',
            'total' => 13.00,
            'status' => 'pending',
            'order_time' => '11:30:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-006'], [
            'table_number' => 'T06',
            'items' => 'Char Kuey Teow',
            'total' => 10.00,
            'status' => 'processing',
            'order_time' => '11:45:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-007'], [
            'table_number' => 'T04',
            'items' => 'Nasi Goreng, Air Kelapa',
            'total' => 15.00,
            'status' => 'completed',
            'order_time' => '12:00:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-008'], [
            'table_number' => 'T07',
            'items' => 'Mee Goreng, Teh O',
            'total' => 14.00,
            'status' => 'completed',
            'order_time' => '12:15:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-009'], [
            'table_number' => 'T09',
            'items' => 'Ayam Goreng Kunyit, Nasi Lemak',
            'total' => 21.00,
            'status' => 'cancelled',
            'order_time' => '12:30:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-010'], [
            'table_number' => 'T10',
            'items' => 'Roti Canai, Kopi O, Milo',
            'total' => 12.50,
            'status' => 'completed',
            'order_time' => '12:45:00',
        ]);

        // Feedback
        Feedback::updateOrCreate(['customer_name' => 'Ahmad Razali'], [
            'rating' => 5,
            'message' => 'Ayam goreng kunyit sangat sedap! Sambal yang diberikan juga memang terbaik. Akan datang lagi.',
            'feedback_date' => '2026-05-03',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Siti Nurhaliza'], [
            'rating' => 4,
            'message' => 'Makanan enak dan harga berpatutan. Cuma servis agak lambat sedikit pada waktu puncak.',
            'feedback_date' => '2026-05-02',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Lee Wei Ming'], [
            'rating' => 5,
            'message' => 'Nasi lemak dia memang power! Sambal pedas just nice. Portion pun besar. Recommended!',
            'feedback_date' => '2026-05-01',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Priya Nair'], [
            'rating' => 3,
            'message' => 'Roti canai okay tapi could be better. Teh tarik dia memang kaw. Overall okay lah.',
            'feedback_date' => '2026-04-30',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Hafiz Ibrahim'], [
            'rating' => 5,
            'message' => 'Tempat makan terbaik di Skudai! Harga murah, makanan sedap, servis bagus. Five stars!',
            'feedback_date' => '2026-04-28',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Tan Mei Ling'], [
            'rating' => 4,
            'message' => 'Char kuey teow sangat sedap, macamPenang punya! Milo dia pun pekat. Good value for money.',
            'feedback_date' => '2026-04-25',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Muhammad Irfan'], [
            'rating' => 4,
            'message' => 'Mee goreng dia memang lain dari yang lain. Sedap! Cuma parking agak susah sikit waktu lunch.',
            'feedback_date' => '2026-04-22',
        ]);
    }
}
