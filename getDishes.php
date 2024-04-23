<!DOCTYPE html>
<html>
<head>
    <title>Select Dish</title>
</head>
<body>
    <!-- form and select element for categories -->
    <?php
    require 'configDB.php';

    // check if category is selected
    if (isset($_POST['category']) && !empty($_POST['category'])) {
        $selectedCategory = $_POST['category'];

        // prepare and bind SQL statement
        $sql = "SELECT * FROM dis WHERE dish_category = ?";
        $stmt = mysqli_prepare($dbConn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $selectedCategory);

        // execute SQL statement
        mysqli_stmt_execute($stmt);

        // get result and check if dishes found
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            echo '<label for="dish">Select Dish:</label>';
            echo '<select name="dish" id="dish">';

            // display dishes in select element
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['dish_id'] . '">' . $row['dish_name'] . ' - ' . $row['dish_price'] . '</option>';
            }

            echo '</select>';
        } else {
            echo '<p>No dishes found in this category.</p>';
        }
    }

    // close prepared statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($dbConn);
    ?>
</body>
</html>