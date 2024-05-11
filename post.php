<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) { // If valid id
    header("Location: home.php");
    exit();
}

$post_id = $_GET['id'];
$sql_post = "SELECT * FROM posts WHERE post_id = $post_id";
$result_post = mysqli_query($conn, $sql_post);

if (mysqli_num_rows($result_post) == 0) { //If post exist
    header("Location: home.php");
    exit();
}

$post = mysqli_fetch_assoc($result_post);

// Fetch comments
$sql_comments = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
$result_comments = mysqli_query($conn, $sql_comments);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['post_title']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="post.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <div class="row justify-content-between mt-3">
            <div class="col-md-6">
                <h2><?php echo $post['post_title']; ?></h2>
            </div>
            <div class="home col-md-6 text-right">
                <a href="home.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post['post_title']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">By <?php echo $post['author_name']; ?></h6>
                        <p class="card-text"><?php echo $post['content']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Comments</h4>
                <?php
                if (mysqli_num_rows($result_comments) > 0) {
                    while ($comment = mysqli_fetch_assoc($result_comments)) {
                ?>
                        <div class="card comment mt-2">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $comment['username']; ?> | <?php echo $comment['created_at']; ?></h6>
                                <p class="card-text"><?php echo $comment['comment_text']; ?></p>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <p class="no-comment">No comments yet.</p>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Add a Comment</h4>
                <form method="post" action="comment.php">
                    <div class="form-group">
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <textarea class="form-control" name="comment_text" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="submit btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>