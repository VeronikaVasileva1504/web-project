<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="WarehouseDishStyle.css">
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

<body>
    <h1>Списък със съставки ,които намаляват</h1>

    <?php
        include 'configDB.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ingredians_id = $_POST['ingredians_id'];
            $quantity = $_POST['quantity'];
            $check_query = "SELECT * FROM ingredients WHERE ingredians_id = $ingredians_id AND ingredians_count < 1.000";
            $check_result = mysqli_query($dbConn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $update_query = "UPDATE warehouse_dish SET quantity_of_stock = quantity_of_stock + $quantity WHERE ingredians_id = $ingredians_id";
                mysqli_query($dbConn, $update_query);

                $update_query = "UPDATE ingredients SET ingredians_count = ingredians_count + $quantity WHERE ingredians_id = $ingredians_id";
                mysqli_query($dbConn, $update_query);

                echo "Поръчката е успешна!";
            } else {
                echo "Грешка: Съставката не е налична или има достатъчно количество.";
            }
        }

        $query = "SELECT * FROM ingredients WHERE ingredians_count < 1.000";
        $result = mysqli_query($dbConn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>{$row['ingredians_name']} - Наличност: {$row['ingredians_count']} {$row['unit_of_measure']} ";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='ingredians_id' value='{$row['ingredians_id']}'>";
                echo "<input type='number' name='quantity' placeholder='Количество' required>";
                echo "<input type='submit' value='Поръчай'>";
                echo "</form></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Няма съставки с брой по-малък от 1.000</p>";
        }

        mysqli_close($dbConn);
    ?>
</body>
</html>
