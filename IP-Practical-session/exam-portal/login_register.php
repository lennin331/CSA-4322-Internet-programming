<?php
session_start();
$conn=new mysqli("localhost","root","","exam_db");
if($conn->connect_error) die("DB failed");

// Registration
if(isset($_POST['register'])){
  $name=$_POST['name']; $email=$_POST['email']; $pass=hash('sha256',$_POST['password']);
  $stmt=$conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
  $stmt->bind_param("sss",$name,$email,$pass);
  if($stmt->execute()) echo "Registered! Please login.<br>";
  else echo "Registration failed.<br>";
}

// Login
if(isset($_POST['login'])){
  $email=$_POST['email']; $pass=hash('sha256',$_POST['password']);
  $stmt=$conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
  $stmt->bind_param("ss",$email,$pass);
  $stmt->execute(); $res=$stmt->get_result();
  if($u=$res->fetch_assoc()){
    $_SESSION['user']=$u;
    header("Location: exam.php"); exit;
  } else echo "Invalid login<br>";
}
?>
<h2>Register</h2>
<form method="post">
Name: <input name="name"><br>
Email: <input name="email"><br>
Password: <input type="password" name="password"><br>
<button name="register">Register</button>
</form>

<h2>Login</h2>
<form method="post">
Email: <input name="email"><br>
Password: <input type="password" name="password"><br>
<button name="login">Login</button>
</form>
