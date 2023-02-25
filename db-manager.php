<!-- Code by Ferhat OZCELIK -->
<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

//Load Composer's autoloader
require 'vendor/autoload.php';
require 'config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['save_excel_data'])) {
    $fileName = $_FILES['import_file']['name'];
    if (!empty($fileName)) {
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowed_ext = ['xls', 'csv', 'xlsx'];
        $sql = "SELECT * FROM bulk_users WHERE email='{$_SESSION['SESSION_EMAIL']}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $userId = $row['id'];

            if (in_array($file_ext, $allowed_ext)) {
                $inputFileNamePath = $_FILES['import_file']['tmp_name'];
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                $data = $spreadsheet->getActiveSheet()->toArray();
                foreach ($data as $row) {
                    $fullname = $row['0'];
                    $email = $row['1'];
                    $group = $row['2'];
                    $query = "INSERT INTO bulk_email_list (`name`, `user_id`, `email`, `group`) VALUES ('{$fullname}', '{$userId}', '{$email}', '{$group}')";
                    $result = mysqli_query($con, $query);
                    $query_run = mysqli_query($conn, $query);
                    if ($query_run) {
                        $_SESSION['message'] = "Successfully Imported";
                        header('Location: emaillist.php');
                    } else {
                        $_SESSION['message'] = "Not Imported";
                        header('Location: email-import.php');
                    }
                }
            }
        } else {
            $_SESSION['message'] = "Invalid File";
            header('Location: email-import.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid File";
        header('Location: email-import.php');
        exit(0);
    }
}

if (isset($_POST['delete_email'])) {

    $sql = "SELECT * FROM bulk_users WHERE email='{$_SESSION['SESSION_EMAIL']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['id'];

        $email_id = mysqli_real_escape_string($conn, $_POST['delete_email']);
        $query = "DELETE FROM bulk_email_list WHERE `id`='{$email_id}' AND `user_id`='{$userId}' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Email Deleted Successfully";
            header("Location: emaillist.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Email Not Deleted";
            header("Location: emaillist.php");
            exit(0);
        }
    }
}

if (isset($_POST['update_email'])) {

    $sql = "SELECT * FROM bulk_users WHERE email='{$_SESSION['SESSION_EMAIL']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['id'];

        $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $group = mysqli_real_escape_string($conn, $_POST['group']);

        $query = "UPDATE bulk_email_list SET `name`='{$name}', `email`='{$email}', `group`='{$group}' WHERE `id`='{$email_id}' AND `user_id`='{$userId}' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Email Updated Successfully";
            header("Location: emaillist.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Email Not Updated";
            header("Location: emaillist.php");
            exit(0);
        }
    }
}

if (isset($_POST['save_email'])) {

    $sql = "SELECT * FROM bulk_users WHERE email='{$_SESSION['SESSION_EMAIL']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['id'];


        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $group = mysqli_real_escape_string($conn, $_POST['group']);

        $query = "INSERT INTO bulk_email_list (`name`, `user_id`, `email`, `group`) VALUES ('{$name}', '{$userId}', '{$email}', '{$group}')";


        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $_SESSION['message'] = "Email Add Successfully";
            header("Location: email-create.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Email Not Created";
            header("Location: email-create.php");
            exit(0);
        }
    }
}
