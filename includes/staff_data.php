<?php

function staff_require_login(): void
{
    if (!isset($_SESSION['user'])) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
        exit();
    }
}

function staff_redirect_if_guest(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
}

function staff_data_directory(): string
{
    $dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    return $dir;
}

function staff_json_path(string $name): string
{
    return staff_data_directory() . DIRECTORY_SEPARATOR . $name;
}

function staff_read_json(string $file, $default)
{
    $path = staff_json_path($file);
    if (!file_exists($path)) {
        return $default;
    }
    $raw = file_get_contents($path);
    if ($raw === false || $raw === '') {
        return $default;
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : $default;
}

function staff_write_json(string $file, array $data): void
{
    $path = staff_json_path($file);
    $tmp = $path . '.tmp';
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        throw new RuntimeException('JSON encode failed');
    }
    file_put_contents($tmp, $json, LOCK_EX);
    rename($tmp, $path);
}

function staff_ensure_csrf(): string
{
    if (empty($_SESSION['staff_csrf'])) {
        $_SESSION['staff_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['staff_csrf'];
}

function staff_verify_csrf(?string $token): bool
{
    return is_string($token) && isset($_SESSION['staff_csrf']) && hash_equals($_SESSION['staff_csrf'], $token);
}

function staff_valid_order_statuses(): array
{
    return ['New', 'Preparing', 'Ready', 'Served', 'Cancelled'];
}

function staff_role_permissions(string $role): array
{
    $base = [
        'view.dashboard',
        'view.profile',
        'edit.profile',
        'view.order',
        'edit.order',
        'delete.order',
        'update.order.status',
        'view.menu',
        'add.menu',
        'edit.menu',
        'delete.menu',
        'view.feedback',
        'change.password',
    ];
    if ($role === 'admin') {
        return array_merge($base, ['view.staff', 'add.staff', 'edit.staff', 'delete.staff']);
    }
    return $base;
}

function staff_has_permission(string $role, string $permission): bool
{
    return in_array($permission, staff_role_permissions($role), true);
}

function staff_seed_if_missing(): void
{
    $today = date('Y-m-d');
    if (!file_exists(staff_json_path('orders.json'))) {
        staff_write_json('orders.json', [
            'orders' => [
                [
                    'id' => 'ORD-1001',
                    'channel' => 'Dine-in T3',
                    'customer' => 'Ahmad',
                    'items' => 'Nasi Goreng ×2, Teh Ais',
                    'status' => 'Preparing',
                    'placed' => $today . ' 12:05:00',
                    'total' => '24.50',
                ],
                [
                    'id' => 'ORD-1002',
                    'channel' => 'GrabFood',
                    'customer' => 'Siti',
                    'items' => 'Burger Set, Fries',
                    'status' => 'New',
                    'placed' => $today . ' 12:18:00',
                    'total' => '31.90',
                ],
                [
                    'id' => 'ORD-1003',
                    'channel' => 'Takeaway',
                    'customer' => 'Walk-in',
                    'items' => 'Laksa ×1',
                    'status' => 'Ready',
                    'placed' => $today . ' 11:52:00',
                    'total' => '14.00',
                ],
            ],
            'nextSeq' => 1004,
        ]);
    }

    if (!file_exists(staff_json_path('menu.json'))) {
        staff_write_json('menu.json', [
            'items' => [
                [
                    'id' => 'M-001',
                    'name' => 'Nasi Goreng Pattaya',
                    'category' => 'Food',
                    'price' => '12.90',
                    'description' => 'Telur lipat, ayam, sayur campur.',
                    'available' => true,
                ],
                [
                    'id' => 'M-002',
                    'name' => 'Teh Ais',
                    'category' => 'Drink',
                    'price' => '3.50',
                    'description' => '',
                    'available' => true,
                ],
                [
                    'id' => 'M-003',
                    'name' => 'Chicken Chop',
                    'category' => 'Food',
                    'price' => '18.00',
                    'description' => 'Sos black pepper / mushroom.',
                    'available' => true,
                ],
            ],
            'nextSeq' => 4,
        ]);
    }

    if (!file_exists(staff_json_path('feedback.json'))) {
        staff_write_json('feedback.json', [
            'entries' => [
                [
                    'id' => 'F-1001',
                    'name' => 'Farah',
                    'email' => 'farah@example.com',
                    'message' => 'Servis cepat, makanan sedap!',
                    'created' => $today . ' 09:30:00',
                ],
                [
                    'id' => 'F-1002',
                    'name' => 'Daniel',
                    'email' => 'daniel@example.com',
                    'message' => 'Portion besar. Parking agak susah waktu lunch.',
                    'created' => $today . ' 10:12:00',
                ],
            ],
            'nextSeq' => 1003,
        ]);
    }

    if (!file_exists(staff_json_path('profiles.json'))) {
        staff_write_json('profiles.json', [
            'profiles' => [
                'admin' => [
                    'displayName' => 'Admin',
                    'email' => 'admin@restaurant.local',
                    'phone' => '',
                    'notes' => 'System administrator',
                ],
                'staff1' => [
                    'displayName' => 'Staff One',
                    'email' => 'staff1@restaurant.local',
                    'phone' => '',
                    'notes' => 'Service crew',
                ],
            ],
        ]);
    }

    if (!file_exists(staff_json_path('users.json'))) {
        staff_write_json('users.json', [
            'users' => [
                [
                    'username' => 'admin',
                    'password' => 'password123',
                    'role' => 'admin',
                    'email' => 'admin@restaurant.local',
                    'emailVerified' => true,
                    'verifyToken' => '',
                    'verifySentAt' => '',
                ],
                [
                    'username' => 'staff1',
                    'password' => 'staff123',
                    'role' => 'staff',
                    'email' => 'staff1@restaurant.local',
                    'emailVerified' => true,
                    'verifyToken' => '',
                    'verifySentAt' => '',
                ],
            ],
        ]);
    }
}

function staff_orders_container(): array
{
    staff_seed_if_missing();
    return staff_read_json('orders.json', ['orders' => [], 'nextSeq' => 1001]);
}

function staff_orders_list(): array
{
    $c = staff_orders_container();
    $list = $c['orders'] ?? [];
    usort($list, function ($a, $b) {
        return strcmp($b['placed'] ?? '', $a['placed'] ?? '');
    });
    return $list;
}

function staff_orders_save(array $container): void
{
    staff_write_json('orders.json', $container);
}

function staff_find_order(string $id): ?array
{
    $container = staff_orders_container();
    $orders = $container['orders'] ?? [];
    foreach ($orders as $order) {
        if (($order['id'] ?? '') === $id) {
            return $order;
        }
    }
    return null;
}

function staff_create_customer_order(array $payload): array
{
    $container = staff_orders_container();
    $seq = (int)($container['nextSeq'] ?? 1001);
    $id = 'ORD-' . $seq;
    $container['nextSeq'] = $seq + 1;

    $table = trim((string)($payload['table'] ?? ''));
    $customer = trim((string)($payload['customer'] ?? 'Guest'));
    $itemsSummary = trim((string)($payload['itemsSummary'] ?? ''));
    $total = trim((string)($payload['total'] ?? '0.00'));
    $paymentMethod = trim((string)($payload['paymentMethod'] ?? ''));
    $note = trim((string)($payload['note'] ?? ''));

    if ($table === '' || $itemsSummary === '') {
        throw new InvalidArgumentException('Missing table or items');
    }

    $order = [
        'id' => $id,
        'channel' => 'Table ' . strtoupper($table),
        'customer' => $customer,
        'items' => $itemsSummary,
        'status' => 'New',
        'placed' => date('Y-m-d H:i:s'),
        'total' => $total,
        'paymentMethod' => $paymentMethod,
        'note' => $note,
        'source' => 'customer_qr',
    ];
    $container['orders'][] = $order;
    staff_orders_save($container);
    return $order;
}

function staff_menu_container(): array
{
    staff_seed_if_missing();
    return staff_read_json('menu.json', ['items' => [], 'nextSeq' => 1]);
}

function staff_menu_save(array $container): void
{
    staff_write_json('menu.json', $container);
}

function staff_feedback_container(): array
{
    staff_seed_if_missing();
    return staff_read_json('feedback.json', ['entries' => [], 'nextSeq' => 1001]);
}

function staff_feedback_list(): array
{
    $c = staff_feedback_container();
    $list = $c['entries'] ?? [];
    usort($list, function ($a, $b) {
        return strcmp($b['created'] ?? '', $a['created'] ?? '');
    });
    return $list;
}

function staff_create_feedback(array $payload): array
{
    $container = staff_feedback_container();
    $seq = (int)($container['nextSeq'] ?? 1001);
    $id = 'F-' . $seq;
    $container['nextSeq'] = $seq + 1;

    $name = trim((string)($payload['name'] ?? 'Guest'));
    $email = trim((string)($payload['email'] ?? ''));
    $message = trim((string)($payload['message'] ?? ''));

    if ($message === '') {
        throw new InvalidArgumentException('Feedback message is required');
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Invalid email');
    }

    $entry = [
        'id' => $id,
        'name' => $name === '' ? 'Guest' : $name,
        'email' => $email,
        'message' => $message,
        'created' => date('Y-m-d H:i:s'),
    ];
    if (!isset($container['entries']) || !is_array($container['entries'])) {
        $container['entries'] = [];
    }
    $container['entries'][] = $entry;
    staff_write_json('feedback.json', $container);
    return $entry;
}

function staff_profiles_container(): array
{
    staff_seed_if_missing();
    return staff_read_json('profiles.json', ['profiles' => []]);
}

function staff_profile_get(string $username): array
{
    $c = staff_profiles_container();
    $profiles = $c['profiles'] ?? [];
    $base = [
        'displayName' => $username,
        'email' => '',
        'phone' => '',
        'notes' => '',
    ];
    if (isset($profiles[$username]) && is_array($profiles[$username])) {
        return array_merge($base, $profiles[$username]);
    }
    return $base;
}

function staff_profile_save(string $username, array $fields): void
{
    $c = staff_profiles_container();
    if (!isset($c['profiles']) || !is_array($c['profiles'])) {
        $c['profiles'] = [];
    }
    $clean = [
        'displayName' => trim((string)($fields['displayName'] ?? '')),
        'email' => trim((string)($fields['email'] ?? '')),
        'phone' => trim((string)($fields['phone'] ?? '')),
        'notes' => trim((string)($fields['notes'] ?? '')),
    ];
    $c['profiles'][$username] = $clean;
    staff_write_json('profiles.json', $c);
}

function staff_users_container(): array
{
    staff_seed_if_missing();
    return staff_read_json('users.json', ['users' => []]);
}

function staff_users_save(array $container): void
{
    staff_write_json('users.json', $container);
}

function staff_find_user(string $username): ?array
{
    $users = staff_users_container()['users'] ?? [];
    foreach ($users as $user) {
        if (($user['username'] ?? '') === $username) {
            return $user;
        }
    }
    return null;
}

function staff_user_email(string $username): string
{
    $user = staff_find_user($username);
    return trim((string)($user['email'] ?? ''));
}

function staff_generate_verify_token(): string
{
    return bin2hex(random_bytes(24));
}

function staff_mark_user_verified(string $username): bool
{
    $user = staff_find_user($username);
    if (!$user) {
        return false;
    }
    $user['emailVerified'] = true;
    $user['verifyToken'] = '';
    $user['verifySentAt'] = date('c');
    staff_upsert_user($user);
    return true;
}

function staff_set_user_verify_token(string $username, string $token): bool
{
    $user = staff_find_user($username);
    if (!$user) {
        return false;
    }
    $user['verifyToken'] = $token;
    $user['verifySentAt'] = date('c');
    $user['emailVerified'] = !empty($user['emailVerified']) ? true : false;
    staff_upsert_user($user);
    return true;
}

function staff_verify_email_token(string $username, string $token): bool
{
    $user = staff_find_user($username);
    if (!$user) {
        return false;
    }
    $stored = (string)($user['verifyToken'] ?? '');
    if ($stored === '' || !hash_equals($stored, $token)) {
        return false;
    }
    return staff_mark_user_verified($username);
}

function staff_base_url(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    if ($scriptDir === '') {
        $scriptDir = '/';
    }
    return $scheme . '://' . $host . ($scriptDir === '/' ? '' : $scriptDir);
}

function staff_send_verification_email(string $toEmail, string $username, string $token): bool
{
    if ($toEmail === '') {
        return false;
    }
    $base = staff_base_url();
    $verifyUrl = $base . '/verify_email.php?u=' . rawurlencode($username) . '&token=' . rawurlencode($token);
    $subject = 'Verify your account email';
    $body = "Hi {$username},\n\nPlease verify your email before first login:\n{$verifyUrl}\n\nIf you did not request this, ignore this message.";
    $headers = "From: no-reply@restaurant.local\r\n";

    $sent = @mail($toEmail, $subject, $body, $headers);
    if (!$sent) {
        $logLine = date('c') . " | TO: {$toEmail} | USER: {$username} | VERIFY: {$verifyUrl}\n";
        file_put_contents(staff_json_path('email_outbox.log'), $logLine, FILE_APPEND);
    }
    return true;
}

function staff_upsert_user(array $user): void
{
    $container = staff_users_container();
    $users = $container['users'] ?? [];
    $found = false;
    foreach ($users as $i => $row) {
        if (($row['username'] ?? '') === ($user['username'] ?? '')) {
            $users[$i] = $user;
            $found = true;
            break;
        }
    }
    if (!$found) {
        if (!array_key_exists('emailVerified', $user)) {
            $user['emailVerified'] = false;
        }
        if (!array_key_exists('verifyToken', $user)) {
            $user['verifyToken'] = '';
        }
        if (!array_key_exists('verifySentAt', $user)) {
            $user['verifySentAt'] = '';
        }
        $users[] = $user;
    }
    $container['users'] = array_values($users);
    staff_users_save($container);
}

function staff_delete_user(string $username): bool
{
    $container = staff_users_container();
    $users = $container['users'] ?? [];
    $before = count($users);
    $users = array_values(array_filter($users, function ($row) use ($username) {
        return ($row['username'] ?? '') !== $username;
    }));
    $container['users'] = $users;
    staff_users_save($container);
    return $before !== count($users);
}

function staff_public_staff_list(): array
{
    $users = staff_users_container()['users'] ?? [];
    $out = [];
    foreach ($users as $u) {
        $username = (string)($u['username'] ?? '');
        if ($username === '') {
            continue;
        }
        $profile = staff_profile_get($username);
        $out[] = [
            'username' => $username,
            'role' => (string)($u['role'] ?? 'staff'),
            'displayName' => (string)($profile['displayName'] ?? $username),
            'email' => (string)($u['email'] ?? ($profile['email'] ?? '')),
            'phone' => (string)($profile['phone'] ?? ''),
            'emailVerified' => !empty($u['emailVerified']),
        ];
    }
    usort($out, function ($a, $b) {
        return strcmp($a['username'], $b['username']);
    });
    return $out;
}

function staff_compute_stats(array $orders): array
{
    $today = date('Y-m-d');
    $ordersToday = [];
    $revenue = 0.0;

    foreach ($orders as $o) {
        $placed = substr((string)($o['placed'] ?? ''), 0, 10);
        $st = (string)($o['status'] ?? '');
        if ($placed === $today && $st !== 'Cancelled') {
            $ordersToday[] = $o;
            $revenue += (float)str_replace(',', '', (string)($o['total'] ?? '0'));
        }
    }

    $pending = 0;
    foreach ($orders as $o) {
        if (in_array($o['status'] ?? '', ['New', 'Preparing'], true)) {
            $pending++;
        }
    }

    $avgPrep = 14;
    if ($pending > 0) {
        $avgPrep = min(28, (int)round(11 + ($pending * 1.8)));
    }

    return [
        'ordersToday' => count($ordersToday),
        'revenueToday' => number_format($revenue, 2, '.', ''),
        'pendingOrders' => $pending,
        'avgPrepMins' => $avgPrep,
        'updatedAt' => date('c'),
    ];
}
