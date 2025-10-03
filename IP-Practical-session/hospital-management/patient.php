<?php
session_start(); require 'config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='patient') die("Login as patient first");
$uid=$_SESSION['user']['id'];

if($_SERVER['REQUEST_METHOD']==='POST'){
  $doc=$_POST['doctor']; $date=$_POST['date']; $time=$_POST['time'];
  $stmt=$conn->prepare("INSERT INTO appointments (user_id,doctor_id,date,time) VALUES (?,?,?,?)");
  $stmt->bind_param('iiss',$uid,$doc,$date,$time);
  $stmt->execute();
  echo "Appointment booked!";
}

$docs=$conn->query("SELECT * FROM doctors");
$apps=$conn->query("SELECT a.id,d.name,a.date,a.time,a.status FROM appointments a JOIN doctors d ON d.id=a.doctor_id WHERE a.user_id=$uid");
?>
<h2>Book Appointment</h2>
<form method="post">
Doctor: <select name="doctor">
<?php while($d=$docs->fetch_assoc()): ?>
<option value="<?php echo $d['id'];?>"><?php echo $d['name']." (".$d['specialty'].")";?></option>
<?php endwhile;?>
</select><br>
Date: <input type="date" name="date"><br>
Time: <input type="time" name="time"><br>
<button>Book</button>
</form>

<h2>My Appointments</h2>
<table border="1">
<tr><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
<?php while($a=$apps->fetch_assoc()): ?>
<tr><td><?php echo $a['name'];?></td><td><?php echo $a['date'];?></td><td><?php echo $a['time'];?></td><td><?php echo $a['status'];?></td></tr>
<?php endwhile;?>
</table>
