<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="ChefRecepiesViewStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
            <li><a href="WarehouseDish.php">Поръчай от склад</a></li>
                <li><a href="ChefIngrediansInDish.php">Рецепти за ястие </a></li>
                <li><a href="ChefRecepiesView.php">Виж Рецепта</a></li> 
                <li><a href="ChefIngrediansCheck.php">Управление на съставки</a></li> 
        
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
    <h1>Избери Ястие и Рецепта</h1>

    <form action="" method="post">
        <label for="dish">Избери ястие:</label>
        <select name="dish" required>
            <?php
                include "configDB.php";

                $query = "SELECT dish_id, dish_name FROM disj";
                $result = mysqli_query($dbConn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['dish_id']}'>{$row['dish_name']}</option>";
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
    $dish_id = mysqli_real_escape_string($dbConn, $_POST['dish']);

    $dish_query = "SELECT d.*, c.category_name
                   FROM disj d
                   JOIN categories c ON d.dish_category = c.category_id
                   WHERE dish_id = '$dish_id'";
    $dish_result = mysqli_query($dbConn, $dish_query);

    if ($dish_result && mysqli_num_rows($dish_result) > 0) {
        $dish_row = mysqli_fetch_assoc($dish_result);

        $ingredients_query = "SELECT i.ingredians_name, idd.quantity_used
                             FROM ingredientsindish idd
                             JOIN ingredients i ON idd.ingredians_id = i.ingredians_id
                             WHERE idd.dish_id = '$dish_id'";
        $ingredients_result = mysqli_query($dbConn, $ingredients_query);

        echo "<h2>Рецепта за {$dish_row['dish_name']}</h2>";
        echo "<p>Категория: {$dish_row['category_name']}</p>";
        echo "<p>Цена: {$dish_row['dish_price']} лв.</p>";
        echo "<p>Грамаж: {$dish_row['dish_gramms']} гр.</p>";

        if ($ingredients_result && mysqli_num_rows($ingredients_result) > 0) {
            echo "<h3>Необходими съставки:</h3>";
            echo "<ul>";
            while ($ingredient_row = mysqli_fetch_assoc($ingredients_result)) {
                echo "<li>{$ingredient_row['ingredians_name']} - {$ingredient_row['quantity_used']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Няма налични съставки за това ястие.</p>";
        }
    } else {
        echo "<p>Ястието не беше намерено.</p>";
    }
}
?>

