<?php
// book.php
require_once 'inc/auth.php';
require_login();
require_once 'inc/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = (int)$_POST['room_id'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = max(1,(int)$_POST['guests']);

    // fetch room
    $stmt = $conn->prepare("SELECT r.*, h.id AS hotel_id FROM rooms r JOIN hotels h ON r.hotel_id=h.id WHERE r.id=? LIMIT 1");
    $stmt->bind_param('i',$room_id); $stmt->execute(); $room = $stmt->get_result()->fetch_assoc(); $stmt->close();
    if (!$room) die("Room not found.");

    if ($room['available_count'] < 1) die("No rooms available.");

    $d1 = new DateTime($checkin); $d2 = new DateTime($checkout);
    if ($d2 <= $d1) die("Invalid dates.");

    $nights = $d1->diff($d2)->format('%a');
    $total = $nights * floatval($room['price']);

    // insert booking
    $stmt2 = $conn->prepare("INSERT INTO bookings (user_id,hotel_id,room_id,checkin_date,checkout_date,guests,total_amount) VALUES (?,?,?,?,?,?,?)");
    $uid = $_SESSION['user']['id'];
    $stmt2->bind_param('iiissid', $uid, $room['hotel_id'], $room_id, $checkin, $checkout, $guests, $total);
    if ($stmt2->execute()) {
        // decrement available
        $stmt3 = $conn->prepare("UPDATE rooms SET available_count = available_count - 1 WHERE id = ?");
        $stmt3->bind_param('i', $room_id);
        $stmt3->execute();
        header('Location: user/my_bookings.php');
        exit;
    } else {
        die("Booking failed.");
    }
}
?>
