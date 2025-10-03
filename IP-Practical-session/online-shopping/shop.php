<?php
session_start(); require 'config.php';
if(!isset($_SESSION['user'])) die("Login first");
$uid=$_SESSION['user']['id'];

if($_SERVER['REQUEST_METHOD']==='POST'){
  $pid=$_POST['product_id'];
  $conn->query("INSERT INTO cart (user_id,product_id,qty) VALUES ($uid,$pid,1) ON DUPLICATE KEY UPDATE qty=qty+1");
}

$products=$conn->query("SELECT * FROM products");
?>
<h2>Products</h2>
<table border="1"><tr><th>Name</th><th>Price</th><th></th></tr>
<?php while($p=$products->fetch_assoc()): ?>
<tr>
  <td><?php echo $p['name'];?></td>
  <td><?php echo $p['price'];?></td>
  <td>
    <form method="post">
      <input type="hidden" name="product_id" value="<?php echo $p['id'];?>">
      <button>Add to Cart</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
<a href="cart.php">View Cart</a>
