<?php
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the card ID from the POST data
  if (isset($_POST['cardId'])) {
    $cardId = $_POST['cardId'];

    // Add your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "kanban_board";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Delete the card from the database
    $sql = "DELETE FROM cards WHERE id = '$cardId'";
    if ($conn->query($sql) === true) {
      echo "Card deleted successfully.";
    } else {
      echo "Error deleting card: " . $conn->error;
    }

    $conn->close();
  }
}
?>