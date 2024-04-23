<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="ReservationStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
                <li><a href="Menu.php">Меню</a></li>
                <li><a href="Order.php">Поръчка</a></li>
                <li><a href="Reservation.php">Резервация</a></li> 
                <div class="logo">
                    <a href="MainMenu.php"> 
                        <img src="italy.png" alt="Лого">
                    </a>
                </div>
                <li><a href="ForUsPage.php">За нас</a></li>
                <li><a href="Rating.php">Отзиви</a></li>
                <li><a href="AccountRegistrationForm.php">Account</a></li>
            </ul>
        </div>
    </header>
    
    <div class="reservation-form">
    <h2>Направи си резервация!</h2>
<form action="" method="post">
    <label for="first_name">Първо име:</label>
    <input type="text" name="first_name" required><br>

    <label for="last_name">Фамилия:</label>
    <input type="text" name="last_name" required><br>

    <label for="date">Дата и час на резервация:</label>
    <input type="datetime-local" name="date" required><br>

    <label for="number_guests">Брой гости:</label>
    <input type="number" name="number_guests" min="1" required><br>

    <input type="submit" value="Резервирай">
</form>
    </div>
</body>
</html>
    

<?php
include "configDB.php"; 

if ($dbConn->connect_error) {
    die("Connection failed: " . $dbConn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $date = $_POST["date"];
    $number_guests = $_POST["number_guests"];

    $sql = "SELECT tabel_id, table_status, capacity FROM tables WHERE capacity >= $number_guests AND table_status = 'свободна'";
    $result = $dbConn->query($sql);

    echo "<h3>Моля изберете номер на свободна маса за $number_guests или повече души :</h3>";

    if ($result->num_rows > 0) {
        echo "<form action='' method='post'>";
        while ($row = $result->fetch_assoc()) {
            echo "<input type='radio' name='table_id' value='{$row['tabel_id']}'>";
            echo "Маса №{$row['tabel_id']} (Капацитет: {$row['capacity']})<br>";
        }
        echo "<input type='hidden' name='first_name' value='$first_name'>";
        echo "<input type='hidden' name='last_name' value='$last_name'>";
        echo "<input type='hidden' name='date' value='$date'>";
        echo "<input type='hidden' name='number_guests' value='$number_guests'>";
        echo "<input type='submit' value='Потвърди резервация'>";
        echo "</form>";
    } else {
        echo "<p>В момента нямаме свободни маси за този ден  с капацитет $number_guests или повече.Моля, опитайте по-късно.</p>";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["table_id"])) {
    $table_id = $_POST["table_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $date = $_POST["date"];
    $number_guests = $_POST["number_guests"];

    $checkUserQuery = "SELECT user_id FROM users WHERE first_name = '$first_name' AND last_name = '$last_name'";
    $userResult = $dbConn->query($checkUserQuery);

    if ($userResult->num_rows > 0) {
        $row = $userResult->fetch_assoc();
        $user_id = $row['user_id'];

        $insertReservationQuery = "INSERT INTO reservation (user_id, table_id, date, number_guest) VALUES ($user_id, $table_id, '$date', $number_guests)";

        if ($dbConn->query($insertReservationQuery) === TRUE) {
            $updateTableStatusQuery = "UPDATE tables SET table_status = 'резервирана' WHERE tabel_id = $table_id";
            $dbConn->query($updateTableStatusQuery);

            echo "Вие направихте успешна резервация!<br>";
            echo "Вашите имена : $first_name $last_name<br>";
            echo "Дата и час на резервация: $date<br>";
            echo "Брой гости: $number_guests<br>";
            echo "Вашата маса е №$table_id<br>";
            echo "Очакаваме Ви !";
        } else {
            echo "Грешка при резервация: " . $dbConn->error;
        }
    } else {
        echo "Не може да направите резервация в момента. Моля Ви ,регистрирайте се първо.";
    }
}
$dbConn->close();
?>