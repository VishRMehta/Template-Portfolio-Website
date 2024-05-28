<?php
    include("header.php");
    include("blogpostdatabase.php");

    // The lines of code provided below are HTTP headers sent by the server to the browser. They instruct the browser not to store a copy of the webpage in its cache memory. This means that every time the user accesses the webpage, the browser must request the latest version from the server, rather than using a cached (previously stored) version.
    // The headers also include instructions for the browser to recheck with the server if the cached version is still valid. This is done to ensure that the user always gets the most up-to-date content from the server.
    //
    header('Cache-Control: no cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
  
    session_start(); 
    
    $user_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    date_default_timezone_set('UTC');
   
    if(isset($_GET['id'])) {
        
        $post_id = mysqli_real_escape_string($db_conn, $_GET['id']);
        $sql = "SELECT title, content, published FROM blogposts WHERE id = $post_id";
        $result = mysqli_query($db_conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            $post = mysqli_fetch_assoc($result);
            $published_adjusted = date('j F Y, g:i A', strtotime($post['published'] . ' -1 hour'));
        } 
        
        else {
            
            echo "Post not found";
            exit();
        }
    } 
    
    else {
        echo "Invalid request";
        exit();
    }

    
    if(isset($_POST['comment'])) {
        
        $comment_content = mysqli_real_escape_string($db_conn, $_POST['comment']);
        $user_email = $_SESSION['email'];
        
        $comment_date = date('Y-m-d H:i:s'); 
        $insert_sql = "INSERT INTO comments (post_id, comment_content, comment_date, user_email) VALUES ('$post_id', '$comment_content', '$comment_date', '$user_email')";
        
        if(mysqli_query($db_conn, $insert_sql)) {
            header("Location: blogPost.php?id=$post_id");
            exit();
        } 
        
        else {
            echo "Error: " . mysqli_error($db_conn);
        }
    }

    $sql_comments = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY comment_date DESC";
    $result_comments = mysqli_query($db_conn, $sql_comments);
    $comments = mysqli_fetch_all($result_comments, MYSQLI_ASSOC);

    if(isset($_POST['reply_content'])) {
        $reply_content = mysqli_real_escape_string($db_conn, $_POST['reply_content']);
        $comment_id = mysqli_real_escape_string($db_conn, $_POST['comment_id']);
        $user_email = $_SESSION['email'];
        $reply_date = date('Y-m-d H:i:s'); 
        $insert_reply_sql = "INSERT INTO replies (comment_id, reply_content, reply_date, user_email) VALUES ('$comment_id', '$reply_content', '$reply_date', '$user_email')";
        
        if(mysqli_query($db_conn, $insert_reply_sql)) {
            
        } 
        
        else {
            echo "Error: " . mysqli_error($db_conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>
    
    <article class="blogContainer">
        <br>
        <br>
        <section class="blogPost">
            <div class="centeredContent">
                <h1><?php echo $post['title']; ?></h1>
                <h3>
                    <img src="clock.svg" alt="Clock icon"> Published: <?php echo $published_adjusted; ?> UTC
                </h3>
                <p><?php echo $post['content']; ?></p>
                <br>
               
                <?php if ($user_logged_in): ?>
                    <div class="centeredCommentForm"> 
                        <h2>Leave a comment</h2>
                        <form class="commentForm" method="POST" action="">
                            <textarea id="comment" name="comment" placeholder="Write your comment here" required></textarea>
                            <br>
                            <input type="submit" id="postButton" value="Post"/>
                        </form>
                    </div>
                <?php endif; ?>
                <br>

                <?php foreach ($comments as $comment): ?>
                    <div class="blogCard">
                        <h4 class="publishedDate">
                            <img src="clock.svg" alt="Clock icon"> Published: <?php echo date('j F Y, g:i A', strtotime($comment['comment_date'])); ?> UTC
                        </h4>
                        <br>
                        
                        <p>Comment by: <?php echo $comment['user_email']; ?></p>
                        <p><?php echo $comment['comment_content'] ?></p>
                        
                        <?php if ($user_logged_in && $_SESSION['email'] === 'admin@admin.com'): ?>
                            <a href="deleteComment.php?postId=<?php echo $comment['post_id']; ?>&id=<?php echo $comment['comment_id']; ?>" class="deleteButton">Delete</a>
                        <?php endif; ?>
                        
                        <?php if ($user_logged_in): ?>
                            <div class="replyForm">
                                <form class="replyForm" method="POST" action="">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                    <textarea id="reply" name="reply_content" placeholder="Write your reply here" required></textarea>
                                    <br>
                                    <input type="submit" id="replyButton" value="Reply"/>
                                </form>
                            </div>
                        <?php endif; ?>

                        <?php
                            $comment_id = $comment['comment_id'];
                            $sql_replies = "SELECT * FROM replies WHERE comment_id = $comment_id ORDER BY reply_date ASC";
                            $result_replies = mysqli_query($db_conn, $sql_replies);
                            $replies = mysqli_fetch_all($result_replies, MYSQLI_ASSOC);

                            foreach ($replies as $reply): 
                        ?>
                            <div class="reply">
                                <p>Reply by: <?php echo $reply['user_email']; ?></p>
                                <p><?php echo $reply['reply_content']; ?></p>
                                <?php if ($user_logged_in && $_SESSION['email'] === 'admin@admin.com'): ?>
                                    <a href="deleteReply.php?id=<?php echo $reply['reply_id']; ?>&postId=<?php echo $comment['post_id']; ?>" class="deleteButton">Delete</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>
                <?php endforeach; ?>

                <br>
                <br>
            </div>
        </section>
    </article>
</body>
</html>

<?php
    include("footer.html");
?>
