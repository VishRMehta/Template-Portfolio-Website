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
    <header>
        <a href="index.php"><img src="images/logo.png" /> </a>
        <nav>
            <ul>
                <li><a href="about.php">About Me</a></li>
                <li><a href="skills.php">Skills</a></li>
                <li><a href="education.php">Education</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="viewBlog.php">Blog</a></li>
                
                <?php
                
                session_start(); 
                
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    
                    echo '<li><a href="logout.php">Logout</a></li>';
                    
                    if ($_SESSION['email'] === 'admin@admin.com') {
                        echo '<li><a href="addEntry.php">Add Post</a></li>';
                    }
                }
                
                else {
                    echo '<li><a href="registration.php">Register</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
</body>
</html>