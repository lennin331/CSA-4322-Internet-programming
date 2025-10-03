<?php
session_start();
if(!isset($_SESSION['user'])) die("Login first <a href='login_register.php'>Go</a>");

$conn=new mysqli("localhost","root","","result_db");
if($conn->connect_error) die("DB failed");

// Admin can add results
if($_SESSION['user']['role']=='admin' && isset($_POST['add'])){
  $sname=$_POST['student_name']; $sub=$_POST['subject']; $marks=$_POST['marks'];
  $stmt=$conn->prepare("INSERT INTO results (student_name,subject,marks) VALUES (?,?,?)");
  $stmt->bind_param("ssi",$sname,$sub,$marks);
  $stmt->execute();
  echo "Result added!<br>";
}

// Show all results
$res=$conn->query("SELECT * FROM results ORDER BY created_at DESC");
?>
<h2>Welcome <?php echo $_SESSION['user']['name'];?> (<?php echo $_SESSION['user']['role'];?>)</h2>
<a href="login_register.php">Logout</a>

<?php if($_SESSION['user']['role']=='admin'): ?>
<h3>Add Result</h3>
<form method="post">
Student Name:<input name="student_name"><br>
Subject:<input name="subject"><br>
Marks:<input type="number" name="marks"><br>
<button name="add">Add</button>
</form>
<?php endif; ?>

<h3>Results</h3>
<table border="1">
<tr><th>Student</th><th>Subject</th><th>Marks</th><th>Date</th></tr>
<?php while($r=$res->fetch_assoc()): ?>
<tr>
  <td><?php echo $r['student_name'];?></td>
  <td><?php echo $r['subject'];?></td>
  <td><?php echo $r['marks'];?></td>
  <td><?php echo $r['created_at'];?></td>
</tr>
<?php endwhile; ?>
</table>
