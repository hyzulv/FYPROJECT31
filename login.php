   <?php
// 1. Start a session to keep the user logged in
session_start();

// 2. Configuration: Replace these with your actual database or desired credentials
$valid_username = "admin";
$valid_password = "password123"; 

$error_message = "";

// 3. Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 4. Simple validation logic
    if ($username === $valid_username && $password === $valid_password) {
        // Success! Set session variables and redirect
        $_SESSION['user'] = $username;
        header("Location: dashboard.php"); // Change this to your actual landing page
        exit();
    } else {
        // Failure
        $error_message = "Invalid username or password!";
    }
}
?>
   
   <!DOCTYPE html>
<html>
<head>
    <title>Mat Rock Login</title>

    <style>

    body{
        font-family: Arial;
        background: #111;
    }

    .login-box{
        width: 350px;
        margin: 100px auto;
        background: #1e1e1e;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px red;
    }

    h2{
        text-align: center;
        color: red;
        margin-bottom: 20px;
    }

    input{
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        border: 1px solid #444;
        background: #2b2b2b;
        color: white;
        border-radius: 5px;
    }

    input::placeholder{
        color: #bbb;
    }

    button{
        width: 100%;
        padding: 12px;
        margin-top: 18px;
        background: red;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    button:hover{
        background: darkred;
    }

</style>
</head>

<body>

<div class="login-box">
    <h2>Staff / Admin Login</h2>

    <form action="login.php" method="POST">

        <input type="text" name="username" placeholder="Enter Username" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit">Login</button>

    </form>
</div>

</body>
</html>