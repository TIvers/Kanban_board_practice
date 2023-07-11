<!DOCTYPE html>
<html>
<head>
    <title>Логин</title>
    <link rel="stylesheet" href="styles/index_style.css">
  
</head>
<body>
    <div class="login-container">
        <h2>Вход</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="login" id="login" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Войти">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $login_db = $_POST["login"];
            $password_db = $_POST["password"];

            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "kanban_board";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM users WHERE login = '$login_db' AND password = '$password_db'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                session_start();
                $_SESSION['user'] = $login_db;
                header("Location: project_page.php");
                exit();
            } else {
                echo '<p class="error-message">Неправильное имя пользователя или пароль</p>';
            }
            $conn->close();
        }
        ?>
    </div>
</body>
</html>