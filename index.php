<?php
    include("header.php");
    session_start(); 

    $buttonText = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? "Logged In" : "Login";
    $buttonHref = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? "#" : "login.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>
    <article>
        <section class="intro" id="intro">
            <img src="images/logo.png" />
            
            <div class="introbox"> 
                <h1>Hi, My Name is Vishva Mehta</h1>
                <h3>I Want To Be A Software Engineer... That Actually Makes A Difference.</h3>
                <aside><a href="<?php echo $buttonHref; ?>"><input type="button" name="Login" value="<?php echo $buttonText; ?>" id="login" /></a></aside>
            </div>
        </section>
    </article>
</body>
</html>

<?php
    include("footer.html");
    if(isset($_POST["Login"])) {
        header("Location: login.html");
    }
?>
