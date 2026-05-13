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
            'email' => 'kumpulan31@gmail.com',
            'password' => '$2y$12$TOvGyhVckt5vzrWQzyOZW.d0jUjMyWj7Eb6ozBPlYBloOZMk8vCSO',
            'role' => 'admin',
            'phone' => '+60 11-123 4567',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'ahmad'], [
            'name' => 'Ahmad Faizal',
            'email' => 'ahmad.faizal@gmail.com',
            'password' => '$2y$12$z9aI2Dgn8u24XWheQTPWOuR1YFhEC8NhGOqpbKz1GDLSyajxgvMvy',
            'role' => 'staff',
            'phone' => '+60 12-345 6789',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'nurul'], [
            'name' => 'Nurul Aisyah',
            'email' => 'nurul.aisyah@gmail.com',
            'password' => '$2y$12$bhYT9oVz/i3ct7BLb39kKOw8lztkZ84qMbxKHtLixTbN5faapN3Ei',
            'role' => 'staff',
            'phone' => '+60 13-456 7890',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'raj'], [
            'name' => 'Raj Kumar',
            'email' => 'raj.kumar@gmail.com',
            'password' => '$2y$12$SVvczyJk3Ui1YCTh9JqdUuweziq8kQtgvukaJtDxZRKISZY0pb1Pq',
            'role' => 'staff',
            'phone' => '+60 14-567 8901',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'lim'], [
            'name' => 'Lim Wei Jie',
            'email' => 'lim.weijie@gmail.com',
            'password' => '$2y$12$muaS6mYPvt/YBmYApYdlvO1LDz1s6Wh2h1HpZjEEI7m78Asj2PtF.',
            'role' => 'staff',
            'phone' => '+60 16-678 9012',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'sarah'], [
            'name' => 'Sarah Tan',
            'email' => 'sarah.tan@gmail.com',
            'password' => '$2y$12$/2vTh1PfW7FwDRgqSIyxFOkzuIej4vJyTP7pDZfu9fmo8ItaE2qtm',
            'role' => 'staff',
            'phone' => '+60 17-789 0123',
            'status' => 'inactive',
        ]);

        User::updateOrCreate(['username' => 'zulkifli'], [
            'name' => 'Zulkifli Hassan',
            'email' => 'zulkifli.h@gmail.com',
            'password' => '$2y$12$IIg.MtvUwHy60YxH2yBIeOhDywnNrgOjw2XXJE6b3oueqwMBzPzT6',
            'role' => 'staff',
            'phone' => '+60 18-890 1234',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'farah'], [
            'name' => 'Farah Diana',
            'email' => 'farah.diana@gmail.com',
            'password' => '$2y$12$ROTf1aAsTyMg41VpD6Gmge/71tKamlDbGI5Kirm/sJTfxKFD4P7vG',
            'role' => 'staff',
            'phone' => '+60 19-901 2345',
            'status' => 'active',
        ]);

        User::updateOrCreate(['username' => 'Ali'], [
            'name' => 'ala',
            'email' => 'fypkumpulan31@gmail.com',
            'password' => '$2y$12$V12wt4Ys9aw09QPqKsS5LuOtSDYWMoSIEJfud/ByUt1CB0a1OHDPS',
            'role' => 'staff',
            'phone' => '324234234',
            'status' => 'active',
        ]);

        // Menu Items
        MenuItem::updateOrCreate(['name' => 'Ayam Goreng Kunyit'], [
            'description' => 'Signature turmeric fried chicken with crispy skin, served with rice and sambal',
            'price' => 10.90,
            'category' => 'ala_carte',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Daging Goreng Kunyit'], [
            'description' => 'Tender beef stir-fried with turmeric spices, served with rice and sambal',
            'price' => 13.90,
            'category' => 'ala_carte',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Sotong Goreng Kunyit'], [
            'description' => 'Fresh squid cooked in turmeric seasoning, served with rice and sambal',
            'price' => 15.50,
            'category' => 'ala_carte',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Udang Goreng Kunyit'], [
            'description' => 'Juicy prawns fried with turmeric and spices, served with rice and sambal',
            'price' => 15.50,
            'category' => 'ala_carte',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Combo Set Ayam'], [
            'description' => 'Ayam Goreng Kunyit set with rice, drink and sambal',
            'price' => 15.00,
            'category' => 'combo_set',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Combo Set Daging'], [
            'description' => 'Daging Goreng Kunyit set with rice, drink and sambal',
            'price' => 17.00,
            'category' => 'combo_set',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Combo Set Udang'], [
            'description' => 'Udang Goreng Kunyit set with rice, drink and sambal',
            'price' => 19.50,
            'category' => 'combo_set',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Combo Set Sotong'], [
            'description' => 'Sotong Goreng Kunyit set with rice, drink and sambal',
            'price' => 19.50,
            'category' => 'combo_set',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Ayam + Daging Mix'], [
            'description' => 'Mix of Ayam Goreng Kunyit and Daging Goreng Kunyit with rice',
            'price' => 18.90,
            'category' => 'mix',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Sotong + Udang Mix'], [
            'description' => 'Mix of Sotong Goreng Kunyit and Udang Goreng Kunyit with rice',
            'price' => 18.90,
            'category' => 'mix',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Ayam + Udang Mix'], [
            'description' => 'Mix of Ayam Goreng Kunyit and Udang Goreng Kunyit with rice',
            'price' => 18.90,
            'category' => 'mix',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Ayam + Sotong Mix'], [
            'description' => 'Mix of Ayam Goreng Kunyit and Sotong Goreng Kunyit with rice',
            'price' => 18.90,
            'category' => 'mix',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Daging + Sotong Mix'], [
            'description' => 'Mix of Daging Goreng Kunyit and Sotong Goreng Kunyit with rice',
            'price' => 18.90,
            'category' => 'mix',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Daging + Udang Mix'], [
            'description' => 'Mix of Daging Goreng Kunyit and Udang Goreng Kunyit with rice',
            'price' => 18.90,
            'category' => 'mix',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Biasa'], [
            'description' => 'Fragrant pandan basmati coconut rice with sambal, peanut, anchovies and cucumber',
            'price' => 5.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Telur Mata'], [
            'description' => 'Nasi lemak with a sunny-side-up egg, sambal, peanut and anchovies',
            'price' => 7.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Ayam Berempah'], [
            'description' => 'Nasi lemak with spiced fried chicken, sambal and sides',
            'price' => 12.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Ayam Kunyit'], [
            'description' => 'Nasi lemak with our signature turmeric fried chicken and sambal',
            'price' => 13.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Daging Kunyit'], [
            'description' => 'Nasi lemak with turmeric beef, sambal and sides',
            'price' => 15.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Sotong Kunyit'], [
            'description' => 'Nasi lemak with turmeric squid, sambal and sides',
            'price' => 16.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Lemak Udang Kunyit'], [
            'description' => 'Nasi lemak with turmeric prawns, sambal and sides',
            'price' => 16.00,
            'category' => 'nasi_lemak',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Ayam Kicap'], [
            'description' => 'Chicken cooked in sweet soy sauce with aromatic spices',
            'price' => 12.00,
            'category' => 'kicap',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Daging Kicap'], [
            'description' => 'Beef braised in sweet soy sauce with traditional spices',
            'price' => 14.00,
            'category' => 'kicap',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Set Family'], [
            'description' => 'Family set with Ayam, Daging, Sotong, Udang Goreng Kunyit served with rice and sambal for the whole family',
            'price' => 55.00,
            'category' => 'set_family',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Milo'], [
            'description' => 'Iced Milo chocolate malt drink',
            'price' => 4.50,
            'category' => 'minuman',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nescafe'], [
            'description' => 'Iced Nescafe coffee',
            'price' => 4.50,
            'category' => 'minuman',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Teh'], [
            'description' => 'Iced Malaysian pulled tea with milk',
            'price' => 4.50,
            'category' => 'minuman',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Teh O'], [
            'description' => 'Iced black tea with sugar',
            'price' => 3.00,
            'category' => 'minuman',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Ais Kosong'], [
            'description' => 'Plain water with ice',
            'price' => 1.00,
            'category' => 'minuman',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Telur Mata'], [
            'description' => 'Sunny-side-up fried egg',
            'price' => 2.00,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Nasi Putih'], [
            'description' => 'Steamed white rice',
            'price' => 3.00,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Sambal Extra'], [
            'description' => 'Extra serving of our signature sambal',
            'price' => 1.00,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Ice'], [
            'description' => 'Cold with ice',
            'price' => 0.50,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Kurang Manis'], [
            'description' => 'Less sweet',
            'price' => 0.00,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Normal Manis'], [
            'description' => 'Normal sweetness',
            'price' => 0.00,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        MenuItem::updateOrCreate(['name' => 'Extra Manis'], [
            'description' => 'Extra sweet',
            'price' => 0.50,
            'category' => 'add_on',
            'status' => 'available',
        ]);

        // Orders
        Order::updateOrCreate(['order_id' => '#ORD-001'], [
            'table_number' => 'T05',
            'items' => 'Nasi Goreng, Teh O',
            'total' => 13.00,
            'status' => 'preparing',
            'order_time' => '2026-05-13 10:30:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-002'], [
            'table_number' => 'T03',
            'items' => 'Ayam Goreng Kunyit',
            'total' => 12.00,
            'status' => 'preparing',
            'order_time' => '2026-05-13 10:45:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-003'], [
            'table_number' => 'T01',
            'items' => 'Mee Goreng, Kopi O',
            'total' => 14.50,
            'status' => 'preparing',
            'order_time' => '2026-05-13 11:00:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-004'], [
            'table_number' => 'T08',
            'items' => 'Roti Canai, Teh Tarik',
            'total' => 8.50,
            'status' => 'completed',
            'order_time' => '2026-05-13 11:15:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-005'], [
            'table_number' => 'T02',
            'items' => 'Nasi Lemak, Milo',
            'total' => 13.00,
            'status' => 'preparing',
            'order_time' => '2026-05-13 11:30:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-006'], [
            'table_number' => 'T06',
            'items' => 'Char Kuey Teow',
            'total' => 10.00,
            'status' => 'preparing',
            'order_time' => '2026-05-13 11:45:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-007'], [
            'table_number' => 'T04',
            'items' => 'Nasi Goreng, Air Kelapa',
            'total' => 15.00,
            'status' => 'completed',
            'order_time' => '2026-05-13 12:00:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-008'], [
            'table_number' => 'T07',
            'items' => 'Mee Goreng, Teh O',
            'total' => 14.00,
            'status' => 'completed',
            'order_time' => '2026-05-13 12:15:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-009'], [
            'table_number' => 'T09',
            'items' => 'Ayam Goreng Kunyit, Nasi Lemak',
            'total' => 21.00,
            'status' => 'completed',
            'order_time' => '2026-05-13 12:30:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-010'], [
            'table_number' => 'T10',
            'items' => 'Roti Canai, Kopi O, Milo',
            'total' => 12.50,
            'status' => 'completed',
            'order_time' => '2026-05-13 12:45:00',
        ]);

        Order::updateOrCreate(['order_id' => '#ORD-YQER0X'], [
            'table_number' => 'T10',
            'items' => '[{\"key\":\"1-\",\"id\":1,\"name\":\"Ayam Goreng Kunyit\",\"price\":10.9,\"quantity\":1,\"addons\":[]}]',
            'total' => 11.55,
            'status' => 'completed',
            'order_time' => '2026-05-13 00:39:23',
        ]);

        // Feedback
        Feedback::updateOrCreate(['customer_name' => 'Ahmad Razali'], [
            'rating' => 5,
            'message' => 'Ayam goreng kunyit sangat sedap! Sambal yang diberikan juga memang terbaik. Akan datang lagi.',
            'feedback_date' => '2026-05-03 00:00:00',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Siti Nurhaliza'], [
            'rating' => 4,
            'message' => 'Makanan enak dan harga berpatutan. Cuma servis agak lambat sedikit pada waktu puncak.',
            'feedback_date' => '2026-05-02 00:00:00',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Lee Wei Ming'], [
            'rating' => 5,
            'message' => 'Nasi lemak dia memang power! Sambal pedas just nice. Portion pun besar. Recommended!',
            'feedback_date' => '2026-05-01 00:00:00',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Priya Nair'], [
            'rating' => 3,
            'message' => 'Roti canai okay tapi could be better. Teh tarik dia memang kaw. Overall okay lah.',
            'feedback_date' => '2026-04-30 00:00:00',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Hafiz Ibrahim'], [
            'rating' => 5,
            'message' => 'Tempat makan terbaik di Skudai! Harga murah, makanan sedap, servis bagus. Five stars!',
            'feedback_date' => '2026-04-28 00:00:00',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Tan Mei Ling'], [
            'rating' => 4,
            'message' => 'Char kuey teow sangat sedap, macamPenang punya! Milo dia pun pekat. Good value for money.',
            'feedback_date' => '2026-04-25 00:00:00',
        ]);

        Feedback::updateOrCreate(['customer_name' => 'Muhammad Irfan'], [
            'rating' => 4,
            'message' => 'Mee goreng dia memang lain dari yang lain. Sedap! Cuma parking agak susah sikit waktu lunch.',
            'feedback_date' => '2026-04-22 00:00:00',
        ]);

    }
}