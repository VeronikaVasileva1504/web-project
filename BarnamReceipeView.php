<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="BarnamReceipeViewStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
            <li><a href="BarmanWarehouseDrink.php">Поръчай от склада</a></li>
                <li><a href="BarmanIngrediansInDrink.php">Въведи рецепта</a></li>
            <li><a href="BarnamReceipeView.php">Провери рецепта</a></li>
                <li><a href="BarmanIngrediansCheck.php">Управление на съставки</a></li> 
        
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
    
<body>
    <h1>Изберете напитка и проверете рецептата</h1>

    <form action="" method="post">
        <label for="drink">Изберете напитка:</label>
        <select name="drink" required>
            <?php
            include "configDB.php";

            $query = "SELECT drink_id, drink_name FROM drinks";
            $result = mysqli_query($dbConn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['drink_id']}'>{$row['drink_name']}</option>";
            }
            ?>
        </select>

        <button type="submit">Виж рецептата</button>
    </form>
</body>

</html>
<?php
include "configDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drink_id = mysqli_real_escape_string($dbConn, $_POST['drink']);

    $drink_query = "SELECT d.*, m.drink_measiure
                FROM drinks d
                JOIN drink_ingredient m ON d.drink_id = m.ingred_drink_id
                WHERE d.drink_id = '$drink_id'";

    $drink_result = mysqli_query($dbConn, $drink_query);

    if ($drink_result && mysqli_num_rows($drink_result) > 0) {
        $drink_row = mysqli_fetch_assoc($drink_result);

        $ingredients_query = "SELECT i.ingred_drink_name, idd.quantity_used_drink
        FROM ingredientsindrink idd
        JOIN drink_ingredient i ON idd.ingred_drink_id = i.ingred_drink_id
        WHERE idd.drink_id = '$drink_id'";

        $ingredients_result = mysqli_query($dbConn, $ingredients_query);

        echo "<h2>Рецепта за {$drink_row['drink_name']}</h2>";
        echo "<p>Цена: {$drink_row['drink_price']} лв.</p>";
        echo "<p>Милилитри: {$drink_row['milliliters']} мл.</p>";

        if ($ingredients_result && mysqli_num_rows($ingredients_result) > 0) {
            echo "<h3>Необходими съставки:</h3>";
            echo "<ul>";
            while ($ingredient_row = mysqli_fetch_assoc($ingredients_result)) {
                echo "<li>{$ingredient_row['ingred_drink_name']} - {$ingredient_row['quantity_used_drink']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Няма налични съставки за това напитка.</p>";
        }
    } else {
        echo "<p>Напитката не беше намерена.</p>";
    }
}
?>
