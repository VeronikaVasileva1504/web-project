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
    $host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';

$dbConn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

    if ($dbConn ->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $query = "SELECT r.review_id, u.username, r.review_text, r.rating
              FROM reviews r
              INNER JOIN users u ON r.user_id = u.user_id";
    
    $result = $dbConn ->query($query);
    if ($result) {
        echo "<table border='1'>
                <tr>
                    <th>ID на отзива</th>
                    <th>Username на клиент</th>
                    <th>Отзив</th>
                    <th>Рейтинг</th>
                </tr>";

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

    $dbConn ->close();
    ?>

</body>
</html>