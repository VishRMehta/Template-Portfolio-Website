<?php
    session_start();
    
    if (isset($_GET['id']) && isset($_GET['postId'])) {
        include("blogpostdatabase.php");
        
        $reply_id = mysqli_real_escape_string($db_conn, $_GET['id']);
        $post_id = mysqli_real_escape_string($db_conn, $_GET['postId']);
   
        $delete_sql = "DELETE FROM replies WHERE reply_id = '$reply_id'";
        if (mysqli_query($db_conn, $delete_sql)) {
          
            header("Location: blogPost.php?id=$post_id");
            exit();
        } 
        
        else {    
            echo "Error deleting reply: " . mysqli_error($db_conn);
        }
    } 
    
    else {
        echo "Invalid request";
    }
?>