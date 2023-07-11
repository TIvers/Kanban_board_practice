<!DOCTYPE html>
<html>
<?php
session_start();
$loggedInUser = $_SESSION['user'];?>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="styles/project_page_style.css">
  <script src="js/project_page.js"></script>
  <style>
    
  </style>
  <script>
   
  </script>
</head>

<body>
  <div style="margin: 20px;">
    <div class="header">
      <h2>Добро пожаловать, <?php echo $loggedInUser; ?>!</h2>
      <button id="logout-btn" class="logout-btn">Выйти</button>
    </div>
    <h2>Выбор разных досок:</h2>
    <div id="card-container">
      <?php
      session_start();
      $loggedInUser = $_SESSION['user'];
      $_SESSION['kanban_board_name'] = 0;
      // Подключение к базе данных
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $dbname = "kanban_board";

      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Получение карточек со статусом "todo"
      $sql = "SELECT `board_name` FROM `cards` WHERE `user` = '$loggedInUser' GROUP BY `board_name`;";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<form method="post" action="main.php" style="display: inline;">
            <div class="card-container">
              <input type="hidden" name="id" value="' . $row['board_name'] . '">
              <button type="submit" class="card" style="cursor: pointer;">' . $row['board_name'] . '</button>
            </div>
        </form>';
        }
      }

      $conn->close();
      ?>
    </div>

    <div>
      <input type="text" id="board_name" placeholder="Название доски">
      <button class="addButton">Создать новую доску</button>
    </div>
  </div>
</body>

</html>