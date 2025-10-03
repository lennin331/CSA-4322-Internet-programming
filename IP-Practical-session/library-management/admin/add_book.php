<?php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/config.php';

$err = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $year = $_POST['year'] ?: null;
    $copies = max(1,(int)$_POST['copies']);

    if ($title=='' || $author=='') $err = "Title and author required.";
    else {
        $stmt = $conn->prepare("INSERT INTO books (title,author,isbn,year,copies,available) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('sssiii', $title, $author, $isbn, $year, $copies, $copies);
        if ($stmt->execute()) $success = "Book added.";
        else $err = "Insert failed.";
        $stmt->close();
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Add Book</title></head><body>
  <h2>Add Book</h2>
  <p><a href="dashboard.php">Back</a></p>
  <?php if($err) echo "<p style='color:red;'>$err</p>"; ?>
  <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>
  <form method="post">
    <label>Title<br><input name="title" required></label><br>
    <label>Author<br><input name="author" required></label><br>
    <label>ISBN<br><input name="isbn"></label><br>
    <label>Year<br><input name="year" type="number" min="1900" max="2099"></label><br>
    <label>Copies<br><input name="copies" type="number" value="1" min="1"></label><br>
    <button>Add Book</button>
  </form>
</body></html>
