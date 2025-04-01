<?php
include 'connect.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $requests = $_POST['requests'];
    $table_id = $_POST['table_id']; 

    $sql = "INSERT INTO reservations (name, phone, email, date, time, people, requests, table_id) 
            VALUES ('$name', '$phone', '$email', '$date', '$time', '$people', '$requests', '$table_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Reservation successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();   
}
?>