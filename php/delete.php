<?php
    # For delete button
    include "connection.php";

    $id = $_GET['id'];

    $sql = "DELETE FROM `itinventorysystem_table` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        header("Location: ../index.php?msg=<strong>Success! </strong>Item deleted");
    }else {
        echo "Failed: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
?>
