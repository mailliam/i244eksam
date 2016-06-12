<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

if (empty($_COOKIE['kylastus'])) {
    setcookie('kylastus', 'vaartus', time()+5*10);
    $ip = $_SERVER['REMOTE_ADDR'];
    addCookie($ip);
    echo "Küpsis loodud";
} else {
    echo "Küpsis oli juba olemas, väärtus oli: ".$_COOKIE['kylastus'];
}

function addCookie($nimi) {
    global $conn;
    $query = 'INSERT INTO mkeerus_eksam (ip) VALUES (?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 's', $nimi);

    mysqli_stmt_execute($stmt);

    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function getLastVisit() {
    global $conn;
    $query1 = 'SELECT MAX(id) FROM mkeerus_eksam LIMIT 1';
    $result1 = mysqli_query($conn, $query1);
    $rows = array();
    while($row = mysqli_fetch_assoc($result1)) {
        $lastId = $row['MAX(id)'];
        //print_r($lastId);
        $query2 = 'SELECT visit FROM mkeerus_eksam WHERE id = ?';

        $stmt = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt, 'i', $lastId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $time);

        while(mysqli_stmt_fetch($stmt)) {
            $rows = $time;
        }
        echo $rows;
    }
}

include('leht.html');

?>
