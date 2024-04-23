<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="AddDrinkStyle.css">
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
    <h2>Добави Напитка</h2>
    <form action="" method="post">
      <label for="drink_name">Име на напитката:</label>
      <input type="text" name="drink_name" required>
      <label for="price">Цена:</label>
      <input type="text" name="price" required>
      <label for="mililiters">Обем (мл):</label>
      <input type="text" name="mililiters" required>
      <button type="submit" name="add_drink">Добави Напитка</button>
    </form>
  </div>

  <div class="edit_dish">
    <h2>Редактирай Напитка</h2>
    <form action="" method="post">
      <label for="edit_drink_id">ID на напитката за редакция:</label>
      <input type="text" name="edit_drink_id" required>
      <label for="edit_drink_name">Ново име на напитката:</label>
      <input type="text" name="edit_drink_name">
      <label for="edit_price">Нова цена:</label>
      <input type="text" name="edit_price">
      <label for="edit_mililiters">Нов обем (мл):</label>
      <input type="text" name="edit_mililiters">
      <button type="submit" name="edit_drink">Редактирай Напитка</button>
    </form>
  </div>
  <?php
include "configDB.php"; 
$drinkQuery = "SELECT * FROM drinks";
$drinkResult = mysqli_query($dbConn, $drinkQuery);
?>
  <div class="dish-list">
    <form id="showDishTableForm" action="" method="get">
      <button type="button" onclick="toggleDishTable()">Преглед на списъка с напитки</button>
    </form>
    <table id="dishTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Име на напитката</th>
          <th>Цена</th>
          <th>Обем (мл)</th>
        </tr>
      </thead>
      <tbody id="dishTableBody">
        <?php
        while ($row = mysqli_fetch_assoc($drinkResult)) {
          echo "<tr>";
          echo "<td>{$row['drink_id']}</td>";
          echo "<td>{$row['drink_name']}</td>";
          echo "<td>{$row['drink_price']}</td>";
          echo "<td>{$row['milliliters']}</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>

    <button class="close-btn" onclick="toggleDishTable()">Затвори таблицата</button>
  </div>
  <div class="delete_dish">
    <h2>Изтрий Напитка</h2>
    <form action="" method="post">
      <label for="delete_drink_id">ID на напитката за изтриване:</label>
      <input type="text" name="delete_drink_id" required>
      <button type="submit" name="delete_drink">Изтрий Напитка</button>
    </form>
  </div>

  <script>
    function toggleDishTable() {
      var dishTable = document.getElementById('dishTable');
      var closeBtn = document.querySelector('.close-btn');

      if (dishTable.style.display === 'none' || dishTable.style.display === '') {
        dishTable.style.display = 'table';
        closeBtn.style.display = 'block';
      } else {
        dishTable.style.display = 'none';
        closeBtn.style.display = 'none';
      }
    }
  </script>

</body>
</html>
<?php
include "configDB.php"; 
if (isset($_POST['add_drink'])) {
    $drink_name = $_POST['drink_name'];
    $price = $_POST['price'];
    $mililiters = $_POST['mililiters'];

    $insertDrinkQuery = "INSERT INTO drinks (drink_name, drink_price, milliliters) 
                        VALUES ('$drink_name', '$price', '$mililiters')";

    $result = mysqli_query($dbConn, $insertDrinkQuery);

    if ($result) {
      echo "Напитката е успешно добавена.";
    } else {
      echo "Грешка при добавянето на напитката: " . mysqli_error($dbConn);
    }
  }

  if (isset($_POST['edit_drink'])) {
    $edit_drink_id = $_POST['edit_drink_id'];
    $edit_drink_name = $_POST['edit_drink_name'];
    $edit_price = $_POST['edit_price'];
    $edit_mililiters = $_POST['edit_mililiters'];

    $updateDrinkQuery = "UPDATE drinks
                        SET drink_name = '$edit_drink_name', 
                            drink_price = '$edit_price', 
                            milliliters = '$edit_mililiters'
                        WHERE drink_id = '$edit_drink_id'";

    $result = mysqli_query($dbConn, $updateDrinkQuery);

    if ($result) {
      echo "Напитката е успешно редактирана.";
    } else {
      echo "Грешка при редакция на напитката: " . mysqli_error($dbConn);
    }
  }

  if (isset($_POST['delete_drink'])) {
    $delete_drink_id = $_POST['delete_drink_id'];

    $deleteDrinkQuery = "DELETE FROM drinks WHERE drink_id = '$delete_drink_id'";

    $result = mysqli_query($dbConn, $deleteDrinkQuery);

    if ($result) {
      echo "Напитката е успешно изтрита.";
    } else {
      echo "Грешка при изтриването на напитката: " . mysqli_error($dbConn);
    }
  }

  mysqli_close($dbConn);
  ?>