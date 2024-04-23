<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="ChefIngrediansCheckStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
            <li><a href="WarehouseDish.php">Поръчай от склад</a></li>
                <li><a href="ChefIngrediansInDish.php">Рецепти за ястие</a></li>
                <li><a href="ChefRecepiesView.php">Виж Рецепта</a></li> 
                <li><a href="ChefIngrediansCheck.php">Управление на съставки</a></li> 
        
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>

<?php
$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';

// Създаване на връзка с базата данни
$dbConn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

// Проверка за грешки при връзката
if (!$dbConn) {
    die('Не може да осъществи връзка със сървъра: ' . mysqli_connect_error());
}

// Задаване на кодиране на символите
mysqli_query($dbConn, "SET NAMES 'UTF8'");

// Извличане на данните от базата данни
$query = "SELECT * FROM ingredients";

$result = mysqli_query($dbConn, $query);

// Проверка за грешки при изпълнението на заявката
if (!$result) {
    die('Грешка при изпълнение на заявката: ' . mysqli_error($dbConn));
}
?>
<div class="employees-section">
<h2>Продукти </h2>
<table border="1">
    <tr>
        <th>ID на продукт</th>
        <th>Наименование</th>
        <th>Брой </th>
        <th>Мерна единица</th>
    </tr></div>
    <?php
    // Извеждане на резултатите от заявката
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['ingredians_id']}</td>";
        echo "<td>{$row['ingredians_name']}</td>";
        echo "<td>{$row['ingredians_count']}</td>";
        echo "<td>{$row['unit_of_measure']}</td>";
        echo "</tr>";
    }

    // Затваряне на връзката с базата данни
    mysqli_close($dbConn);
    ?>
</table>

    
<div class="add_ingreadians">
<h2>Добави съставка!</h2>
<form action="" method="post">
    <label for="ing_name">Наименование на продукт:</label>
    <input type="text" name="ing_name" required>
    <label for="ing_count">Брой на продукта:</label>
    <input type="text" name="ing_count" required>
    <label for="ing_weight">Мярка за тежест:</label>
    <input type="text" name="ing_weight" required>
    <button type="submit" name="entering">Добави!</button>
</form>
</div>
<div class="remove_ingreadians">
<h2>Премахни съставка!</h2>
<form action="" method="post">
    <label for="ingr_id">ID на продукта:</label>
    <input type="text" name="ingr_id" required>
    <button type="submit" name="deleteing">Премахни!</button>
</form>
</div>
<div class="redact_ingreadians">
<h2>Редактирай съставка!</h2>
<form action="" method="post">
<label for="ingr_id">ID на продукта:</label>
    <input type="text" name="ing_id" required>
<label for="ingrname">Наименование на продукт:</label>
    <input type="text" name="ing_name" required>
    <label for="ingr_count">Брой на продукта:</label>
    <input type="text" name="ing_count" required>
    <label for="ingr_weight">Мярка за тежест:</label>
    <input type="text" name="ing_weight" required>
    <button type="submit" name="redact">Редактирай!</button>
</form>
</div>

</body>
</html>
    
    <?php
include "configDB.php";

if (isset($_POST['entering'])) {
    $ingName = $_POST['ing_name'];
    $ingCount = $_POST['ing_count'];
    $ingWeight = $_POST['ing_weight'];
    $insertQuery = "INSERT INTO ingredients (ingredians_name,ingredians_count,unit_of_measure)
     VALUES ('$ingName' , '$ingCount',
    '$ingWeight' )";

    $result = mysqli_query($dbConn, $insertQuery);

    if ($result) {
        echo "Продуктът е  успешно добавен в базата данни.";
    } else {
        echo "Грешка при добавянето на продукт: " . mysqli_error($dbConn);
    }
}
if (isset($_POST['deleteing'])) {
    $ingId = $_POST['ingr_id'];

    $deleteQuery = "DELETE FROM ingredients WHERE ingredians_id = '$ingId'";

    $result = mysqli_query($dbConn, $deleteQuery);

    if ($result) {
        echo "Продуктът е успешно изтрит от базата данни.";
    } else {
        echo "Грешка при изтриването на продукта: " . mysqli_error($dbConn);
    }
}
if (isset($_POST['redact'])) {
    $ingId = $_POST['ing_id'];
    $ingName = $_POST['ing_name'];
    $ingCount = $_POST['ing_count'];
    $ingWeight = $_POST['ing_weight'];

    $updateQuery = "UPDATE ingredients 
                    SET ingredians_name = '$ingName', 
                        ingredians_count = '$ingCount', 
                        unit_of_measure = '$ingWeight'
                    WHERE ingredians_id = '$ingId'";

    $result = mysqli_query($dbConn, $updateQuery);

    if ($result) {
        echo "Продуктът е успешно редактиран.";
    } else {
        echo "Грешка при редакция на продукта: " . mysqli_error($dbConn);
    }
}

mysqli_close($dbConn);
?>

 