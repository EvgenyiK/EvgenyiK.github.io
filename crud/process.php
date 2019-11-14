<?php
$conn = mysqli_connect("localhost","root","","crud_vue");
if ($conn->connect_error){
    die("Connection failed!".$conn->connect_error);
}

$result = array('error'=>false);
$action = '';

if (isset($_GET['action'])){
    $action=$_GET['action'];
}

if ($action == 'read'){
    $sql = $conn->query("SELECT * FROM users");
    $users = array();
    while ($row = $sql->fetch_assoc()){
        array_push($users,$row);
    }
    $result['users'] = $users;
}

if ($action == 'create'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = $conn->query("INSERT INTO users (name,email,phone)
     VALUES ('$name','$email','$phone')");

    if ($sql){
        $result['message'] = "User added successfully!";
    }
    else{
        $result['error'] = true;
        $result['message'] = "Failed to add user!";
    }
}

if ($action == 'delete'){

    $id = $_POST['id'];
    $sql = $conn->query("DELETE FROM users WHERE id='$id'");

    if ($sql){
        $result['message'] = "User Deleted!";
    }
    else{
        $result['error'] = true;
        $result['message'] = "Failed to delete user!";
    }
}
$conn->close();
echo json_encode($result);