<?php
session_start(); require 'config.php';
if(!isset($_SESSION['user'])) die("Login first");
$uid=$_SESSION['user']['id'];

if($_SERVER['REQUEST_METHOD']==='POST'){
  $iid=$_POST['item_id'];
  $conn->query("INSERT INTO cart (user_id,item_id,qty) VALUES ($uid,$iid,1) ON DUPLICATE KEY UPDATE qty=qty+1");
}

$items=$conn->query("SELECT * FROM menu");
?>
<h2>Menu</h2>
<table border="1"><tr><th>Item</th><th>Price</th><th></th></tr>
<?php while($i=$items->fetch_assoc()): ?>
<tr>
  <td><?php echo $i['name'];?></td>
  <td><?php echo $i['price'];?></td>
  <td>
    <form method="post">
      <input type="hidden" name="item_id" value="<?php echo $i['id'];?>">
      <button>Add to Cart</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
<a href="cart.php">View Cart</a>
