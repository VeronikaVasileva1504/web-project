<?php
// Включване на конфигурационния файл за базата данни
include "configDB.php";

// Заявка за извличане на данните от таблицата
$query = "SELECT * FROM warehouse";
$result = mysqli_query($dbConn, $query);

// Проверка за грешки при изпълнението на заявката
if (!$result) {
    die("Грешка при извличане на данните: " . mysqli_error($dbConn));
}
?>


<div class="roles-section">
<h2>Списък с наличността в слада</h2>

<table border="1">
    <tr>
        <th>ID на продукт</th>
        <th>Брой на продукта</th>
    </tr>

    <?php
    // Извеждане на данните от таблицата
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['ingredians_id']}</td>";
        echo "<td>{$row['stock_quantity']}</td>";
        echo "</tr>";
    }
    ?>

</table>
</div>