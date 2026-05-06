<?php
session_start();
require_once __DIR__ . '/includes/staff_data.php';
staff_seed_if_missing();

$message = '';
$error = '';
$pendingUser = (string)($_SESSION['pending_verify_user'] ?? '');

if (isset($_GET['u'], $_GET['token'])) {
    $u = trim((string)$_GET['u']);
    $token = trim((string)$_GET['token']);
    if ($u !== '' && $token !== '' && staff_verify_email_token($u, $token)) {
        if ($pendingUser === $u) {
            unset($_SESSION['pending_verify_user']);
        }
        $message = 'Email verified successfully. You can now login.';
    } else {
        $error = 'Verification link is invalid or expired.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'resend') {
    $u = trim((string)($_POST['username'] ?? $pendingUser));
    $user = staff_find_user($u);
    if (!$user) {
        $error = 'User not found.';
    } elseif (!empty($user['emailVerified'])) {
        $message = 'Email is already verified. Please login.';
    } else {
        $email = trim((string)($user['email'] ?? ''));
        if ($email === '') {
            $error = 'No email found for this account. Ask admin to update your email.';
        } else {
            $token = staff_generate_verify_token();
            staff_set_user_verify_token($u, $token);
            staff_send_verification_email($email, $u, $token);
            $_SESSION['pending_verify_user'] = $u;
            $pendingUser = $u;
            $message = 'Verification email sent. Please check your inbox.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #111; color: #eee; display:flex; min-height:100vh; align-items:center; justify-content:center; }
        .box { width:min(520px, 94vw); background:#1b1b1b; border:1px solid #333; border-radius:12px; padding:22px; }
        h1 { margin:0 0 10px; color:#fff; font-size:1.4rem; }
        p { color:#bbb; }
        .msg { background:#18321b; border:1px solid #2f6c35; color:#98ea9f; padding:10px; border-radius:8px; margin-bottom:12px; }
        .err { background:#3a1717; border:1px solid #783232; color:#ff9f9f; padding:10px; border-radius:8px; margin-bottom:12px; }
        label { display:block; font-size:.85rem; color:#aaa; margin:10px 0 6px; }
        input { width:100%; padding:10px; border-radius:6px; border:1px solid #444; background:#101010; color:#fff; }
        .row { display:flex; gap:8px; flex-wrap:wrap; margin-top:14px; }
        button, a { padding:10px 14px; border-radius:7px; border:none; text-decoration:none; font-weight:bold; cursor:pointer; }
        button { background:#c00; color:#fff; }
        a { background:#333; color:#fff; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Verify your email</h1>
        <p>Your account must be verified before first login.</p>
        <?php if ($message !== ''): ?><div class="msg"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        <?php if ($error !== ''): ?><div class="err"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

        <form method="POST" action="verify_email.php">
            <input type="hidden" name="action" value="resend">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" value="<?php echo htmlspecialchars($pendingUser, ENT_QUOTES, 'UTF-8'); ?>" required>
            <div class="row">
                <button type="submit">Resend verification email</button>
                <a href="login.php">Back to login</a>
            </div>
        </form>
    </div>
</body>
</html>
