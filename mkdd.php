<?php
// Предполагаме, че имаш връзка към базата данни с име $dbConn
include "configDB.php";
// Функция за извличане на ястия от дадена категория
function getDishesByCategory($dbConn, $categoryId) {
    $sql = "SELECT dish_id, dish_name, dish_price, dish_gramms, COUNT(od.dish_id) AS dish_count
            FROM dish d
            LEFT JOIN order_dish od ON d.dish_id = od.dish_id
            WHERE d.dish_category = $categoryId
            GROUP BY d.dish_id, d.dish_name, d.dish_price, d.dish_gramms";
    
    $result = mysqli_query($dbConn, $sql);

    $dishes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $dishes[] = $row;
    }

    return $dishes;
}

// Функция за извличане на всички категории
function getAllCategories($dbConn) {
    $sql = "SELECT category_id, category_name FROM categories";
    $result = mysqli_query($dbConn, $sql);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}


// Проверка за избрана категория от потребителя
if (isset($_POST['category'])) {
    $selectedCategoryId = $_POST['category'];

    // Извличане на ястия от избраната категория
    $dishes = getDishesByCategory($dbConn, $selectedCategoryId);
}

// Извличане на всички категории
$categories = getAllCategories($dbConn);

// Тук можеш да използваш $categories и $dishes за да генерираш HTML формата
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ресторантска поръчка</title>
</head>
<body>

<form action="process_order.php" method="post">

    <!-- Избор на категория -->
    <label for="category">Изберете категория:</label>
    <select id="category" name="category">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id']; ?>" 
                    <?php if (isset($selectedCategoryId) && $selectedCategoryId == $category['category_id']): ?>
                        selected
                    <?php endif; ?>>
                <?= $category['category_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Избор на ястие -->
    <label for="dish">Изберете ястие:</label>
    <select id="dish" name="dish">
        <?php if (!empty($dishes)): ?>
            <?php foreach ($dishes as $dish): ?>
                <option value="<?= $dish['dish_id']; ?>">
                    <?= $dish['dish_name']; ?> - <?= $dish['dish_price']; ?> лв. - <?= $dish['dish_gramms']; ?> гр.
                    (Поръчани: <?= $dish['dish_count']; ?>)
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <!-- Други полета и бутони -->

</form>

</body>
</html>

<?php
// Затваряме връзката с базата данни
mysqli_close($dbConn);
?>
