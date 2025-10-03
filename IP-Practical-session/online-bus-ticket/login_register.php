<?php
// login.php
require_once 'inc/config.php';
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    if ($email === '' || $pass === '') $err = "Enter credentials.";
    else {
        $stmt = $conn->prepare("SELECT id,name,email,role,password FROM users WHERE email=? LIMIT 1");
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if ($row['password'] === hash('sha256',$pass)) {
                $_SESSION['user'] = ['id'=>$row['id'],'name'=>$row['name'],'email'=>$row['email'],'role'=>$row['role']];
                if ($row['role']==='admin') header('Location: admin/dashboard.php');
                else header('Location: user/dashboard.php');
                exit;
            } else $err = "Invalid credentials.";
        } else $err = "Invalid credentials.";
    }
}
?>
<!-- simple HTML login form below -->
