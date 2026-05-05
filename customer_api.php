<?php
require_once __DIR__ . '/includes/staff_data.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

staff_seed_if_missing();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET') {
    $action = (string)($_GET['action'] ?? '');
    if ($action === 'orderStatus') {
        $id = trim((string)($_GET['id'] ?? ''));
        if ($id === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Missing order id']);
            exit();
        }
        $order = staff_find_order($id);
        if (!$order) {
            http_response_code(404);
            echo json_encode(['ok' => false, 'error' => 'Order not found']);
            exit();
        }
        echo json_encode([
            'ok' => true,
            'order' => [
                'id' => $order['id'],
                'status' => $order['status'] ?? 'New',
                'placed' => $order['placed'] ?? '',
                'channel' => $order['channel'] ?? '',
                'total' => $order['total'] ?? '0.00',
            ],
        ]);
        exit();
    }
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Unknown action']);
    exit();
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

$action = (string)($body['action'] ?? '');
$payload = isset($body['payload']) && is_array($body['payload']) ? $body['payload'] : [];

if ($action === 'placeOrder') {
    try {
        $order = staff_create_customer_order([
            'table' => $payload['table'] ?? '',
            'customer' => $payload['customerName'] ?? 'Guest',
            'itemsSummary' => $payload['itemsSummary'] ?? '',
            'total' => $payload['total'] ?? '0.00',
            'paymentMethod' => $payload['paymentMethod'] ?? '',
            'note' => $payload['note'] ?? '',
        ]);
        echo json_encode(['ok' => true, 'order' => $order]);
        exit();
    } catch (Throwable $e) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Could not place order']);
        exit();
    }
}

if ($action === 'submitFeedback') {
    try {
        $entry = staff_create_feedback([
            'name' => $payload['name'] ?? 'Guest',
            'email' => $payload['email'] ?? '',
            'message' => $payload['message'] ?? '',
        ]);
        echo json_encode(['ok' => true, 'feedback' => $entry]);
        exit();
    } catch (Throwable $e) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Could not submit feedback']);
        exit();
    }
}

http_response_code(400);
echo json_encode(['ok' => false, 'error' => 'Unknown action']);
