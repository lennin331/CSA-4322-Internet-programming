<?php
require_once '../inc/auth.php'; require_login(); require_once '../inc/config.php';
$uid=$_SESSION['user']['id'];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $cake_id=(int)$_POST['cake_id'];
  $stmt=$conn->prepare("SELECT id FROM cart WHERE user_id=? AND cake_id=?");
  $stmt->bind_param('ii',$uid,$cake_id); $stmt->execute();
  $r=$stmt->get_result();
  if($r->num_rows>0){
    $conn->query("UPDATE cart SET qty=qty+1 WHERE user_id=$uid AND cake_id=$cake_id");
  } else {
    $conn->query("INSERT INTO cart (user_id,cake_id,qty) VALUES ($uid,$cake_id,1)");
  }
  header('Location: cart.php'); exit;
}
$items=$conn->query("SELECT c.id, ck.name, ck.price, c.qty FROM cart c JOIN cakes ck ON ck.id=c.cake_id WHERE c.user_id=$uid");
?>
<!doctype html><html><body>
<h2>My Cart</h2>
<table border="1"><tr><th>Cake</th><th>Qty</th><th>Price</th></tr>
<?php $total=0; while($i=$items->fetch_assoc()): $total+=$i['qty']*$i['price'];?>
<tr><td><?php echo $i['name'];?></td><td><?php echo $i['qty'];?></td><td><?php echo $i['qty']*$i['price'];?></td></tr>
<?php endwhile; ?>
</table>
<p>Total: <?php echo $total;?></p>
<form method="post" action="checkout.php"><button>Checkout</button></form>
</body></html>
