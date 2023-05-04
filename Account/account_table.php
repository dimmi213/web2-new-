<?php
    // session_start();
    // $permission = [    
    //     1 => [
    //         'sanpham' => ['view'],
    //         'order' => ['view'],
    //         'account' => ['view', 'add', 'edit', 'delete'],
    //         'brand' => ['view'],
    //         'category' => ['view'],
    //         'statistics' => ['view']
    //     ],
    //     2 => [
    //         'sanpham' => ['view', 'add', 'edit', 'delete'],
    //         'order' => ['view', 'add', 'edit', 'delete'],
    //         'account' => ['view'],
    //         'brand' => ['view', 'add', 'edit', 'delete'],
    //         'category' => ['view', 'add', 'edit', 'delete'],
    //         'statistics' => ['view', 'add', 'edit', 'delete']
    //     ]
    //     ];
        // $user_group = $_SESSION['user_group'];
        $user_group = isset($_SESSION['user_group']) ? $_SESSION['user_group'] : null;
        // echo "<script>console.log($user_group);</script>";
    // $user_group = 1;
    // session_start();
    // $_SESSION['user_group'] = $user_group;
    // Check if the user has permission to add a product
    if ($user_group !== null && in_array('add', $permissions[$user_group]['account'])) {
        // Display the add product form
        // ...
    } else {
        // Display an error message or redirect the user
        // ...
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form class="input-group float-right w-50 my-3" action="" method="get">
        <input type="hidden" name="chon" value=accounts>
        <input class="form-control w-50" name="s" type="search" placeholder="Search" aria-label="Search" value="<?php
                                                                                                                if (isset($_GET["s"]))
                                                                                                                    echo $_GET["s"];
                                                                                                                ?>" />
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </form>
    <table class="table" id="Account">
        <thead>
            <tr>
                <th role="button">ID</th>
                <th role="button">Username</th>
                <th role="button">Name</th>
                <th role="button">Birthday</th>
                <th role="button">Gender</th>
                <th role="button">Email</th>
                <th role="button">Phone</th>
                <th role="button">Address</th>
                <th role="button">Password</th>
                <th role="button">Type</th>
                <th role="button">Status</th>
                <th role="button">Action</th>

            </tr>
        </thead>
        <?php
        include_once("./dbconnect.php");
        $dbcon = new dbconnect();
        $conn = $dbcon->connect();
        if (isset($_GET['page'])) {
            $page = intval($_GET['page']);
        } else {
            $page = 1;
        }
        // Calculate the starting row for this page
        $rows_per_page = 10;
        $start_row = ($page - 1) * $rows_per_page;
        if (isset($_GET["s"])) {
            $s = $_GET["s"];
            $URL = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $query = "select * from users  where id LIKE '%$s%' OR Username LIKE '%$s%' OR Name LIKE '%$s%' OR Phone LIKE '%$s%' LIMIT $start_row, $rows_per_page";
        } else
            $query = "Select * from users LIMIT $start_row, $rows_per_page";
        $result = $dbcon->select($query, $conn);
        while ($row = mysqli_fetch_assoc($result)) {
            print <<<HERE
                <tr>
                <td>$row[id]</td>
                <td>$row[username]</td>
                <td>$row[fullname]</td>
                <td>$row[birthday]</td>
                <td>$row[gender]</td>
                <td>$row[email]</td>
                <td>$row[phone]</td>
                <td>$row[address]</td>
                <td>$row[password]</td>
                <td>$row[user_type]</td>
                <td>$row[Status]</td>
                <td>
                    <button type="button" id="Accountbtn" onclick="Account_Details('Account')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#UpdateAccount">
                        Details
                    </button>
                </td>
                </tr>
            HERE;
        }
        ?>
    </table>
    <?php
    // Check if the user has permission to add a product
    if ($user_group !== null && in_array('add', $permissions[$user_group]['account'])) {
        echo "<button type='button' class='btn btn-primary mx-5' data-bs-toggle='modal' data-bs-target='#Addaccount'>
                Add new account
            </button>";
    } else {
        // echo "<script>alert('Brand already exists');</script>";
        // echo "<script>location.href='http://localhost:8080/admin/admin.php?chon=brand';</script>";
    }
    ?>
    <!-- <button type="button" class="btn btn-primary mx-5" data-bs-toggle="modal" data-bs-target="#Addaccount">
        Add new account
    </button> -->
    <!--Add Acccount Modal Start-->
    <div class="modal fade" id="Addaccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/Admin/Account/Account_Controller.php">
                        <div class="mb-3 row">
                            <input type="hidden" name="action" value="insert">
                            <label for="Name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="Name" name="Name">
                            <label for="Birthday" class="form-label">Birthday</label>
                            <input type="text" class="form-control" id="Birthday" name="Birthday">
                            <label for="Gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="Gender" name="Gender">
                            <label for="Email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="Email" name="Email">
                            <label for="Phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="Phone" name="Phone">
                            <label for="Adress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="Address" name="Address">
                            <label for="Username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="Username" name="Username">
                            <label for="Password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="Password" name="Password">
                            <label for="Type" class="form-label">Type</label>
                            
                            <select class="form-select" aria-label="Default select example" id="Type" name="Type">
                                <?php
                                $query = "select * from action_group";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=" . $row["action_group_ID"] . ">" . $row["Name"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--Add Account Modal end-->

    <!-- Details modal start -->
    <div class="modal fade" id="UpdateAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/Admin/Account/Account_Controller.php">
                        <div class="mb-3 row">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" class="form-control" id="DID" name="ID" value=>
                            <label for="DName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="DName" name="Name">
                            <label for="DPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="DPhone" name="Phone">
                            <label for="DAdress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="DAddress" name="Address">
                            <label for="DUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="DUsername" name="Username">
                            <label for="DPassword" class="form-label">Password</label>
                            <input type="text" class="form-control" id="DPassword" name="Password">
                            <label for="DType" class="form-label">Type</label>
                            <select class="form-select" aria-label="Default select example" id="DType" name="Type">
                                <?php
                                $query = "select * from action_group";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=" . $row["action_group_ID"] . ">" . $row["Name"] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="DStatus" class="form-label">Status</label>
                            <input type="text" class="form-control" id="DStatus" name="Status" readonly>
                        </div>
                        <div class="modal-footer">
                        <?php
                        if ($user_group !== null && in_array('edit', $permissions[$user_group]['account'])) {
                            echo "<input type='submit' class='btn btn-primary' value='Save'>
                                    <a class='btn btn-danger' onclick='del('Account')'>Delete</a>
                                
                                ";
                        } else {
                            
                        }
                        ?>
                            <!-- <input type="submit" class="btn btn-primary" value="Save">
                            <a class="btn btn-danger" onclick="del('Account')">Delete</a> -->
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <?php
    $query = "SELECT COUNT(*) FROM users";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $total_rows = $row[0];
    $total_pages = ceil($total_rows / $rows_per_page);

    echo '<div class="d-flex justify-content-center">';
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination">';

    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $query = $_GET;
            // replace parameter(s)
            $query['page'] = $i;
            // rebuild url
            $query_result = http_build_query($query);
            echo "<li class='page-item'><a class='page-link' href='$_SERVER[PHP_SELF]?$query_result'>$i</a></li>";
        }
    }

    echo '</ul>';
    echo '</nav>';
    echo '</div>';
    ?>
    
    <!-- Details modal end -->
    <script src="./js.js"></script>
</body>

</html>