<!-- Code by Ferhat OZCELIK -->
<?php

session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

require 'config.php';
?>
<!doctype html>
<html lang="zxx">

<head>
    <title>Multi Email Sender</title>
    <!-- Meta tag Keywords -->
    <meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="Multi Email Sender">
    <meta name="author" content="Ferhat ÖZÇELİK">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- //Meta tag Keywords -->
    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!--//Style-CSS -->
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body style="justify-content: start;">
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Email Details
                            <a href="home-list.php" class="btn btn-primary float-end" style="margin: 8px">Back</a>
                            <a href="email-create.php" class="btn btn-primary float-end" style="margin: 8px">Add Email</a>
                            <a href="email-import.php" class="btn btn-primary float-end" style="margin: 8px">Import</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $sql = "SELECT * FROM bulk_users WHERE email='{$_SESSION['SESSION_EMAIL']}'";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) === 1) {
                                    $row = mysqli_fetch_assoc($result);
                                    $userId = $row['id'];
                                }
                                $query = "SELECT * FROM bulk_email_list WHERE `user_id`='{$userId}'";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $bulk_email_list) {
                                ?>
                                        <tr>
                                            <td><?= $bulk_email_list['id']; ?></td>
                                            <td><?= $bulk_email_list['name']; ?></td>
                                            <td><?= $bulk_email_list['email']; ?></td>
                                            <td><?= $bulk_email_list['group']; ?></td>
                                            <td>
                                                <a href="email-view.php?id=<?= $bulk_email_list['id']; ?>" class="btn btn-info btn-sm">View</a>
                                                <a href="email-edit.php?id=<?= $bulk_email_list['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                <form action="db-manager.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_email" value="<?= $bulk_email_list['id']; ?>" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<h5> No Record Found </h5>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <footer class="footer">
                        <p>by Developed <a href="https://ferhatozcelik.com">Ferhat ÖZÇELİK</a>
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>