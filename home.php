<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// $username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Fetch all posts
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header row justify-content-between mt-3">
            <div class="col-md-6">
                <h2>Welcome, <?php echo $user_id; ?></h2>
            </div>
            <div class="logout col-md-6 text-right">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="row mt-4">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['post_title']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">By <?php echo $row['author_name']; ?></h6>
                                <p class="card-text"><?php echo $row['summary']; ?></p>
                                <a href="post.php?id=<?php echo $row['post_id']; ?>" class="card-link">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        No posts found.
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>