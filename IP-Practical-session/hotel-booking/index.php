<?php
require_once 'inc/config.php';
$city = $_GET['city'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$guests = (int)($_GET['guests'] ?? 1);

$params = [];
$sql = "SELECT * FROM hotels WHERE 1=1";
if ($city!=='') {
    $sql .= " AND city LIKE ?";
    $params[] = "%$city%";
}
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>
<!-- show form and results -->
