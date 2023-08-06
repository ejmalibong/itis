<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "it_inventory_system_db"; 

    # Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check the connection
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    # echo "Connected succesfully";
?>