<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="BarmanWarehouseDrink.css">
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
    <h1>Списък с напитки, които намаляват</h1>

    <?php
        include 'configDB.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $drink_id = $_POST['drink_id'];
            $quantity = $_POST['quantity'];

            $check_query = "SELECT * FROM drink_ingredient WHERE ingred_drink_id = $drink_id AND infred_count_drink < 3.000";
            $check_result = mysqli_query($dbConn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $update_query = "UPDATE warehouse_drinks SET quantity_of_drinks = quantity_of_drinks + $quantity WHERE drink_id = $drink_id";
                mysqli_query($dbConn, $update_query);

                $update_query = "UPDATE drink_ingredient SET infred_count_drink = infred_count_drink + $quantity WHERE ingred_drink_id = $drink_id";
                mysqli_query($dbConn, $update_query);

                echo "Поръчката е успешна!";
            } else {
                echo "Грешка: Напитката не е налична или има достатъчно количество.";
            }
        }

        $query = "SELECT * FROM drink_ingredient WHERE infred_count_drink < 3.000";
        $result = mysqli_query($dbConn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>{$row['ingred_drink_name']} - Наличност: {$row['infred_count_drink']} {$row['drink_measiure']} ";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='drink_id' value='{$row['ingred_drink_id']}'>";
                echo "<input type='number' name='quantity' placeholder='Количество' required>";
                echo "<input type='submit' value='Поръчай'>";
                echo "</form></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Няма напитки с брой по-малък от 3.000</p>";
        }

        mysqli_close($dbConn);
    ?>
</body>
</html>

