<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kanban_board";

// Получить данные из POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cardId = $_POST['cardId'];
  $cardText = $_POST['cardText'];
  $cardColor = $_POST['cardColor'];
  $cardNote = $_POST['cardNote'];
  $cardDate = $_POST['cardDate'];

  // Создаем подключение к базе данных
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Подготовка и выполнение запроса на обновление деталей карточки
  $stmt = $conn->prepare("UPDATE cards SET `text` = ?, `color` = ?, `note` = ?, `date` = ? WHERE `id` = ?");
  $stmt->bind_param("sssss", $cardText, $cardColor, $cardNote, $cardDate, $cardId);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "Card details updated successfully.";
  } else {
    echo "Failed to update card details.";
  }

  // Закрываем соединение с базой данных
  $stmt->close();
  $conn->close();

  // Возвращаем успешный HTTP-ответ
  http_response_code(200);
}
?>