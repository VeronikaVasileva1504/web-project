<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="ChefIngrediansInDish.css">
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
    <div class="recipe-form-container">
        <div class="recipe-form">
    <div class="recipe-form">
        <h2>Добави Рецепта</h2>
        <form action="" method="post">
            <label for="dish_name">Име на ястието:</label>
            <select name="dish_id" required>
                <?php
                include "configDB.php";

                $selectDishesQuery = "SELECT dish_id, dish_name FROM disj";
                $result = mysqli_query($dbConn, $selectDishesQuery);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['dish_id']}'>{$row['dish_name']}</option>";
                }

                mysqli_close($dbConn);
                ?>
            </select>

            <label for="ingredient_name">Име на съставката:</label>
            <select name="ingredient_id" required>
                <?php
                include "configDB.php";

                $selectIngredientsQuery = "SELECT ingredians_id, ingredians_name FROM ingredients";
                $result = mysqli_query($dbConn, $selectIngredientsQuery);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['ingredians_id']}'>{$row['ingredians_name']}</option>";
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
</body>
</html>
<?php
include "configDB.php";

if (isset($_POST['add_recipe'])) {
    $dish_id = $_POST['dish_id'];
    $ingredient_id = $_POST['ingredient_id'];
    $quantity_used = $_POST['quantity_used'];

    $insertIngredientInDishQuery = "INSERT INTO ingredientsindish (dish_id, ingredians_id, quantity_used) 
                                    VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($dbConn, $insertIngredientInDishQuery);
    mysqli_stmt_bind_param($stmt, 'iid', $dish_id, $ingredient_id, $quantity_used);

    if (mysqli_stmt_execute($stmt)) {
        echo "Рецептата е успешно добавена.";
    } else {
        echo "Грешка при изпълнение на заявката: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($dbConn);
?>