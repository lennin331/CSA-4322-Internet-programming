<?php
session_start();
if(!isset($_SESSION['user'])) die("Login first <a href='login_register.php'>Go</a>");

$conn=new mysqli("localhost","root","","exam_db");
if($conn->connect_error) die("DB failed");

if($_SERVER['REQUEST_METHOD']==='POST'){
  $score=0;
  $qres=$conn->query("SELECT * FROM questions");
  while($q=$qres->fetch_assoc()){
    if(isset($_POST['q'.$q['id']]) && $_POST['q'.$q['id']] == $q['answer']){
      $score++;
    }
  }
  $uid=$_SESSION['user']['id'];
  $stmt=$conn->prepare("INSERT INTO results (user_id,score) VALUES (?,?)");
  $stmt->bind_param("ii",$uid,$score); $stmt->execute();
  echo "<h2>Your Score: $score</h2>";
  echo "<a href='exam.php'>Take again</a> | <a href='login_register.php'>Logout</a>";
  exit;
}

$qres=$conn->query("SELECT * FROM questions");
?>
<h2>Online Exam</h2>
<form method="post">
<?php while($q=$qres->fetch_assoc()): ?>
<p><?php echo $q['question']; ?></p>
<input type="radio" name="q<?php echo $q['id'];?>" value="1"> <?php echo $q['opt1']; ?><br>
<input type="radio" name="q<?php echo $q['id'];?>" value="2"> <?php echo $q['opt2']; ?><br>
<input type="radio" name="q<?php echo $q['id'];?>" value="3"> <?php echo $q['opt3']; ?><br>
<input type="radio" name="q<?php echo $q['id'];?>" value="4"> <?php echo $q['opt4']; ?><br>
<?php endwhile; ?>
<button>Submit Exam</button>
</form>
