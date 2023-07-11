<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kanban_board";
// Получить данные из POST-запроса
$cardId = $_POST['cardId'];
$status = $_POST['status'];




$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Подготовка и выполнение запроса на обновление статуса карточки
$stmt = $conn->prepare("UPDATE cards SET `status`= '$status' WHERE `id` = '$cardId'");

$stmt->execute();
if ($stmt->affected_rows > 0) {
  echo "Card status updated successfully.";
} else {
  echo "Failed to update card status.";
}
$conn->close();

// Возвращаем успешный HTTP-ответ
http_response_code(200);
?>