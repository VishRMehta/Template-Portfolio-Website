<?php
include("blogpostdatabase.php");

if(isset($_GET['id']) && isset($_GET['postId'])) {
    $comment_id = mysqli_real_escape_string($db_conn, $_GET['id']);
    $post_id = mysqli_real_escape_string($db_conn, $_GET['postId']);

    
    $delete_replies_sql = "DELETE FROM replies WHERE comment_id = $comment_id";

    if(mysqli_query($db_conn, $delete_replies_sql)) {
       
        $delete_comment_sql = "DELETE FROM comments WHERE comment_id = $comment_id";

        if(mysqli_query($db_conn, $delete_comment_sql)) {
            header("Location: blogPost.php?id=$post_id");
            exit();
        } 
        
        else {
            echo "Error deleting comment: " . mysqli_error($db_conn);
        }
    } 
    
    else {
        echo "Error deleting replies: " . mysqli_error($db_conn);
    }
} 

else {
    header("Location: blogPost.php?id=$post_id");
    exit();
}
?>
