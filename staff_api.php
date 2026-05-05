<?php
session_start();

require_once __DIR__ . '/includes/staff_data.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
    exit();
}

staff_seed_if_missing();

$username = (string)$_SESSION['user'];
$role = (string)($_SESSION['role'] ?? 'staff');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

function deny_if_no_permission(string $role, string $permission): void
{
    if (!staff_has_permission($role, $permission)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Forbidden']);
        exit();
    }
}

if ($method === 'GET') {
    $type = $_GET['type'] ?? '';
    switch ($type) {
        case 'bootstrap':
            echo json_encode([
                'ok' => true,
                'csrf' => staff_ensure_csrf(),
                'user' => $username,
                'role' => $role,
                'permissions' => staff_role_permissions($role),
                'stats' => staff_compute_stats(staff_orders_container()['orders'] ?? []),
                'orders' => staff_orders_list(),
                'menu' => staff_menu_container()['items'] ?? [],
                'feedback' => staff_feedback_list(),
                'profile' => staff_profile_get($username),
                'staff' => staff_has_permission($role, 'view.staff') ? staff_public_staff_list() : [],
            ]);
            exit();
        default:
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Unknown type']);
            exit();
    }
}

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit();
}

$raw = file_get_contents('php://input');
$body = [];
if ($raw !== false && $raw !== '') {
    $body = json_decode($raw, true);
}
if (!is_array($body)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid JSON']);
    exit();
}

if (!staff_verify_csrf($body['csrf'] ?? null)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Invalid CSRF token']);
    exit();
}

$action = (string)($body['action'] ?? '');
$p = isset($body['payload']) && is_array($body['payload']) ? $body['payload'] : [];

