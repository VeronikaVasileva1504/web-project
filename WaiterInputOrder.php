<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="WaiterInputOrder.css">
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
   <div class="panel">
        <h1>Направете поръчка за ресторанта</h1>

        <form action="" method="post" id="orderForm">
            <label for="username">Въведете username:</label>
            <input type="text" name="username" required>
            <br>

            <label for="address">Адрес за доставка:</label>
            <input type="text" name="address" required>
            <br>

            <label for="table_id">Номер на масата:</label>
            <input type="number" name="table_id" required>
            <br>
>
            <div id="orderItems">
                <div class="orderItem">
                    <label for="dish_id">Изберете ястие :</label>
                    <select name="dish_id[]">
                        <?php
                            include "configDB.php";

                            $query = "SELECT dish_id, dish_name, dish_price FROM disj ";
                            $result = mysqli_query($dbConn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['dish_id']}'>{$row['dish_name']} - {$row['dish_price']}</option>";
                            }
                        ?>
                    </select>
                    <label for="dish_count">Брой на ястието:</label>
                    <input type="number" name="dish_count[]" required>
                    
                    <label for="drink_id">Изберете напитка:</label>
                    <select name="drink_id[]">
                        <?php
                            $query = "SELECT drink_id, drink_name, drink_price FROM drinks";
                            $result = mysqli_query($dbConn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['drink_id']}'>{$row['drink_name']} - {$row['drink_price']}</option>";
                            }
                        ?>
                    </select>
                    <label for="quantity_drinks">Брой на напитката:</label>
                    <input type="number" name="quantity_drinks[]" required>
                </div>
            </div>
            
            <button type="button" onclick="addOrderItem()">Добави към поръчката</button>
            
            <button type="submit">Поръчай!</button>
        </form>

        <script>
            function addOrderItem() {
                var orderItemTemplate = document.querySelector('.orderItem');
                var newOrderItem = orderItemTemplate.cloneNode(true);
                document.getElementById('orderItems').appendChild(newOrderItem);

                var inputs = newOrderItem.querySelectorAll('input, select');
                inputs.forEach(function (input) {
                    input.value = '';
                });
            }
        </script>
    </div>
</body>
</html>

