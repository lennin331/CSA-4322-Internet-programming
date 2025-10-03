<?php
session_start(); require 'config.php';
$uid=$_SESSION['user']['id'];
$res=$conn->query("SELECT c.id, p.name, p.price, c.qty FROM cart c JOIN products p ON p.id=c.product_id WHERE user_id=$uid");
$total=0; $items=[];
while($r=$res->fetch_assoc()){ $items[]=$r; $total+=$r['qty']*$r['price']; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  $conn->query("INSERT INTO orders (user_id,total) VALUES ($uid,$total)");
  $oid=$conn->insert_id;
  foreach($items as $i){
    $conn->query("INSERT INTO order_items (order_id,product_id,qty,price) VALUES ($oid,{$i['id']},{$i['qty']},{$i['price']})");
  }
  $conn->query("DELETE FROM cart WHERE user_id=$uid");
  echo "Order placed!";
}
?>
<h2>My Cart</h2>
<table border="1"><tr><th>Product</th><th>Qty</th><th>Price</th></tr>
<?php foreach($items as $i): ?>
<tr><td><?php echo $i['name'];?></td><td><?php echo $i['qty'];?></td><td><?php echo $i['qty']*$i['price'];?></td></tr>
<?php endforeach; ?>
</table>
<p>Total: <?php echo $total;?></p>
<form method="post"><button>Checkout</button></form>
