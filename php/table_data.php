<?php
    include "connection.php";

    $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table");
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        include "display_tbody";
    }
?>