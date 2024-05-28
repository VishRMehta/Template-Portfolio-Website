<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("location: login.php");
        exit();
    }

    if ($_SESSION['email'] !== "admin@admin.com") {
        header("location: viewBlog.php");
        exit();
    }

    include("header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/errors.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>

    <header class="blogHeader"></header>
    
    <article>
        <section class="addBlog">
            <div class="addBlogContainer"> 
                <aside>
                    <h4>Welcome Back</h4>
                </aside>
                <h2>Add Post Form</h2>
                <form id="addPostForm" action="addPost.php" method="post">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" size="60" placeholder="Title">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="10" cols="60" placeholder="Enter your text here"></textarea>
                    <button type="submit">Post</button>
                    <button type="button" class="clearButton">Clear</button>
                </form>
            </div>
        </section>
    </article>

    <script src="addPostForm.js"></script>

</body>
</html>

<?php
    include("footer.html");
?>
