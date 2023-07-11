<?php
// Получить данные из POST-запроса
$cardId = $_POST['cardId'];
$cardText = $_POST['cardText'];
$status = $_POST['status'];
session_start();
$user = $_SESSION['user'];
$board_name_session = $_SESSION['kanban_board_name'];

if ($board_name_session == 0 ) {
  $board_name = $_POST['board_name']; 
} else {
  $board_name = $_SESSION['kanban_board_name'];
}


// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kanban_board";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Подготовка и выполнение запроса на вставку новой карточки
$stmt = $conn->prepare("INSERT INTO `cards` (id, text, status, board_name, user) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $cardId, $cardText, $status, $board_name, $user);
$stmt->execute();

$stmt->close();
$conn->close();

// Возвращаем успешный HTTP-ответ
http_response_code(200);
?>