try {
    switch ($action) {
        case 'profile.update':
            deny_if_no_permission($role, 'edit.profile');
            staff_profile_save($username, [
                'displayName' => $p['displayName'] ?? '',
                'email' => $p['email'] ?? '',
                'phone' => $p['phone'] ?? '',
                'notes' => $p['notes'] ?? '',
            ]);
            echo json_encode(['ok' => true, 'profile' => staff_profile_get($username)]);
            exit();

        case 'password.change':
            deny_if_no_permission($role, 'change.password');
            $current = (string)($p['currentPassword'] ?? '');
            $next = (string)($p['newPassword'] ?? '');
            if (strlen($next) < 6) {
                echo json_encode(['ok' => false, 'error' => 'New password must be at least 6 characters']);
                exit();
            }
            $user = staff_find_user($username);
            if (!$user || !hash_equals((string)($user['password'] ?? ''), $current)) {
                echo json_encode(['ok' => false, 'error' => 'Current password is incorrect']);
                exit();
            }
            $user['password'] = $next;
            staff_upsert_user($user);
            echo json_encode(['ok' => true]);
            exit();

        case 'order.create': {
            deny_if_no_permission($role, 'edit.order');
            $container = staff_orders_container();
            $seq = (int)($container['nextSeq'] ?? 1001);
            $id = 'ORD-' . $seq;
            $container['nextSeq'] = $seq + 1;
            $status = (string)($p['status'] ?? 'New');
            if (!in_array($status, staff_valid_order_statuses(), true)) {
                $status = 'New';
            }
            $order = [
                'id' => $id,
                'channel' => trim((string)($p['channel'] ?? '')),
                'customer' => trim((string)($p['customer'] ?? '')),
                'items' => trim((string)($p['items'] ?? '')),
                'status' => $status,
                'placed' => trim((string)($p['placed'] ?? '')) ?: date('Y-m-d H:i:s'),
                'total' => trim((string)($p['total'] ?? '0.00')),
            ];
            if ($order['channel'] === '' || $order['items'] === '') {
                echo json_encode(['ok' => false, 'error' => 'Channel and items are required']);
                exit();
            }
            $container['orders'][] = $order;
            staff_orders_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'order.update': {
            deny_if_no_permission($role, 'edit.order');
            $id = (string)($p['id'] ?? '');
            if ($id === '') {
                echo json_encode(['ok' => false, 'error' => 'Missing order id']);
                exit();
            }
            $container = staff_orders_container();
            $found = false;
            foreach ($container['orders'] as $i => $o) {
                if (($o['id'] ?? '') === $id) {
                    $status = (string)($p['status'] ?? $o['status']);
                    if (!in_array($status, staff_valid_order_statuses(), true)) {
                        $status = (string)$o['status'];
                    }
                    $container['orders'][$i] = [
                        'id' => $id,
                        'channel' => trim((string)($p['channel'] ?? $o['channel'])),
                        'customer' => trim((string)($p['customer'] ?? $o['customer'])),
                        'items' => trim((string)($p['items'] ?? $o['items'])),
                        'status' => $status,
                        'placed' => trim((string)($p['placed'] ?? $o['placed'])),
                        'total' => trim((string)($p['total'] ?? $o['total'])),
                    ];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo json_encode(['ok' => false, 'error' => 'Order not found']);
                exit();
            }
            staff_orders_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'order.delete': {
            deny_if_no_permission($role, 'delete.order');
            $id = (string)($p['id'] ?? '');
            if ($id === '') {
                echo json_encode(['ok' => false, 'error' => 'Missing order id']);
                exit();
            }
            $container = staff_orders_container();
            $container['orders'] = array_values(array_filter(
                $container['orders'] ?? [],
                function ($o) use ($id) {
                    return ($o['id'] ?? '') !== $id;
                }
            ));
            staff_orders_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'order.setStatus': {
            deny_if_no_permission($role, 'update.order.status');
            $id = (string)($p['id'] ?? '');
            $status = (string)($p['status'] ?? '');
            if ($id === '' || !in_array($status, staff_valid_order_statuses(), true)) {
                echo json_encode(['ok' => false, 'error' => 'Invalid order or status']);
                exit();
            }
            $container = staff_orders_container();
            $found = false;
            foreach ($container['orders'] as $i => $o) {
                if (($o['id'] ?? '') === $id) {
                    $container['orders'][$i]['status'] = $status;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo json_encode(['ok' => false, 'error' => 'Order not found']);
                exit();
            }
            staff_orders_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'menu.create': {
            deny_if_no_permission($role, 'add.menu');
            $container = staff_menu_container();
            $seq = (int)($container['nextSeq'] ?? 1);
            $mid = 'M-' . str_pad((string)$seq, 3, '0', STR_PAD_LEFT);
            $container['nextSeq'] = $seq + 1;
            $item = [
                'id' => $mid,
                'name' => trim((string)($p['name'] ?? '')),
                'category' => trim((string)($p['category'] ?? 'Food')),
                'price' => trim((string)($p['price'] ?? '0.00')),
                'description' => trim((string)($p['description'] ?? '')),
                'available' => array_key_exists('available', $p) ? (bool)$p['available'] : true,
            ];
            if ($item['name'] === '') {
                echo json_encode(['ok' => false, 'error' => 'Menu name required']);
                exit();
            }
            $container['items'][] = $item;
            staff_menu_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'menu.update': {
            deny_if_no_permission($role, 'edit.menu');
            $id = (string)($p['id'] ?? '');
            if ($id === '') {
                echo json_encode(['ok' => false, 'error' => 'Missing menu id']);
                exit();
            }
            $container = staff_menu_container();
            $found = false;
            foreach ($container['items'] as $i => $row) {
                if (($row['id'] ?? '') === $id) {
                    $container['items'][$i] = [
                        'id' => $id,
                        'name' => trim((string)($p['name'] ?? $row['name'])),
                        'category' => trim((string)($p['category'] ?? $row['category'])),
                        'price' => trim((string)($p['price'] ?? $row['price'])),
                        'description' => trim((string)($p['description'] ?? $row['description'])),
                        'available' => array_key_exists('available', $p) ? !empty($p['available']) : !empty($row['available']),
                    ];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo json_encode(['ok' => false, 'error' => 'Menu item not found']);
                exit();
            }
            staff_menu_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'menu.delete': {
            deny_if_no_permission($role, 'delete.menu');
            $id = (string)($p['id'] ?? '');
            if ($id === '') {
                echo json_encode(['ok' => false, 'error' => 'Missing menu id']);
                exit();
            }
            $container = staff_menu_container();
            $container['items'] = array_values(array_filter(
                $container['items'] ?? [],
                function ($row) use ($id) {
                    return ($row['id'] ?? '') !== $id;
                }
            ));
            staff_menu_save($container);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'staff.create': {
            deny_if_no_permission($role, 'add.staff');
            $newUsername = trim((string)($p['username'] ?? ''));
            $newPassword = (string)($p['password'] ?? '');
            $newRole = (string)($p['role'] ?? 'staff');
            $newEmail = trim((string)($p['email'] ?? ''));
            if ($newUsername === '' || $newPassword === '') {
                echo json_encode(['ok' => false, 'error' => 'Username and password are required']);
                exit();
            }
            if ($newEmail === '' || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['ok' => false, 'error' => 'Valid email is required']);
                exit();
            }
            if (!preg_match('/^[a-zA-Z0-9_.-]{3,32}$/', $newUsername)) {
                echo json_encode(['ok' => false, 'error' => 'Username format is invalid']);
                exit();
            }
            if (!in_array($newRole, ['staff', 'admin'], true)) {
                $newRole = 'staff';
            }
            if (staff_find_user($newUsername)) {
                echo json_encode(['ok' => false, 'error' => 'Username already exists']);
                exit();
            }
            staff_upsert_user([
                'username' => $newUsername,
                'password' => $newPassword,
                'role' => $newRole,
                'email' => $newEmail,
                'emailVerified' => false,
                'verifyToken' => '',
                'verifySentAt' => '',
            ]);
            $token = staff_generate_verify_token();
            staff_set_user_verify_token($newUsername, $token);
            staff_send_verification_email($newEmail, $newUsername, $token);
            staff_profile_save($newUsername, [
                'displayName' => $p['displayName'] ?? $newUsername,
                'email' => $newEmail,
                'phone' => $p['phone'] ?? '',
                'notes' => $p['notes'] ?? '',
            ]);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'staff.update': {
            deny_if_no_permission($role, 'edit.staff');
            $targetUsername = trim((string)($p['username'] ?? ''));
            if ($targetUsername === '') {
                echo json_encode(['ok' => false, 'error' => 'Username is required']);
                exit();
            }
            $target = staff_find_user($targetUsername);
            if (!$target) {
                echo json_encode(['ok' => false, 'error' => 'Staff user not found']);
                exit();
            }
            $target['role'] = in_array(($p['role'] ?? ''), ['staff', 'admin'], true) ? $p['role'] : $target['role'];
            $newEmail = trim((string)($p['email'] ?? ($target['email'] ?? '')));
            if ($newEmail !== '' && !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['ok' => false, 'error' => 'Invalid email format']);
                exit();
            }
            $oldEmail = (string)($target['email'] ?? '');
            $target['email'] = $newEmail;
            $newPassword = (string)($p['password'] ?? '');
            if ($newPassword !== '') {
                $target['password'] = $newPassword;
            }
            if ($newEmail !== '' && $newEmail !== $oldEmail) {
                $target['emailVerified'] = false;
                $token = staff_generate_verify_token();
                $target['verifyToken'] = $token;
                $target['verifySentAt'] = date('c');
                staff_send_verification_email($newEmail, $targetUsername, $token);
            }
            staff_upsert_user($target);
            staff_profile_save($targetUsername, [
                'displayName' => $p['displayName'] ?? '',
                'email' => $newEmail,
                'phone' => $p['phone'] ?? '',
                'notes' => $p['notes'] ?? '',
            ]);
            echo json_encode(['ok' => true]);
            exit();
        }

        case 'staff.delete': {
            deny_if_no_permission($role, 'delete.staff');
            $targetUsername = trim((string)($p['username'] ?? ''));
            if ($targetUsername === '' || $targetUsername === $username) {
                echo json_encode(['ok' => false, 'error' => 'Cannot delete this account']);
                exit();
            }
            $deleted = staff_delete_user($targetUsername);
            if (!$deleted) {
                echo json_encode(['ok' => false, 'error' => 'Staff user not found']);
                exit();
            }
            echo json_encode(['ok' => true]);
            exit();
        }

        default:
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Unknown action']);
            exit();
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
    exit();
}
