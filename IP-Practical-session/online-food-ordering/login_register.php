<?php
session_start(); require 'config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=$_POST['email']; $pass=hash('sha256',$_POST['password']);
  $q=$conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
  $q->bind_param('ss',$email,$pass); $q->execute(); $res=$q->get_result();
  if($u=$res->fetch_assoc()){
    $_SESSION['user']=$u;
    if($u['role']=='admin') header("Location: admin.php");
    else header("Location: menu.php");
    exit;
  } else echo "Invalid login";
}
?>
<form method="post">
Email:<input name="email"><br>
Password:<input type="password" name="password"><br>
<button>Login</button>
</form>
<a href="register.php">Register</a>
