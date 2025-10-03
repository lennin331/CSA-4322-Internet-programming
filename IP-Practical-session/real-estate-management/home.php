<?php
session_start(); require 'config.php';
if(!isset($_SESSION['user'])) die("Login first");
$props=$conn->query("SELECT * FROM properties");
?>
<h2>Available Properties</h2>
<table border="1"><tr><th>Title</th><th>Type</th><th>Price</th><th>Location</th><th></th></tr>
<?php while($p=$props->fetch_assoc()): ?>
<tr>
  <td><?php echo $p['title'];?></td>
  <td><?php echo $p['type'];?></td>
  <td><?php echo $p['price'];?></td>
  <td><?php echo $p['location'];?></td>
  <td>
    <form method="post" action="inquiry.php">
      <input type="hidden" name="property_id" value="<?php echo $p['id'];?>">
      <input name="msg" placeholder="Message">
      <button>Send Inquiry</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
