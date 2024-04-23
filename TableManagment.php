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
$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';

$dbConn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

if (!$dbConn) {
    die('Не може да осъществи връзка със сървъра: ' . mysqli_connect_error());
}

mysqli_query($dbConn, "SET NAMES 'UTF8'");
$query = "SELECT * FROM tables";

$result = mysqli_query($dbConn, $query);

if (!$result) {
    die('Грешка при изпълнение на заявката: ' . mysqli_error($dbConn));
}
?>
<div class="container">
<div class="tables-section">
<h2>Маси в ресторанта</h2>
<table border="1">
    <tr>
        <th>ID на масата</th>
        <th>Номер на масата</th>
        <th>Статус</th>
        <th>Капацитет на масата</th>
    </tr></div>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['tabel_id']}</td>";
        echo "<td>{$row['table_number']}</td>";
        echo "<td>{$row['table_status']}</td>";
        echo "<td>{$row['capacity']}</td>";
        echo "</tr>";
    }

    mysqli_close($dbConn);
    ?>
</table>
</div>

    </section>
    <section class="add-table">
        <h2>Добави  маса</h2>
        <form action="" method="post">
            
        <label for="table_number">Въведете номер на масата:</label>
            <input type="text" name="table_number" required>
            <label for="table_status">Въведете статус на масата:</label>
            <input type="text" name="table_status" required>
            <label for="table_capacity">Въведете капацитет на масата:</label>
            <input type="text" name="table_capacity" required>
            <input type="submit" name="add_table_status" value="Добави маса">
            </form>
</section>
<section class="redact-table">
    <h2>Редактирай маса</h2>
    <form action="" method="post">
        <label for="table_id">Въведете ID на масата, която искате да редактирате:</label>
        <input type="text" name="table_id" required>
        <label for="table_number">Въведете нов номер на масата:</label>
        <input type="text" name="table_number" required>
        <label for="table_status">Въведете нов статус на масата:</label>
        <input type="text" name="table_status" required>
        <label for="table_capacity">Въведете нов капацитет на масата:</label>
        <input type="text" name="table_capacity" required>
        <input type="submit" name="update_table" value="Редактирай маса">
    </form>
</section>
<section class="redact-table">
    <h2>Промени статус на маса</h2>
    <form action="" method="post">
        <label for="table_number">Въведете номер на масата:</label>
        <input type="text" name="table_number" required>
        <label for="new_status">Въведете нов статус:</label>
        <input type="text" name="new_status" required>
        <input type="submit" name="change_table_status" value="Промени статус">
    </form>
</section>
<section class="delete-table">
    <h2>Изтрий маса</h2>
    <form action="" method="post">
        <label for="delete_table_id">Въведете ID на масата, която искате да изтриете:</label>
        <input type="text" name="delete_table_id" required>
        <input type="submit" name="delete_table" value="Изтрий маса">
    </form>
</section>
</div>
    </body>
</html>


<?php
include "configDB.php";

            if (isset($_POST["add_table_status"])) {
                
                $table_number = $_POST["table_number"];
                $table_status = $_POST["table_status"];
                $table_capacity = $_POST["table_capacity"];
           
                $query = "INSERT INTO tables (table_number,table_status,capacity) VALUES (' $table_number','$table_status', '$table_capacity')";
                $result = mysqli_query($dbConn, $query);
            
                if ($result) {
                    
                    echo "<p>Масата е успешно добавен.</p>";
                } else {
                    echo "<p>Грешка при извличането на информацията от базата данни.</p>";
                }
            }

 if (isset($_POST["update_table"])) {
    $table_id = $_POST["table_id"];
    $table_number = $_POST["table_number"];
    $table_status = $_POST["table_status"];
    $table_capacity = $_POST["table_capacity"];

    $check_query = "SELECT * FROM tables WHERE tabel_id = $table_id";
    $check_result = mysqli_query($dbConn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE tables SET table_number = '$table_number', table_status = '$table_status', capacity = '$table_capacity' WHERE tabel_id = $table_id";
        $update_result = mysqli_query($dbConn, $update_query);

        if ($update_result) {
            echo "<p>Масата е успешно редактирана.</p>";
        } else {
            echo "<p>Грешка при редактирането на масата.</p>";
        }
    } else {
        echo "<p>Маса с такова ID не съществува.</p>";
    }
}
if (isset($_POST["change_table_status"])) {
    $table_number = $_POST["table_number"];
    $new_status = $_POST["new_status"];

    $check_query = "SELECT * FROM tables WHERE table_number = '$table_number'";
    $check_result = mysqli_query($dbConn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE tables SET table_status = '$new_status' WHERE table_number = '$table_number'";
        $update_result = mysqli_query($dbConn, $update_query);

        if ($update_result) {
            echo "<p>Статусът на масата е успешно променен.</p>";
        } else {
            echo "<p>Грешка при промяната на статуса на масата.</p>";
        }
    } else {
        echo "<p>Маса с такъв номер не съществува.</p>";
    }
}
if (isset($_POST["delete_table"])) {
    $delete_table_id = $_POST["delete_table_id"];

    $check_query = "SELECT * FROM tables WHERE tabel_id = $delete_table_id";
    $check_result = mysqli_query($dbConn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $delete_query = "DELETE FROM tables WHERE tabel_id = $delete_table_id";
        $delete_result = mysqli_query($dbConn, $delete_query);

        if ($delete_result) {
            echo "<p>Масата е успешно изтрита.</p>";
        } else {
            echo "<p>Грешка при изтриването на масата.</p>";
        }
    } else {
        echo "<p>Маса с такъв ID не съществува.</p>";
    }
}

mysqli_close($dbConn);
?>
