<?php
if (!isset($_GET["action"]))
    echo "404";
else {
    $action = $_GET["action"];
    include_once("../dbconnect.php");
    $dbcon = new dbconnect();
    $conn = $dbcon->connect();
    if ($action == "insert" || $action == "update") {
        if (isset($_GET["ID"]))
            $ID = $_GET["ID"];
            $Username = $_GET['Username'];
            $Name = $_GET['Name'];
            $Birthday = $_GET['Birthday'];
            $Gender = $_GET['Gender'];
            $Email = $_GET['Email'];
            $Phone = $_GET['Phone'];
            $Address = $_GET['Address'];
            $Password = $_GET['Password'];
            $Type = $_GET['Type'];
        if ($action == "insert") { //insert
            $sql = "INSERT INTO users(username,fullname,birthday,gender,email,phone,address,password,user_type,Status) VALUES (?,?,?,?,?,?,?,?,?,0)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssss', $Username, $Name, $Birthday,$Gender,$Email, $Phone, $Address, $Password, $Type);
        } else { //update
            $sql = "Update users set username=?, fullname=?, birthday=?, gender=?, email=?, phone=?, address=?, password=?, user_type=? Where id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssssss', $Username, $Name, $Birthday, $Gender, $Email, $Phone, $Address, $Password, $Type, $ID);
        }
        $dbcon->insert($stmt, $conn);
    } else { //delete
        $sql = "DELETE FROM users WHERE id='" . $_GET["ID"] . "'";
        $dbcon->delete($sql, $conn);
    }
}
