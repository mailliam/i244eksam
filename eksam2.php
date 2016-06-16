<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

include('eksam2.html');

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'add') {
    if(checkInsert()) {
        $ese = $_POST['ese'];
        add($ese);
        header('Location:' . $_SERVER['PHP_SELF']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'delete') {
    $id = intval($_POST['id']);
    delete($id);
    header('Location:' . $_SERVER['PHP_SELF']);
}

//Kirjeldatud funktsioonide algus

function checkInsert() {
    if(empty($_POST['ese'])) {
        $errors = array();
        $errors[]='Palun täida, mida poest vajad';
        //include('eksam2.html');
        return false;
    } else {
        $ese = $_POST['ese'];
        return true;
    }
}

function delete($id) {
    global $conn;
    $query = 'DELETE FROM mkeerus_eksam2 WHERE id=? LIMIT 1';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $deleted = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $deleted;
}

function show() {
    global $conn;
    $query = "SELECT * FROM mkeerus_eksam2";
    $result = mysqli_query($conn, $query);
    $rows = array();
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function add ($ese) {
    global $conn;
    $query = 'INSERT INTO mkeerus_eksam2 (ese) VALUES (?)';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $ese);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

?>
