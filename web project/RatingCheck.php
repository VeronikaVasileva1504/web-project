<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="RatingCheckStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul><li><a href="EmployeeManagment.php">Управление на служители</a></li>
                <li><a href="RatingCheck.php">Проверка на отзиви</a></li>
                <li><a href="AddDish.php">Ястия</a></li> 
                <li><a href="AddDrink.php">Напитки</a></li> 
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
    <h1>Отзиви за ресторанта</h1>
    
    <?php
    // Предполагаме, че вече имате конекция към базата данни
    // Нека кажем, че тя се казва $db
    $host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';

// Създаване на връзка с базата данни
$dbConn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

    
    // Проверка за успешна връзка
    if ($dbConn ->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Заявка за извличане на отзиви
    $query = "SELECT r.review_id, u.username, r.review_text, r.rating
              FROM reviews r
              INNER JOIN users u ON r.user_id = u.user_id";
    
    $result = $dbConn ->query($query);

    // Проверка за успешно изпълнение на заявката
    if ($result) {
        echo "<table border='1'>
                <tr>
                    <th>ID на отзива</th>
                    <th>Username на клиент</th>
                    <th>Отзив</th>
                    <th>Рейтинг</th>
                </tr>";

        // Извеждане на резултатите в таблица
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['review_id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['review_text']}</td>
                    <td>{$row['rating']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . $dbConn ->error;
    }

    // Затваряме връзката към базата данни
    $dbConn ->close();
    ?>

</body>
</html>