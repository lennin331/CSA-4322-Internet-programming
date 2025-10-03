<?php
require_once '../inc/auth.php'; require_login(); require_once '../inc/config.php';
$uid=$_SESSION['user']['id'];
$res=$conn->query("SELECT c.*, ck.price FROM cart c JOIN cakes ck ON ck.id=c.cake_id WHERE user_id=$uid");
$items=$res->fetch_all(MYSQLI_ASSOC); $total=0;
foreach($items as $i){ $total+=$i['qty']*$i['price']; }
$addr=$_SESSION['user']['address']??'';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $stmt=$conn->prepare("INSERT INTO orders (user_id,total_amount,shipping_address) VALUES (?,?,?)");
  $stmt->bind_param('ids',$uid,$total,$_POST['address']);
  if($stmt->execute()){
    $oid=$stmt->insert_id;
    foreach($items as $i){
      $q=$conn->prepare("INSERT INTO order_items (order_id,cake_id,qty,price) VALUES (?,?,?,?)");
      $q->bind_param('iiid',$oid,$i['cake_id'],$i['qty'],$i['price']);
      $q->execute(); $q->close();
    }
    $conn->query("DELETE FROM cart WHERE user_id=$uid");
    header('Location: my_orders.php'); exit;
  }
}
?>
<!doctype html><html><body>
<h2>Checkout</h2>
<form method="post">
Address:<br>
<textarea name="address" required><?php echo $addr;?></textarea><br>
<button>Place Order (<?php echo $total;?>)</button>
</form>
</body></html>
