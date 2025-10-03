<?php
require_once 'inc/config.php';
$cat = $_GET['cat'] ?? 0;
if($cat){
  $stmt=$conn->prepare("SELECT * FROM cakes WHERE category_id=?");
  $stmt->bind_param('i',$cat);
}else{
  $stmt=$conn->prepare("SELECT * FROM cakes");
}
$stmt->execute(); $res=$stmt->get_result();
$cats=$conn->query("SELECT * FROM categories");
?>
<!doctype html><html><body>
<h2>Cake Shop</h2>
<nav>
<?php while($c=$cats->fetch_assoc()): ?>
  <a href="?cat=<?php echo $c['id'];?>"><?php echo $c['name'];?></a> |
<?php endwhile; ?>
</nav>
<table border="1">
<tr><th>Name</th><th>Price</th><th>Action</th></tr>
<?php while($cake=$res->fetch_assoc()): ?>
<tr>
  <td><?php echo $cake['name'];?></td>
  <td><?php echo $cake['price'];?></td>
  <td>
    <form method="post" action="user/cart.php">
      <input type="hidden" name="cake_id" value="<?php echo $cake['id'];?>">
      <button>Add to Cart</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
</body></html>
