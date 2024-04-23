<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="RatingStyle.css">
</head>
<body>
    <header>
        <div class="menu">
            <ul>
                <li><a href="Menu.php">Меню</a></li>
                <li><a href="Order.php">Поръчка</a></li>
                <li><a href="Reservation.php">Резервация</a></li> 
                <div class="logo">
                    <a href="MainMenu.php"> 
                        <img src="italy.png" alt="Лого">
                    </a>
                </div>
                <li><a href="ForUsPage.php">За нас</a></li>
                <li><a href="Rating.php">Отзиви</a></li>
                <li><a href="AccountRegistrationForm.php">Account</a></li>
            </ul>
        </div>
    </header>
    <h2>Напишете вашият отзив!</h2>
    <div class="rating">
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        
        <label for="review_text">Какво смятате за нашия ресторант:</label>
        <textarea name="review_text" rows="4" required></textarea>
        
        <label for="rating">Изберете рейтинг:</label>
        <input type="radio" name="rating" value="1"> 1
        <input type="radio" name="rating" value="2"> 2
        <input type="radio" name="rating" value="3"> 3
        <input type="radio" name="rating" value="4"> 4
        <input type="radio" name="rating" value="5"> 5
        
        <input type="submit" name="submit" value="Изпратете отзива си !">
    </form>
</div>
</body>
</html>
<?php
include "configDB.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $review_text = $_POST["review_text"];
    $rating = $_POST["rating"];

    $username = mysqli_real_escape_string($dbConn, $username);
    $review_text = mysqli_real_escape_string($dbConn, $review_text);

    $user_query = "SELECT user_id FROM users WHERE username = '$username'";
    $user_result = mysqli_query($dbConn, $user_query);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row["user_id"];

        $insert_query = "INSERT INTO reviews (user_id, review_text, rating) VALUES ('$user_id', '$review_text', '$rating')";
        $insert_result = mysqli_query($dbConn, $insert_query);

        if ($insert_result) {
            echo "Отзивът Ви е изпратен.Благодарим Ви!";
        } else {
            echo "Грешка при писане на ревю: " . mysqli_error($dbConn);
        }
    } else {
        echo "Не намерен потребител.";
    }

    mysqli_close($dbConn);
}
?>