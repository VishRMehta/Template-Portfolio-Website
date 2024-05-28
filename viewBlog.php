<?php
    include("header.php");
    include("blogpostdatabase.php");
   
    $sql = "SELECT DISTINCT MONTH(published) AS month FROM blogposts ORDER BY month";
    $result = mysqli_query($db_conn, $sql);
    $months = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $selected_month = isset($_GET['month']) ? $_GET['month'] : null;
    $sql = 'SELECT id, title, content, published FROM blogposts';
    
    if ($selected_month) {
        $sql .= " WHERE MONTH(published) = $selected_month";
    }
    
    $result = mysqli_query($db_conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $length = count($posts);
    
    for ($i = 0; $i < $length - 1; $i++) {
        
        for ($j = 0; $j < $length - $i - 1; $j++) {
            $date1 = strtotime($posts[$j]['published']);
            $date2 = strtotime($posts[$j + 1]['published']);
            
            if ($date1 < $date2) {
                $temp = $posts[$j];
                $posts[$j] = $posts[$j + 1];
                $posts[$j + 1] = $temp;
            }
        }
    }

    if (empty($posts)) {
        header("Location: login.php");
        exit(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>
    
    <header class="blogHeader"></header>
    
    <article>
        <section class="blogPosts">
            <h2>Latest Blog Posts</h2>

            <form method="GET" action="">
                <select title="months" name="month" id="monthSelect">
                    <option value="">Filter by Month</option>
                    
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month['month']; ?>" <?php if ($selected_month == $month['month']) echo 'selected'; ?>>
                            <?php echo date('F', mktime(0, 0, 0, $month['month'], 1)); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
                <span>
                    
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <?php if ($_SESSION['email'] === 'admin@admin.com'): ?>
                            <a href="addEntry.php"><input type="button" value="Add Post"/></a>
                        <?php endif; ?>
                    <?php else: ?>
                            <a href="login.php"><input type="button" value="Login to Add Post"/></a>
                    <?php endif; ?>

                </span>
            </form>

            <br>

            <?php foreach ($posts as $post): ?>
                <div class="blogCard">
                    <h4 class="publishedDate">
                        <img src="clock.svg" alt="Clock icon"> Published: <?php echo date('j F Y, g:i A', strtotime($post['published'] . ' -1 hour')); ?> UTC
                    </h4>
                    <br>
                    <br>
                    <a href="blogpost.php?id=<?php echo $post['id']; ?>">
                        <h3><?php echo $post['title']; ?></h3>

                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['email'] === 'admin@admin.com'): ?>
                            <a href="deletePost.php?id=<?php echo $post['id']; ?>" class="deleteButton">Delete</a>
                        <?php endif; ?>
                        
                    </a>
                    <p><?php echo substr($post['content'], 0, 150); ?>...</p>
                </div>
            <?php endforeach; ?>

        </section>
    </article>
    <script src="monthSelector.js"></script>
</body>
</html>

<?php
    include("footer.html");
?>
