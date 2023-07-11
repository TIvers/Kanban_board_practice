<!DOCTYPE html>
<html>
<head>
  <title>Kanban Board</title>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="styles/main_style.css">
  <script src="js/main_script.js"></script>
<?php 
session_start();
?>
</head>
<body>
  <h1>Kanban Board</h1>
  <?php
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $board_name = $_POST['id'];
    }
}
  
  $loggedInUser = $_SESSION['user'];
  $_SESSION['kanban_board_name'] =  $board_name;
 
 echo '<h2>Вошел пользователь: ' . $loggedInUser . '</h2>';
  
?>
  <button id="logout-btn" class="logout-btn">Выйти</button>
    <div class="column">
      <h2>To Do</h2>
      <div class="todo">
      
        <?php
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
        $sql = "SELECT * FROM cards WHERE `status` = 'todo' AND `board_name` = '$board_name' AND `user` = '$loggedInUser' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $cardId = $row["id"];
            $cardText = $row["text"];
            $cardNote = $row["note"];
            $cardDate = $row["date"];
            $cardColor = $row["color"];
            echo "<div id='$cardId' class='sortable card' style='background-color: $cardColor;' data-note='$cardNote' data-date='$cardDate'>$cardText</div>";
          }
        }
        
       

        $conn->close();
        ?>
      </div>
      <input type="text" id="itemText" placeholder="Текст элемента">
  <button class="addButton">Add Card</button>
  <input type="hidden" id="boardName" value="<?php echo $board_name; ?>">
    </div>
  
    <div class="column">
      <h2>In Progress</h2>
      <div class="inProgress">
        <?php
        // Подключение к базе данных
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Получение карточек со статусом "inProgress"
        $sql = "SELECT * FROM cards WHERE `status` = 'inProgress' AND `board_name` = '$board_name' AND `user` = '$loggedInUser' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $cardId = $row["id"];
          $cardText = $row["text"];
          $cardNote = $row["note"];
          $cardDate = $row["date"];
          $cardColor = $row["color"];
          echo "<div id='$cardId' class='sortable card' style='background-color: $cardColor;' data-note='$cardNote' data-date='$cardDate'>$cardText</div>";
          }
        }
       
        $conn->close();
        ?>
        </div>
      </div>
    
  
    <div class="column">
      <h2>Done</h2>
      <div class="done">
        <?php
        // Подключение к базе данных
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Получение карточек со статусом "done"
        $sql = "SELECT * FROM cards WHERE `status` = 'done' AND `board_name` = '$board_name' AND `user` = '$loggedInUser' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $cardId = $row["id"];
          $cardText = $row["text"];
          $cardNote = $row["note"];
          $cardDate = $row["date"];
          $cardColor = $row["color"];
          echo "<div id='$cardId' class='sortable card' style='background-color: $cardColor;' data-note='$cardNote' data-date='$cardDate'>$cardText</div>";
          }
        }
        
        $conn->close();
        
        ?>
        </div>
      </div>
    <div class="column">
    <h2>Корзина</h2>
    <div class="delete">
      <div class="deleteArea"></div>
    </div>
  
    </div>
    
    
  <button id="back-btn" class="back-btn">Назад</button>
</body>
</html>