<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="EmployeeManagmentStyle.css">
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

<?php
$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'restaurantthree';

$dbConn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

if (!$dbConn) {
    die('Не може да осъществи връзка със сървъра: ' . mysqli_connect_error());
}

mysqli_query($dbConn, "SET NAMES 'UTF8'");

$query = "SELECT p.user_id, p.personal_id, u.first_name, u.last_name, p.role_id, pr.role_name 
          FROM personal p
          JOIN personal_roles pr ON p.role_id = pr.id_roles
          JOIN users u ON p.user_id = u.user_id";

$result = mysqli_query($dbConn, $query);

if (!$result) {
    die('Грешка при изпълнение на заявката: ' . mysqli_error($dbConn));
}
?>
<div class="employees-section">
<h2>Служители</h2>
<table border="1">
    <tr>
        <th>Потребителско ID</th>
        <th>Служебно ID</th>
        <th>Първо Име</th>
        <th>Фамилия</th>
        <th>Професия ID</th>
        <th>Професия</th>
    </tr></div>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['user_id']}</td>";
        echo "<td>{$row['personal_id']}</td>";
        echo "<td>{$row['first_name']}</td>";
        echo "<td>{$row['last_name']}</td>";
        echo "<td>{$row['role_id']}</td>";
        echo "<td>{$row['role_name']}</td>";
        echo "</tr>";
    }

    mysqli_close($dbConn);
    ?>
</table>
</div>
    
<?php
include "configDB.php";

$query = "SELECT * FROM personal_roles";
$result = mysqli_query($dbConn, $query);

if (!$result) {
    die("Грешка при извличане на данните: " . mysqli_error($dbConn));
}
?>


<div class="roles-section">
<h2>Списък с професии</h2>

<table border="1">
    <tr>
        <th>Професия ID</th>
        <th>Професия</th>
    </tr>

    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['id_roles']}</td>";
        echo "<td>{$row['role_name']}</td>";
        echo "</tr>";
    }
    ?>

</table>
</div>

<?php
mysqli_close($dbConn);
?>
<?php
include "configDB.php";

$query = "SELECT user_id, first_name, last_name FROM users";

$result = mysqli_query($dbConn, $query);

if (!$result) {
    die('Грешка при извличане на данни от базата данни: ' . mysqli_error($dbConn));
}
?>



<div class="users-data">
    <h2>Данни за потребители</h2>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Първо Име</th>
            <th>Фамилия</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['user_id']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>


<?php
mysqli_close($dbConn);
?>
       
<div class="add_profesion">
<h2>Добави професия</h2>
<form action="" method="post">
    <label for="role_name">Име на Професия:</label>
    <input type="text" name="role_name" required>
    <button type="submit" name="enterprof">Добави професия!</button>
</form>
</div>
<div class="remove_profesion">
<h2>Премахни професия</h2>
<form action="" method="post">
    <label for="role_name">Име на Професия:</label>
    <input type="text" name="role_name" required>
    <button type="submit" name="deleteprof">Премахни професия!</button>
</form>
</div>
<div class="add_employee">
<h2>Добави служител</h2>
<form action="" method="post">
    <label for="user_id">Потребителско   ID:...</label>
    <input type="text" name="user_id" required>
    <label for="role_id">Професия ID:</label>
    <input type="text" name="role_id" required>
    <button type="submit" name="enteremployee">Добави Служител!</button>
</form>
</div>
<div class="remove_employee">
<h2>Премахни служител</h2>
<form action="" method="post">
    <label for="user_id">Служебно ID:</label>
    <input type="text" name="emp_id" required>
    <button type="submit" name="deleteemployee">Премахни Служител!</button>
</form>
</div>
</body>
</html>
    
    <?php
include "configDB.php";
if (isset($_POST['enterprof'])) {
    $roleName = $_POST['role_name'];

    $insertQuery = "INSERT INTO personal_roles (role_name) VALUES ('$roleName')";

    $result = mysqli_query($dbConn, $insertQuery);

    if ($result) {
        echo "Професията е успешно добавена в базата данни.";
    } else {
        echo "Грешка при добавянето на професия: " . mysqli_error($dbConn);
    }
}
if (isset($_POST['deleteprof'])) {
    $roleName = $_POST['role_name'];

    $deleteQuery = "DELETE FROM personal_roles WHERE role_name = '$roleName'";

    $result = mysqli_query($dbConn, $deleteQuery);

    if ($result) {
        echo "Професията е успешно изтрита от базата данни.";
    } else {
        echo "Грешка при изтриването на професия: " . mysqli_error($dbConn);
    }
}
if (isset($_POST['enteremployee'])) {
    $userId = $_POST['user_id'];
    $roleId = $_POST['role_id'];

    $insertQuery = "INSERT INTO personal (user_id, role_id) VALUES ('$userId', '$roleId')";

    $result = mysqli_query($dbConn, $insertQuery);

    if ($result) {
        echo "Служителят е успешно добавен в базата данни.";
    } else {
        echo "Грешка при добавянето на служител: " . mysqli_error($dbConn);
    }
}
if (isset($_POST['deleteemployee'])) {
    $assignmentsId = $_POST['emp_id'];

    $deleteQuery = "DELETE FROM personal WHERE personal_id = '$assignmentsId'";

    $result = mysqli_query($dbConn, $deleteQuery);

    if ($result) {
        echo "Служителят е успешно изтрит от базата данни.";
    } else {
        echo "Грешка при изтриването на служител: " . mysqli_error($dbConn);
    }
}

mysqli_close($dbConn);
?>

 
