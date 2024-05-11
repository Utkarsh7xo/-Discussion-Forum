<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    if (empty($post_id) || !is_numeric($post_id)) {
        header("Location: home.php");
        exit();
    }
    $comment_text = trim($_POST['comment_text']);
    if (empty($comment_text)) {
        $_SESSION['error'] = "Comment text is required.";
        header("Location: post.php?id=$post_id");
        exit();
    }
    //??
    $comment_text = mysqli_real_escape_string($conn, $comment_text);

    $user_id = $_SESSION['user_id'];

    // Insert comment into database
    $sql = "INSERT INTO comments (post_id, username, comment_text) VALUES ('$post_id', '$user_id', '$comment_text')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to post page with success message
        $_SESSION['success'] = "Comment added successfully.";
        header("Location: post.php?id=$post_id");
        exit();
    } else {
        // Redirect to post page with error message
        $_SESSION['error'] = "Error adding comment. Please try again later.";
        header("Location: post.php?id=$post_id");
        exit();
    }
} else {
    // If form is not submitted, redirect to home page
    header("Location: home.php");
    exit();
}
?>
