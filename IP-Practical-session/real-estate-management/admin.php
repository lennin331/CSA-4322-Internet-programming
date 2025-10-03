<?php
session_start(); require 'config.php';
if($_SESSION['user']['role']!=='admin') die("Admins only");

$props=$conn->query("SELECT * FROM properties");
$inq=$conn->query("SELECT i.id,u.name AS user,p.title,i.message,i.created_at 
FROM inquiries i JOIN users u ON u.id=i.user_id JOIN properties p ON p.id=i.property_id ORDER BY i.created_at DESC");
?>
<h2>Admin Dashboard</h2>

<h3>Properties</h3>
<table border="1"><tr><th>Title</th><th>Type</th><th>Price</th><th>Location</th></tr>
<?php while($p=$props->fetch_assoc()): ?>
<tr><td><?php echo $p['title'];?></td><td><?php echo $p['type'];?></td><td><?php echo $p['price'];?></td><td><?php echo $p['location'];?></td></tr>
<?php endwhile; ?>
</table>

<h3>Inquiries</h3>
<table border="1"><tr><th>User</th><th>Property</th><th>Message</th><th>Date</th></tr>
<?php while($i=$inq->fetch_assoc()): ?>
<tr><td><?php echo $i['user'];?></td><td><?php echo $i['title'];?></td><td><?php echo $i['message'];?></td><td><?php echo $i['created_at'];?></td></tr>
<?php endwhile; ?>
</table>
