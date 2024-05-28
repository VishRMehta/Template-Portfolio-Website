<!-- addPost.php -->
<?php
session_start();
include("blogpostdatabase.php");

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $title = $_POST["title"];
    $content = $_POST["content"];

    $title = mysqli_real_escape_string($db_conn, $title);
    $content = mysqli_real_escape_string($db_conn, $content);

    $sql = "INSERT INTO blogposts (title, content, published) VALUES ('$title', '$content', NOW())";


    if (mysqli_query($db_conn, $sql)) {
        header("location: viewBlog.php");
    } 
    
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db_conn);
    }
    
    exit;
}
?>
