<?php
    include 'configDB.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ingredians_id = $_POST['ingredians_id'];
        $quantity = $_POST['quantity'];

        // Проверка за валидно количество (може да добавите и други проверки, ако е необходимо)
        if ($quantity <= 0.000) {
            echo "Невалидно количество. Моля, въведете положително число.";
            exit();
        }

        // Извличане на текущите стойности на съставката от склада
        $query = "SELECT * FROM warehouse_dish WHERE ingredians_id = $ingredians_id";
        $result = mysqli_query($dbConn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $current_quantity = $row['quantity_of_stock'];

            // Актуализация на количеството в склада
            $new_quantity = $current_quantity + $quantity;
            $update_query = "UPDATE warehouse_dish SET quantity_of_stock = $new_quantity WHERE ingredians_id = $ingredians_id";
            $update_result = mysqli_query($dbConn, $update_query);

            if (!$update_result) {
                echo "Грешка при актуализиране на склада. Моля, опитайте отново.";
                exit();
            }

            // Актуализация на броя на съставката в таблицата със съставки
            $update_ingredients_query = "UPDATE ingredients SET ingredians_count = $new_quantity WHERE ingredians_id = $ingredians_id";
            $update_ingredients_result = mysqli_query($dbConn, $update_ingredients_query);

            if (!$update_ingredients_result) {
                echo "Грешка при актуализиране на броя на съставката. Моля, опитайте отново.";
                exit();
            }

            echo "Поръчката е успешна. Наличността на съставката е актуализирана.";
        } else {
            echo "Грешка: Съставката не е намерена в склада.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Списък със съставки</title>
</head>
<body>
    <h1>Списък със съставки</h1>

    <?php
        // Извличане на съставките с брой по-малък от 1.000
        $query = "SELECT * FROM ingredients WHERE ingredians_count < 1.000";
        $result = mysqli_query($dbConn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>{$row['ingredians_name']} - Наличност: {$row['ingredians_count']} {$row['unit_of_measure']} ";
                echo "<form action='order.php' method='post'>";
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