<?php
include "configDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($dbConn, $_POST['username']);
    $address = mysqli_real_escape_string($dbConn, $_POST['address']);
    $table_id = mysqli_real_escape_string($dbConn, $_POST['table_id']);

    $user_query = "SELECT user_id FROM users WHERE username = '$username'";
    $user_result = mysqli_query($dbConn, $user_query);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['user_id'];

        $order_query = "INSERT INTO `order` (table_id, order_adress, user_id, order_date) 
                        VALUES ('$table_id', '$address', '$user_id', NOW())";
        mysqli_query($dbConn, $order_query);

        $order_id = mysqli_insert_id($dbConn);
        $total_price = 0;  
        $dish_ids = $_POST['dish_id'];
        $dish_counts = $_POST['dish_count'];
        $drink_ids = $_POST['drink_id'];
        $quantity_drinks = $_POST['quantity_drinks'];

        foreach ($dish_ids as $key => $dish_id) {
            $current_dish_count = mysqli_real_escape_string($dbConn, $dish_counts[$key]);
            $current_drink_id = mysqli_real_escape_string($dbConn, $drink_ids[$key]);
            $current_quantity_drinks = mysqli_real_escape_string($dbConn, $quantity_drinks[$key]);

            $order_dish_query = "INSERT INTO order_dish (order_id, dish_id, dish_count) 
                                VALUES ('$order_id', '$dish_id', '$current_dish_count')";
            mysqli_query($dbConn, $order_dish_query);

            $order_drink_query = "INSERT INTO orderdrinks (order_id, drink_id, quantity_drinks) 
                                VALUES ('$order_id', '$current_drink_id', '$current_quantity_drinks')";
            mysqli_query($dbConn, $order_drink_query);

            $dish_price_query = "SELECT dish_price FROM disj WHERE dish_id = '$dish_id'";
            $drink_price_query = "SELECT drink_price FROM drinks WHERE drink_id = '$current_drink_id'";

            $dish_price_result = mysqli_query($dbConn, $dish_price_query);
            $drink_price_result = mysqli_query($dbConn, $drink_price_query);

            $dish_price = mysqli_fetch_assoc($dish_price_result)['dish_price'];
            $drink_price = mysqli_fetch_assoc($drink_price_result)['drink_price'];

            $total_price += ($dish_price * $current_dish_count) + ($drink_price * $current_quantity_drinks);

            $ingredients_query = "SELECT ii.ingredians_id, ii.quantity_used, i.ingredians_name
            FROM ingredientsindish ii
            JOIN ingredients i ON ii.ingredians_id = i.ingredians_id
            WHERE ii.dish_id = '$dish_id'";
            $ingredients_result = mysqli_query($dbConn, $ingredients_query);

            while ($row = mysqli_fetch_assoc($ingredients_result)) {
                $ingredient_id = $row['ingredians_id'];
                $quantity_used = $row['quantity_used'];
                $ingredient_name = $row['ingredians_name'];
            
                $check_quantity_query = "SELECT ingredians_count FROM ingredients WHERE ingredians_id = '$ingredient_id'";
                $check_quantity_result = mysqli_query($dbConn, $check_quantity_query);
            
                if ($check_quantity_result && mysqli_num_rows($check_quantity_result) > 0) {
                    $existing_quantity = mysqli_fetch_assoc($check_quantity_result)['ingredians_count'];
            
                    if ($existing_quantity >= $quantity_used) {
                        $new_quantity = $existing_quantity - $quantity_used;
            
                        $update_quantity_query = "UPDATE ingredients SET ingredians_count = '$new_quantity' WHERE ingredians_id = '$ingredient_id'";
                        mysqli_query($dbConn, $update_quantity_query);
            
                    } else {
                        echo "Недостатъчно количество за съставка с ID $ingredient_id.";
                            }
                } else {
                    echo "Грешка при проверката на наличността на съставка с ID $ingredient_id.";
                   
                }
            }
            $drink_ingredients_query = "SELECT idd.ingred_drink_id, idd.quantity_used_drink, di.ingred_drink_name
            FROM ingredientsindrink idd
            JOIN drink_ingredient di ON idd.ingred_drink_id = di.ingred_drink_id
            WHERE idd.drink_id = '$current_drink_id'";
            $drink_ingredients_result = mysqli_query($dbConn, $drink_ingredients_query);

            while ($drink_row = mysqli_fetch_assoc($drink_ingredients_result)) {
                $drink_ingredient_id = $drink_row['ingred_drink_id'];
                $drink_quantity_used = $drink_row['quantity_used_drink'];
                $drink_ingredient_name = $drink_row['ingred_drink_name'];

                $check_drink_quantity_query = "SELECT infred_count_drink FROM drink_ingredient WHERE ingred_drink_id = '$drink_ingredient_id'";
                $check_drink_quantity_result = mysqli_query($dbConn, $check_drink_quantity_query);

                if ($check_drink_quantity_result && mysqli_num_rows($check_drink_quantity_result) > 0) {
                    $existing_drink_quantity = mysqli_fetch_assoc($check_drink_quantity_result)['infred_count_drink'];

                    if ($existing_drink_quantity >= $drink_quantity_used) {
                        $new_drink_quantity = $existing_drink_quantity - $drink_quantity_used;

                        $update_drink_quantity_query = "UPDATE drink_ingredient SET infred_count_drink = '$new_drink_quantity' WHERE ingred_drink_id = '$drink_ingredient_id'";
                        mysqli_query($dbConn, $update_drink_quantity_query);

                    } else {
                        echo "Недостатъчно количество за съставка на напитка с ID $drink_ingredient_id.";
                         }
                } else {
                    echo "Грешка при проверката на наличността на съставка на напитка с ID $drink_ingredient_id.";
                   }
            }
        }

        $update_total_price_query = "UPDATE `order` SET total_price = '$total_price' WHERE order_id = '$order_id'";
        mysqli_query($dbConn, $update_total_price_query);

        echo "Поръчката Ви е обработена успешно! Вашата дължима сума е: $total_price лв.";
    } else {
        echo "Потребителя не е намерен. Моля, регистрирайте се първо.";
    }
}
?>
