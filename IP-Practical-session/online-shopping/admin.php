<?php
session_start(); require 'config.php';
if($_SESSION['user']['role']!=='admin') die("Admins only");
$orders=$conn->query("SELECT o.id,u.name,o.total,o.status,o.created_at FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.id DESC");
?>
<h2>All Orders</h2>
<table border="1">
<tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th></tr>
<?php while($o=$orders->fetch_assoc()): ?>
<tr>
  <td><?php echo $o['id'];?></td>
  <td><?php echo $o['name'];?></td>
  <td><?php echo $o['total'];?></td>
  <td><?php echo $o['status'];?></td>
  <td><?php echo $o['created_at'];?></td>
</tr>
<?php endwhile; ?>
</table>
