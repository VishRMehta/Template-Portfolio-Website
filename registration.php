<?php
    include('header.php');
    include('databases.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>
    <article>
        <section class="login">
            <div class="login-container">
                <h2 class="centeredHeader">Register Here</h2>
                <form action="registration.php" method="post">
                    <label for="email">New Email</label>
                    <input type="email" id="email" name="email">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password">
                    <button type="submit">Register</button>
                </form>
                
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = mysqli_real_escape_string($db_connection, $_POST['email']);
                        $password = mysqli_real_escape_string($db_connection, $_POST['password']);

                        if(empty($email) || empty($password)) {
                            echo "<p class='error-message'>Please enter both email and password</p>";
                        } else {
                            $check_query = "SELECT * FROM registered_users WHERE email = '$email'";
                            $result = mysqli_query($db_connection, $check_query);
                            
                            if(mysqli_num_rows($result) > 0) {
                                echo "<p class='error-message'>Email already exists. Please choose a different email.</p>";
                            } else {
                                $insert_query = "INSERT INTO registered_users (email, password) VALUES ('$email', '$password')";
                                
                                if(mysqli_query($db_connection, $insert_query)) {
                                    header("location: login.php");
                                } else {
                                    echo "Error: " . mysqli_error($db_connection);
                                }
                            }
                        }
                    }
                ?>
                
            </div>
        </section>
    </article>
</body>
</html>

<?php
    include('footer.html');
?>
