<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="WaiterOrdersForRset.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
                <li><a href="ReservationView.php">Проверка за резервации</a></li>
                <li><a href="WaiterOrderForHome.php">Поръчки за вкъщи</a></li>
                
                <li><a href="WaiterOrdersForRset.php">Поръки за ресторанта</a></li>
                <li><a href="WaiterInputOrder.php">Въведи поръчка за ресторанта</a></li>  
                <li><a href="TableManagment.php">Управление на масите</a></li> 
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
    <style>
        .order-panel {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            max-width: 400px;
        }
    </style>
</head>
<body>

<?php
include('configDB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['delete_order_id'];

    $deleteQuery = "DELETE FROM `order` WHERE order_id = $order_id";
    $deleteResult = mysqli_query($dbConn, $deleteQuery);

    if ($deleteResult) {
        echo "<div>Поръчката е успешно изпълнена .</div>";
    } else {
        echo "<div>Грешка при изпълнение на заявката за изтриване: " . mysqli_error($dbConn) . "</div>";
    }
}

$query = "SELECT users.first_name, users.last_name, users.email, `order`.order_adress, 
                 GROUP_CONCAT(DISTINCT disj.dish_name, ': ', order_dish.dish_count SEPARATOR '<br>') AS ordered_dishes,
                 GROUP_CONCAT(DISTINCT drinks.drink_name, ': ', orderdrinks.quantity_drinks SEPARATOR '<br>') AS ordered_drinks,
                 `order`.total_price, `order`.order_date, `order`.order_id
          FROM `order`
          JOIN users ON `order`.user_id = users.user_id
          LEFT JOIN order_dish ON `order`.order_id = order_dish.order_id
          LEFT JOIN disj ON order_dish.dish_id = disj.dish_id
          LEFT JOIN orderdrinks ON `order`.order_id = orderdrinks.order_id
          LEFT JOIN drinks ON orderdrinks.drink_id = drinks.drink_id
          WHERE `order`.table_id = 100
          GROUP BY `order`.order_id";

$result = mysqli_query($dbConn, $query);

if (!$result) {
    die('Грешка при изпълнение на заявката: ' . mysqli_error($dbConn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>
            <p>Име на клиента: {$row['first_name']}</p>
            <p>Фамилия на клиента: {$row['last_name']}</p>
            <p>Имейл адрес: {$row['email']}</p>
            <p>Адрес за доставка: {$row['order_adress']}</p>
            <p>Поръчани ястия: {$row['ordered_dishes']}</p>
            <p>Поръчани напитки: {$row['ordered_drinks']}</p>
            <p>Обща цена: {$row['total_price']}</p>
            <p>Дата на поръчката: {$row['order_date']}</p>
            
            <form method='post' action=''>
                <input type='hidden' name='delete_order_id' value='{$row['order_id']}'>
                <button type='submit'>Изпълни поръчката!</button>
            </form>
          </div>";
}

mysqli_close($dbConn);
?>

</body>
</html>