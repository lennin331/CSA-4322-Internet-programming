<?php
session_start(); require 'config.php';
if(!isset($_SESSION['user'])) die("Login first");
$uid=$_SESSION['user']['id'];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $pid=$_POST['property_id']; $msg=$_POST['msg'];
  $stmt=$conn->prepare("INSERT INTO inquiries (user_id,property_id,message) VALUES (?,?,?)");
  $stmt->bind_param('iis',$uid,$pid,$msg);
  $stmt->execute();
  echo "Inquiry sent! <a href='home.php'>Back</a>";
}
?>
