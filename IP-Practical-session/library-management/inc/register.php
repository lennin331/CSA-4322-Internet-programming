<?php
// register.php
require_once __DIR__ . '/inc/config.php';
session_start();

$err = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    if ($name=='' || $email=='' || $pass=='') $err = "Fill all fields.";
    else {
        // check exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows>0) $err = "Email already registered.";
        else {
            $hash = hash('sha256', $pass); // for demo, use password_hash in real apps
            $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?, 'student')");
            $stmt->bind_param('sss', $name, $email, $hash);
            if ($stmt->execute()) {
                $success = "Registered. You can <a href='index.php'>login</a> now.";
            } else {
                $err = "Registration failed.";
            }
            $stmt->close();
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body>
  <h2>Register (Student)</h2>
  <?php if($err): ?><p style="color:red;"><?php echo $err; ?></p><?php endif; ?>
  <?php if($success): ?><p style="color:green;"><?php echo $success; ?></p><?php endif; ?>
  <form method="post">
    <label>Name:<br><input name="name" required></label><br>
    <label>Email:<br><input type="email" name="email" required></label><br>
    <label>Password:<br><input type="password" name="password" required></label><br>
    <button>Register</button>
  </form>
</body>
</html>
