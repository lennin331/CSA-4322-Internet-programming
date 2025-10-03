<?php
// admin/dashboard.php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/config.php';

$stmt = $conn->prepare("SELECT COUNT(*) AS books_count FROM books");
$stmt->execute();
$books_count = $stmt->get_result()->fetch_assoc()['books_count'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS users_count FROM users WHERE role='student'");
$stmt->execute();
$users_count = $stmt->get_result()->fetch_assoc()['users_count'];
$stmt->close();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Dashboard</title></head>
<body>
  <h2>Admin Dashboard</h2>
  <p>Welcome, <?php echo htmlentities($_SESSION['user']['name']); ?> | <a href="/library/logout.php">Logout</a></p>
  <ul>
    <li>Books: <?php echo $books_count; ?> — <a href="add_book.php">Add Book</a></li>
    <li>Students: <?php echo $users_count; ?></li>
    <li><a href="manage_issues.php">Manage Issues / Returns</a></li>
  </ul>

  <h3>All Books</h3>
  <table border="1" cellpadding="6">
    <tr><th>ID</th><th>Title</th><th>Author</th><th>Copies</th><th>Available</th><th>Actions</th></tr>
    <?php
    $res = $conn->query("SELECT * FROM books ORDER BY id DESC");
    while ($b = $res->fetch_assoc()):
    ?>
    <tr>
      <td><?php echo $b['id']; ?></td>
      <td><?php echo htmlentities($b['title']); ?></td>
      <td><?php echo htmlentities($b['author']); ?></td>
      <td><?php echo $b['copies']; ?></td>
      <td><?php echo $b['available']; ?></td>
      <td>
        <a href="edit_book.php?id=<?php echo $b['id']; ?>">Edit</a> |
        <a href="delete_book.php?id=<?php echo $b['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
