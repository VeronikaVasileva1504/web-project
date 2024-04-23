<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="AddDishStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
            <li><a href="EmployeeManagment.php">Управление на служители</a></li>
                <li><a href="RatingCheck.php">Проверка на отзиви</a></li>
                <li><a href="AddDish.php">Ястия</a></li> 
                <li><a href="AddDrink.php">Напитки</a></li> 
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
    <div class="add_dish">
    <h2>Добави Ястие</h2>
    <form action="" method="post">
        <label for="dish_name">Име на ястието:</label>
        <input type="text" name="dish_name" required>
        <label for="dish_price">Цена:</label>
        <input type="text" name="dish_price" required>
        <label for="dish_gramms">Тегло (грама):</label>
        <input type="text" name="dish_gramms" required>
        <label for="dish_category">Категория:</label>
        <select name="dish_category" required>
            <?php
            include "configDB.php"; 
            $categoriesQuery = "SELECT * FROM categories";
            $categoriesResult = mysqli_query($dbConn, $categoriesQuery);
            
            while ($category = mysqli_fetch_assoc($categoriesResult)) {
                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="add_dish">Добави Ястие</button>
    </form>
</div>

<div class="edit_dish">
    <h2>Редактирай Ястие</h2>
    <form action="" method="post">
        <label for="edit_dish_id">ID на ястието за редакция:</label>
        <input type="text" name="edit_dish_id" required>
        <label for="edit_dish_name">Ново име на ястието:</label>
        <input type="text" name="edit_dish_name">
        <label for="edit_dish_price">Нова цена:</label>
        <input type="text" name="edit_dish_price">
        <label for="edit_dish_gramms">Ново тегло (грама):</label>
        <input type="text" name="edit_dish_gramms">
        <label for="edit_dish_category">Нова категория:</label>
        <select name="edit_dish_category">
            <?php
            $categoriesResult = mysqli_query($dbConn, $categoriesQuery);

            while ($category = mysqli_fetch_assoc($categoriesResult)) {
                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="edit_dish">Редактирай Ястие</button>
    </form>
</div>
 <?php
include "configDB.php"; 

$dishQuery = "SELECT * FROM disj";
$dishResult = mysqli_query($dbConn, $dishQuery);
?>
 <div class="dish-list">
    <form id="showDishTableForm" action="" method="get">
      <button type="button" onclick="toggleDishTable()">Преглед на списъка с ястия</button>
    </form>

    <table id="dishTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Име на ястието</th>
          <th>Цена</th>
          <th>Тегло (грама)</th>
          <th>Категория</th>
        </tr>
      </thead>
      <tbody id="dishTableBody">
        <?php
        while ($row = mysqli_fetch_assoc($dishResult)) {
          echo "<tr>";
          echo "<td>{$row['dish_id']}</td>";
          echo "<td>{$row['dish_name']}</td>";
          echo "<td>{$row['dish_price']}</td>";
          echo "<td>{$row['dish_gramms']}</td>";
          echo "<td>{$row['dish_category']}</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>


  <script>
    function toggleDishTable() {
      var dishTable = document.getElementById('dishTable');

      if (dishTable.style.display === 'none' || dishTable.style.display === '') {
        dishTable.style.display = 'table';
        closeBtn.style.display = 'block';
      } else {
        dishTable.style.display = 'none';
        closeBtn.style.display = 'none';
      }
    }
  </script>

<div class="delete_dish">
    <h2>Изтрий Ястие</h2>
    <form action="" method="post">
        <label for="delete_dish_id">ID на ястието за изтриване:</label>
        <input type="text" name="delete_dish_id" required>
        <button type="submit" name="delete_dish">Изтрий Ястие</button>
    </form>
</div>
<div class="add_category">
    <h2>Добави Категория</h2>
    <form action="" method="post">
        <label for="category_name">Име на категорията:</label>
        <input type="text" name="category_name" required>
        <button type="submit" name="add_category">Добави Категория</button>
    </form>
</div>
<?php

include "configDB.php"; 

$dishQuery = "SELECT * FROM categories";
$categoryResult = mysqli_query($dbConn, $dishQuery);
?>
<div class="category-list">
    <form id="showCategoryTableForm" action="" method="get">
      <button type="button" onclick="toggleCategoryTable()">Преглед на списъка с категории</button>
    </form>

    <table id="categoryTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Име на категорията</th>
        </tr>
      </thead>
      <tbody id="categoryTableBody">
        <?php
        while ($row = mysqli_fetch_assoc($categoryResult)) {
          echo "<tr>";
          echo "<td>{$row['category_id']}</td>";
          echo "<td>{$row['category_name']}</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script>
    function toggleCategoryTable() {
      var categoryTable = document.getElementById('categoryTable');
      if (categoryTable.style.display === 'none' || categoryTable.style.display === '') {
        categoryTable.style.display = 'table';
        closeBtn.style.display = 'block';
      } else {
        categoryTable.style.display = 'none';
        closeBtn.style.display = 'none';
      }
    }
  </script>
<div class="delete_category">
    <h2>Изтрий Категория</h2>
    <form action="" method="post">
        <label for="delete_category_id">ID на категорията за изтриване:</label>
        <input type="text" name="delete_category_id" required>
        <button type="submit" name="delete_category">Изтрий Категория</button>
    </form>
</div>

</body>
</html>
<?php
include "configDB.php"; 
if (isset($_POST['add_dish'])) {
    $dish_name = $_POST['dish_name'];
    $dish_price = $_POST['dish_price'];
    $dish_gramms = $_POST['dish_gramms'];
    $dish_category = $_POST['dish_category'];

    $insertDishQuery = "INSERT INTO disj (dish_name, dish_price, dish_gramms, dish_category) 
                        VALUES ('$dish_name', '$dish_price', '$dish_gramms', '$dish_category')";

    $result = mysqli_query($dbConn, $insertDishQuery);

    if ($result) {
        echo "Ястието е успешно добавено.";
    } else {
        echo "Грешка при добавянето на ястието: " . mysqli_error($dbConn);
    }
}

if (isset($_POST['edit_dish'])) {
    $edit_dish_id = $_POST['edit_dish_id'];
    $edit_dish_name = $_POST['edit_dish_name'];
    $edit_dish_price = $_POST['edit_dish_price'];
    $edit_dish_gramms = $_POST['edit_dish_gramms'];
    $edit_dish_category = $_POST['edit_dish_category'];

    $updateDishQuery = "UPDATE disj
                        SET dish_name = '$edit_dish_name', 
                            dish_price = '$edit_dish_price', 
                            dish_gramms = '$edit_dish_gramms', 
                            dish_category = '$edit_dish_category'
                        WHERE dish_id = '$edit_dish_id'";

    $result = mysqli_query($dbConn, $updateDishQuery);

    if ($result) {
        echo "Ястието е успешно редактирано.";
    } else {
        echo "Грешка при редакция на ястието: " . mysqli_error($dbConn);
    }
}

if (isset($_POST['delete_dish'])) {
    $delete_dish_id = $_POST['delete_dish_id'];

    $deleteDishQuery = "DELETE FROM disj WHERE dish_id = '$delete_dish_id'";

    $result = mysqli_query($dbConn, $deleteDishQuery);

    if ($result) {
        echo "Ястието е успешно изтрито.";
    } else {
        echo "Грешка при изтриването на ястието: " . mysqli_error($dbConn);
    }
}
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    $insertCategoryQuery = "INSERT INTO categories (category_name) VALUES ('$category_name')";

    $result = mysqli_query($dbConn, $insertCategoryQuery);

    if ($result) {
        echo "Категорията е успешно добавена.";
    } else {
        echo "Грешка при добавянето на категорията: " . mysqli_error($dbConn);
    }
}

if (isset($_POST['delete_category'])) {
    $delete_category_id = $_POST['delete_category_id'];

    $deleteCategoryQuery = "DELETE FROM categories WHERE category_id = '$delete_category_id'";

    $result = mysqli_query($dbConn, $deleteCategoryQuery);

    if ($result) {
        echo "Категорията е успешно изтрита.";
    } else {
        echo "Грешка при изтриването на категорията: " . mysqli_error($dbConn);
    }
}

mysqli_close($dbConn);
?>
