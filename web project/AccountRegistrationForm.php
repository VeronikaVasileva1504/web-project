<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Italy</title>
    <link rel="stylesheet" href="AccoutRegistrationStyle.css">
</head>
<body>

<div class="cont">
  <div class="form sign-in">
    <div class="welcomeText">
      <h2>Добре дошли!</h2>
    </div>
       <form method="post" action=""  id="loginForm">
    <div class="emailLabel">
      <label>
        <span>Username</span>
        <input type="text" name="username2" />
      </label>
    </div>
    <label>
      <span>Парола</span>
      <input type="password" name="password2"/>
    </label>
    <p class="forgot-pass">Забравена парола?</p>
    <button type="submit" name="vhod" class="submit" id="loginButton">Влез</button>
  </div>
  
  <div class="sub-cont">
    <div class="img">
      <div class="img__text m--up">
      <div class="text-container">
        <h3>Нямате акаунт? Моля, регистрирайте се!</h3>
      </div>
      </div>
      <div class="img__text m--in">
      <div class="text-container">
        <h3>Ако имате акаунт, моля влезте.</h3>
      </div>
      </div>
      <div class="buttons">
      <div class="img__btn">
        <span class="m--up">Регистрация</span>
        <span class="m--in">Влез</span>
      </div>
      </div>
    </div>
    
    <div class="form sign-up">
        <form method="post" action="" id="registrationForm">
      <h2>Създайте си акаунт</h2>
      <label>
        <span>Username</span>
        <input type="text" name="username" />
      </label>
      <label>
        <span>Първо име</span>
        <input type="text" name="first_name" />
      </label>
      <label>
        <span>Фамилия</span>
        <input type="text" name="last_name"/>
      </label>
      <label>
        <span>Email</span>
        <input type="email" name="email" />
      </label>
      <label>
        <span>Парола</span>
        <input type="password" name="password"/>
      </label>
      <button type="submit" name="registration" class="submit" id="registrationButton">Регистрирай се</button>
    </div>
  </div>
</div>

<script>
  document.querySelector('.img__btn').addEventListener('click', function() {
    document.querySelector('.cont').classList.toggle('s--signup');
  });

  
</script>
<script>
 
  document.getElementById('loginButton').addEventListener('click', function(){});
</script>
<script>
  document.getElementById('loginButton').addEventListener('click', function(event) {
    //event.preventDefault(); // Prevent the default form submission

    // Add your custom login logic here if needed

    document.getElementById('loginForm').submit();
  });
</script>

<script>
 
 document.getElementById('registrationButton').addEventListener('click', function() {
    document.getElementById('registrationForm').submit();
});</script>
</body>
</html>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registration'])) {
        // Registration form is submitted
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        include "configDB.php";
        $sql = "INSERT INTO users (username, password, first_name, last_name, email) VALUES ('$username', '$password', '$first_name', '$last_name', '$email')";
        $result = mysqli_query($dbConn, $sql);

        if (!$result) {
            die('Има грешка с базата данни. Моля, опитайте пак.');
        }
        echo "Вашата регистрация е успешна!";
    } elseif (isset($_POST['vhod'])) {
        // Login form is submitted
        $username = $_POST['username2'];
        $password = $_POST['password2'];

        include "configDB.php";
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($dbConn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // Check password
                if ($row['password'] == $password) {
                    // Successful login
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];

                    $user_id = $row['user_id'];
                $role_sql = "SELECT role_name FROM personal
                             JOIN personal_roles ON personal.role_id = personal_roles.id_roles 
                             WHERE user_id='$user_id'";
                $role_result = mysqli_query($dbConn, $role_sql);

                if ($role_result) {
                    $role_row = mysqli_fetch_assoc($role_result);
                    if ($role_row) {
                        // Redirect based on user role
                        switch ($role_row['role_name']) {
                            case 'Manager':
                                header("Location: ManagerMenu.php");
                                exit();
                            case 'Waiter':
                                header("Location: WaiterMenu.php");
                                exit();
                            case 'Chef':
                                header("Location: ChefMenu.php");
                                exit();
                            case 'Barman':
                                header("Location: BarmanMenu.php");
                                exit();
                            default:
                                // Handle other roles or redirect to a default page
                                header("Location: MainMenu.php");
                                exit();
                        }
                    }
                }

                // Default redirect if role retrieval fails
                header("Location: MainMenu.php");
                exit();
            } else {
                // Incorrect password
                echo "Грешна парола. Моля, опитайте отново.";
            }
        } else {
            // Invalid username or password
            echo "Невалидно потребителско име или парола";
        }
    } else {
        // Database error
        die('Има грешка с базата данни. Моля, опитайте пак.');
    }
}
}
    

?>


