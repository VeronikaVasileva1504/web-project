<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="BarmanIngrediansCheck.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
            <li><a href="BarmanIngrediansCheck.php">Склад</a></li>
                <li><a href="BarmanIngrediansInDish.php">Управление на напитки</a></li>
                <li><a href="BarmanIngrediansCheck.php">Управление на съставки</a></li> 
        
                <li><a href="MainMenu.php">Log out</a></li>
            </ul>
        </div>
    </header>
    
  
  <!-- Form for adding an ingredient -->
  <div class="add_ingredient">
    <h2>Добави съставка към напитка</h2>
    <form action="" method="post">
      <label for="ing_name">Наименование на съставката:</label>
      <input type="text" name="ing_name" required>
      <label for="ing_count">Брой на съставката:</label>
      <input type="text" name="ing_count" required>
      <label for="ing_measure">Мерна единица:</label>
      <input type="text" name="ing_measure" required>
      <button type="submit" name="add_ingredient">Добави съставка</button>
    </form>
  </div>

  <!-- Form for removing an ingredient -->
  <div class="remove_ingredient">
    <h2>Премахни съставка </h2>
    <form action="" method="post">
      <label for="ing_id">ID на съставката:</label>
      <input type="text" name="ing_id" required>
      <button type="submit" name="remove_ingredient">Премахни съставка</button>
    </form>
  </div>

  <!-- Form for editing an ingredient -->
  <div class="edit_ingredient">
    <h2>Редактирай съставка в напитка</h2>
    <form action="" method="post">
      <label for="ing_id">ID на съставката:</label>
      <input type="text" name="ing_id" required>
      <label for="ing_name">Наименование на съставката:</label>
      <input type="text" name="ing_name" required>
      <label for="ing_count">Брой на съставката:</label>
      <input type="text" name="ing_count" required>
      <label for="ing_measure">Мерна единица:</label>
      <input type="text" name="ing_measure" required>
      <button type="submit" name="edit_ingredient">Редактирай съставка</button>
    </form>
  </div>
  <?php
$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';

// Създаване на връзка с базата данни
$dbConn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

// Проверка за грешки при връзката
if (!$dbConn) {
    die('Не може да осъществи връзка със сървъра: ' . mysqli_connect_error());
}

// Задаване на кодиране на символите
mysqli_query($dbConn, "SET NAMES 'UTF8'");

// Извличане на данните от базата данни
$query = "SELECT * FROM drink_ingredient";

$result = mysqli_query($dbConn, $query);

// Проверка за грешки при изпълнението на заявката
if (!$result) {
    die('Грешка при изпълнение на заявката: ' . mysqli_error($dbConn));
}
?>
  <div class="ingredient-list">
    <h2>Съставки за напитки</h2>
    <table border="1">
      <tr>
        <th>ID на съставката</th>
        <th>Наименование</th>
        <th>Брой </th>
        <th>Мерна единица</th>
      </tr>
      <?php
      // Displaying results from the query
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['ingred_drink_id']}</td>";
        echo "<td>{$row['ingred_drink_name']}</td>";
        echo "<td>{$row['infred_count_drink']}</td>";
        echo "<td>{$row['drink_measiure']}</td>";
        echo "</tr>";
      }
      ?>
    </table>
  </div>

  <script>
    // JavaScript function for toggling the ingredient table visibility
    function toggleIngredientTable() {
      var ingredientTable = document.getElementById('ingredientTable');
      var closeBtn = document.querySelector('.close-btn');

      if (ingredientTable.style.display === 'none' || ingredientTable.style.display === '') {
        ingredientTable.style.display = 'table';
        closeBtn.style.display = 'block';
      } else {
        ingredientTable.style.display = 'none';
        closeBtn.style.display = 'none';
      }
    }
  </script>
  
</body>
</html>
<?php
include "configDB.php";
  // Adding an ingredient
  if (isset($_POST['add_ingredient'])) {
    $ingred_drink_name = $_POST['ing_name'];
    $ingred_count_drink = $_POST['ing_count'];
    $drink_measure = $_POST['ing_measure'];

    $insertIngredientQuery = "INSERT INTO drink_ingredient (ingred_drink_name, infred_count_drink, drink_measiure) 
                              VALUES ('$ingred_drink_name', '$ingred_count_drink', '$drink_measure')";

    $result = mysqli_query($dbConn, $insertIngredientQuery);

    if ($result) {
      echo "Съставката е успешно добавена към напитките.";
    } else {
      echo "Грешка при добавянето на съставката: " . mysqli_error($dbConn);
    }
  }

  // Removing an ingredient
  if (isset($_POST['remove_ingredient'])) {
    $ing_id = $_POST['ing_id'];

    $deleteIngredientQuery = "DELETE FROM drink_ingredient WHERE ingred_drink_id = '$ing_id'";

    $result = mysqli_query($dbConn, $deleteIngredientQuery);

    if ($result) {
      echo "Съставката е успешно премахната от напитките.";
    } else {
      echo "Грешка при премахването на съставката: " . mysqli_error($dbConn);
    }
  }

  // Editing an ingredient
  if (isset($_POST['edit_ingredient'])) {
    $ing_id = $_POST['ing_id'];
    $ingred_drink_name = $_POST['ing_name'];
    $ingred_count_drink = $_POST['ing_count'];
    $drink_measure = $_POST['ing_measure'];

    $updateIngredientQuery = "UPDATE drink_ingredient
                              SET ingred_drink_name = '$ingred_drink_name', 
                                  infred_count_drink = '$ingred_count_drink', 
                                  drink_measiure = '$drink_measure'
                              WHERE ingred_drink_id = '$ing_id'";

    $result = mysqli_query($dbConn, $updateIngredientQuery);

    if ($result) {
      echo "Съставката е успешно редактирана в напитките.";
    } else {
      echo "Грешка при редакция на съставката: " . mysqli_error($dbConn);
    }
  }
  mysqli_close($dbConn);
  ?>
