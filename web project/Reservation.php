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
                    <a href="MainMenu.php"> <!-- Добавена връзка около логото -->
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

    <!-- Формата трябва да се появи само ако има свободни маси -->
  

        <form action="" method="post">
            <label for="first_name">Име:</label>
            <input type="text" name="first_name" required>

            <label for="last_name">Фамилия:</label>
            <input type="text" name="last_name" required>

            <label for="reservation_date">Изберете дата:</label>
            <input type="date" name="reservation_date" required>

            <label for="guests">Брой гости:</label>
            <input type="number" name="guests" required>

            <label for="table_number">Изберете номер на свободна маса:</label>
            <input type="table_number" name="table_number" required>
        
            <input type="submit" name="reservation" value="Резервирай">
        </form>
    </div>
</body>
</html>
    

<?php
include "configDB.php"; // Включване на конфигурационния файл за базата данни


function userExists($dbConn, $first_name, $last_name) {
    $query = "SELECT user_id FROM users WHERE first_name = '$first_name' AND last_name = '$last_name'";
    $result = $dbConn->query($query);

    return $result->num_rows > 0;
}

// Function to get available tables
function getAvailableTables($dbConn, $guests) {
    $query = "SELECT table_number FROM tables WHERE table_status = 'свободна' AND capacity >= $guests";
    $result = $dbConn->query($query);

    $tables = array();
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }

    return $tables;
}

// Handle form submission
if (isset($_POST['reservation'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $reservation_date = $_POST['reservation_date'];
    $guests = $_POST['guests'];

    // Check if user exists
    if (!userExists($dbConn, $first_name, $last_name)) {
        echo "Този потребител не съществува.Моля регистрирайте се първо!";
    } else {
        // Check for available tables
        $availableTables = getAvailableTables($dbConn, $guests);

        if (empty($availableTables)) {
            echo "Няма свободни маси за този брой гости.";
        } else {
            // Display dropdown menu with available tables
            echo '<form action="" method="post">';
            echo '<label for="table_number">Моля изберете маса:</label>';
            echo '<select name="table_number" required>';
            
            foreach ($availableTables as $table) {
                echo '<option value="' . $table['table_number'] . '">Маса ' . $table['table_number'] . '</option>';
            }
            
            echo '</select>';
            echo '<input type="hidden" name="guests" value="' . $guests . '">';
            echo '<input type="submit" name="confirm_reservation" value="Резервирай!">';
            echo '</form>';
        }
    }
}

// Handle reservation confirmation
if (isset($_POST['confirm_reservation'])) {
    $user_id = $_POST['user_id']; // You should have a way to retrieve the user_id based on the user's first_name and last_name
    $table_id = $_POST['table_number'];
    $reservation_date = $_POST['reservation_date'];
    $number_guest = $_POST['guests'];

    // Insert reservation into the reserve table
    $query = "INSERT INTO reservation (user_id, table_id, date, number_guest) VALUES ('$user_id', '$table_id', '$reservation_date', '$number_guest')";
    
    if ($dbConn->query($query) === TRUE) {
        echo "Успешна резервация!";
    } else {
        echo "Грешка: " . $query . "<br>" . $dbConn->error;
    }
 
mysqli_close($dbConn);
    
}

?>