<?php
require 'config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=$_POST['name']; $email=$_POST['email']; $pass=hash('sha256',$_POST['password']);
  $stmt=$conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,'patient')");
  $stmt->bind_param('sss',$name,$email,$pass);
  if($stmt->execute()) echo "Registered. <a href='login.php'>Login</a>";
  else echo "Failed (maybe email exists).";
}
?>
<form method="post">
Name: <input name="name"><br>
Email: <input name="email"><br>
Password: <input type="password" name="password"><br>
<button>Register</button>
</form>
