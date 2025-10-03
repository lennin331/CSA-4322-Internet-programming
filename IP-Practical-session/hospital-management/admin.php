<?php
session_start(); require 'config.php';
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='admin') die("Login as admin first");
$res=$conn->query("SELECT a.id,u.name AS patient,d.name AS doctor,a.date,a.time,a.status 
FROM appointments a 
JOIN users u ON u.id=a.user_id 
JOIN doctors d ON d.id=a.doctor_id ORDER BY a.date");
?>
<h2>All Appointments</h2>
<table border="1">
<tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
<?php while($r=$res->fetch_assoc()): ?>
<tr><td><?php echo $r['patient'];?></td><td><?php echo $r['doctor'];?></td><td><?php echo $r['date'];?></td><td><?php echo $r['time'];?></td><td><?php echo $r['status'];?></td></tr>
<?php endwhile;?>
</table>
