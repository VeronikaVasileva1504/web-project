<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="BarmanIngrediansInDishStyle.css">
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
<div class="recipe-form-container">
    <div class="recipe-form">
        <h2>Добави Рецепта</h2>
        <form action="" method="post">
            <label for="drink_name">Име на напитката:</label>
            <select name="drink_id" required>
                <?php
                include "configDB.php";

                $selectDrinksQuery = "SELECT drink_id, drink_name FROM drinks";
                $result = mysqli_query($dbConn, $selectDrinksQuery);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['drink_id']}'>{$row['drink_name']}</option>";
                }

                mysqli_close($dbConn);
                ?>
            </select>

            <label for="ingredient_name">Име на съставката:</label>
            <select name="ingredient_id" required>
                <?php
                include "configDB.php";

                $selectIngredientsQuery = "SELECT ingred_drink_id, ingred_drink_name FROM drink_ingredient";
                $result = mysqli_query($dbConn, $selectIngredientsQuery);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['ingred_drink_id']}'>{$row['ingred_drink_name']}</option>";
                }

                mysqli_close($dbConn);
                ?>
            </select>

            <label for="quantity_used">Използвано количество:</label>
            <input type="text" name="quantity_used" required>

        </div>
        <div class="panel-around-button">
            <button type="submit" name="add_recipe">Добави Рецепта</button>
        </div>
    </div>
</form>
</body>
</html>

<?php
include "configDB.php";

if (isset($_POST['add_recipe'])) {
    $drink_id = $_POST['drink_id'];
    $ingredient_id = $_POST['ingredient_id'];
    $quantity_used = floatval($_POST['quantity_used']); // Преобразуване към числов тип

    $insertIngredientInDrinkQuery = "INSERT INTO ingredientsindrink (drink_id, ingred_drink_id, quantity_used_drink) 
                                    VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($dbConn, $insertIngredientInDrinkQuery);
    mysqli_stmt_bind_param($stmt, 'iid', $drink_id, $ingredient_id, $quantity_used);

    if (mysqli_stmt_execute($stmt)) {
        echo "Рецептата е успешно добавена.";
    } else {
        echo "Грешка при изпълнение на заявката: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($dbConn);
?>
