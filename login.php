<?php
    include('header.php');
    include('databases.php');

    session_start();
    
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("location: viewBlog.php"); 
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>
    
    <article>
        <section class="login">
            <div class="login-container">
                <?php
                include('login.html');

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

                    if(empty($email) || empty($password)) {
                        
                        echo "<p class='error-message'>Please enter both email and password</p>";
                    } else {
                        
                        $sql_query = "SELECT email, password FROM registered_users WHERE email = '$email' AND password = '$password'";
                        $result = mysqli_query($db_connection, $sql_query);
            
                        if(mysqli_num_rows($result) == 1) {
                            
                            session_start();
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['email'] = $email;
                            $_SESSION['loggedin'] = true;
                            if ($row['email'] === 'admin@admin.com') {
                                header("location: addEntry.php");
                            } else {
                                header("location: viewBlog.php");
                            }
                            exit();
                        } else {
                           
                            echo "<p class='error-message'>Invalid email or password</p>";
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