<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="TableManagmentStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul><li><a href="ReservationView.php">Проверка за резервации</a></li>
                <li><a href="WaiterOrderForHome.php">Поръчки за вкъщи</a></li>
                
                <li><a href="WaiterOrdersForRset.php">Поръки за ресторанта</a></li>
                <li><a href="WaiterInputOrder.php">Въведи поръчка за ресторанта</a></li>  
                <li><a href="TableManagment.php">Управление на масите</a></li> 
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
  

<?php 
include "configDB.php";
$sql = "SELECT reservation.reservation_id, users.first_name, users.last_name, t.table_number, reservation.date, reservation.number_guest
        FROM reservation
        INNER JOIN users ON reservation.user_id = users.user_id
        INNER JOIN tables t ON reservation.table_id=t.tabel_id";

$result = $dbConn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID на резрвацията</th>
                <th>Първо име</th>
                <th>Фамилия</th>
                <th>Номер на маса</th>
                <th>Дата</th>
                <th>Брой гости</th>
            </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["reservation_id"]."</td>
                <td>".$row["first_name"]."</td>
                <td>".$row["last_name"]."</td>
                <td>".$row["table_number"]."</td>
                <td>".$row["date"]."</td>
                <td>".$row["number_guest"]."</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

?>
<section class="delete-table">
<form action="" method="post">
    <label for="delete_id">Изтриване на резервация с ID:</label>
    <input type="text" name="delete_id" required>
    <input type="submit" value="Изтрий резервация">
</form>
</section>
</div>
<section class="redact-table">
<form action="" method="post">
    <input type="hidden" name="update_id" value="">
    
    <label for="red_id">Номер на регистрацията:</label>
    <input type="text" name="reg_id" value="" required><br>

    <label for="table_id">Номер на масата:</label>
    <input type="text" name="table_id" value="" required><br>

    <label for="date">Дата:</label>
    <input type="text" name="date" value="" required><br>

    <label for="number_guest">Брой гости:</label>
    <input type="text" name="number_guest" value="" required><br>

    <input type="submit" value="Промени Резервацията!">
</form>

</section>
        <?php
include "configDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["delete_id"])) {
        $delete_id = $_POST["delete_id"];

        $delete_sql = "DELETE FROM reservation WHERE reservation_id = $delete_id";

        if ($dbConn->query($delete_sql) === TRUE) {
            echo "Успешно изтрихте резервацията.";
        } else {
            echo "Проблем при изтриването на резервацията: " . $dbConn->error;
        }
    }
}
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["reg_id"], $_POST["table_id"], $_POST["date"], $_POST["number_guest"])) {
            $update_id = $_POST["reg_id"];
            $new_table_id = $_POST["table_id"];
            $new_date = $_POST["date"];
            $new_number_guest = $_POST["number_guest"];
            
            $update_sql = "UPDATE reservation
                           SET table_id = '$new_table_id', date = '$new_date', number_guest = '$new_number_guest'
                           WHERE reservation_id = $update_id";
    
            if ($dbConn->query($update_sql) === TRUE) {
                echo "Успешно променихте резервацията.";
            } else {
                echo "Проблем при промяната на резервацията: " . $dbConn->error;
            }
        } 
    }
    
    $dbConn->close();
    ?>