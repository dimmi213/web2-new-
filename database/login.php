<?php
session_start();
require_once __DIR__ . "/connectDB.php";

// Check if connection to database is established
if ($conn-> connect_error) {
    die("Connection failed: " . $conn-> connect_error);
}

if (isset($_POST['btn-log'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database
    $sql_users = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result_users = $conn->query($sql_users);

    $sql_clients = "SELECT * FROM clients WHERE email='$email' AND password='$password'";
    $result_clients = $conn->query($sql_clients);


    // Check if query was successful
    if ($result_users) {
        if ($result_users->num_rows > 0) {
            $row_users = $result_users->fetch_assoc();

            if ($row_users['user_type'] == '1' || $row_users['user_type'] == '2') {
                $_SESSION['email'] = $row_users['email'];
                $_SESSION['password'] = $row_users['password'];
                $_SESSION['message'] = 'Login successful';
                if ($row_users['user_type'] == '1'){
                    echo "<script>alert('in');</script>";
                    // $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/";
                    // header("Location: {$baseUrl}Admin/Admin.php");
                    $user_group = 1;
                    $_SESSION['user_group'] = $user_group;
                    if ($user_group !== null){
                        echo "<script>alert('1-notnull');</script>";
                        // header("Location:../Admin.php");
                        header("Location: ../Admin.php");
                    }
                    else {
                        echo "<script>alert('1-null');</script>";
                    }
                }
                else if ($row_users['user_type'] == '2'){
                    // echo "<script>alert('in');</script>";
                    $user_group = 2;
                    $_SESSION['user_group'] = $user_group;
                    // $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/";
                    // header("Location: {$baseUrl}Admin/Admin.php");
                    if ($user_group !== null){
                        if( ! headers_sent () ){
                            header("Location: ../Admin.php");
                        }else {
                            echo "<script>window.location = 'Admin/Admin.php';</script>";
                        }
                        
                        // echo "<script>alert('2-notnull');</script>";
                        // $baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/";
                        // header("Location: {$baseUrl}Admin/Admin.php");
                        // header("Location: ../adminPage.php");
                        // header("Location:http://localhost:8080/Admin/Admin.php");
                        // exit;
                        // echo "<meta http-equiv='refresh' content='0;url=Admin/Admin.php'>";
                        // echo "<script>window.location = 'Admin/Admin.php';</script>";
                    }
                    else {
                        echo "<script>alert('2-null');</script>";
                    }
                }
                exit;

            } else {
                $_SESSION['email'] = $row_users['email'];
                $_SESSION['password'] = $row_users['password'];
                $_SESSION['message'] = 'Login successful';
                header("Location: ../index.php");
            }

        } else {
            echo "Sai email hoặc mật khẩu";
        }

        // Free result set
        $result_users->free_result();

    } 
    if ($result_clients){
        if($result_clients->num_rows > 0){
            $row_clients = $result_clients->fetch_assoc();
            if($row_clients['status']=='active') {
                $_SESSION['email'] = $row_clients['email'];
                $_SESSION['password'] = $row_clients['password'];
                $_SESSION['message'] = 'Login successful';
                header("Location: ../index.php");
            } else {
                echo "Tài khoản không hoạt động";
            }
        } else {
            echo "Sai email hoặc mật khẩu";
        }

        // Free result set
        $result_clients->free_result();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if (isset($_SESSION['message'])) {
        echo "<div>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }

}
?>