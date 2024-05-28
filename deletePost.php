<?php

include("blogpostdatabase.php");


if(isset($_GET['id'])) {
    $post_id = mysqli_real_escape_string($db_conn, $_GET['id']);
    $sql_get_comment_ids = "SELECT comment_id FROM comments WHERE post_id = $post_id";
   
    $result_comment_ids = mysqli_query($db_conn, $sql_get_comment_ids);
    $comment_ids = [];
    
    while($row = mysqli_fetch_assoc($result_comment_ids)) {
        $comment_ids[] = $row['comment_id'];
    }
   
    foreach($comment_ids as $comment_id) {
        $sql_delete_replies = "DELETE FROM replies WHERE comment_id = $comment_id";
        mysqli_query($db_conn, $sql_delete_replies);
    }

    $sql_delete_comments = "DELETE FROM comments WHERE post_id = $post_id";
    if(mysqli_query($db_conn, $sql_delete_comments)) {
        
        $sql_delete_post = "DELETE FROM blogposts WHERE id = $post_id";
        
        if(mysqli_query($db_conn, $sql_delete_post)) {
         
            header("Location: viewBlog.php");
            exit();
        } 
        
        else {
   
            echo "Error deleting post: " . mysqli_error($db_conn);
        }
    } 
    
    else {
  
        echo "Error deleting comments: " . mysqli_error($db_conn);
    }
} 

else {
    header("Location: viewBlog.php");
    exit();
}
?>
