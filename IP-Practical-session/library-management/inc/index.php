<?php
// index.php (login)
require_once __DIR__ . '/inc/config.php';
session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    if ($email === '' || $pass === '') {
        $err = "Enter email and password.";
    } else {
        // Use SHA-256 comparison (consistent with seed)
        $hash = hash('sha256', $pass);

        $stmt = $conn->prepare("SELECT id,name,email,role,password FROM users WHERE email=? LIMIT 1");
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            // compare using stored SHA2 (from seed) OR if stored by password_hash adapt accordingly
            if ($row['password'] === $hash || hash('sha256',$pass) === $row['password']) {
                // success
                $_SESSION['user'] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'role' => $row['role']
                ];
                if ($row['role'] === 'admin') {
                    header('Location: admin/dashboard.php');
                } else {
                    header('Location: user/dashboard.php');
                }
                exit;
            } else {
                $err = "Invalid credentials.";
            }
        } else {
            $err = "Invalid credentials.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Library - Login</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <h2>Library System — Login</h2>
  <?php if($err): ?><p style="color:red;"><?php echo htmlentities($err); ?></p><?php endif; ?>
  <form method="post">
    <label>Email:<br><input type="email" name="email" required></label><br>
    <label>Password:<br><input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
  </form>
  <p>Or <a href="register.php">Register as student</a></p>
</body>
</html>
