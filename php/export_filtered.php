<?php
    include "connection.php";

    // Retrieve the filter parameter from the POST request
    $filter = isset($_POST['filter']) ? $_POST['filter'] : '';

    // Prepare the SQL statement based on the filter parameter
    if($filter === 'ordering-point') {
        $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table WHERE actual_stock > min_stock AND actual_stock <= ordering_point");
    }elseif ($filter === 'minimum-stock') {
        $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table WHERE actual_stock <= min_stock");
    }else {
        // Invalid filter parameter or no filter selected, redirect to the index page or handle accordingly
        header('Location: index.php');
        exit();
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Set the appropriate headers for CSV file download
    if($filter === 'ordering-point') {
         header('Content-Type: text/csv');
         header('Content-Disposition: attachment; filename="ITIS_ORDERING-POINT.csv"');
    }
    if($filter === 'minimum-stock') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="ITIS_MINIMUM-STOCK.csv"');
    }

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Set the CSV column headers
    $headers = array('Id', 'Item', 'Brand', 'Category', 'Model/Part No.', 'Specifications', 'Unit', 'Max Stock', 'Ordering Point', 'Min Stock', 'Unit Price (₱)', 'Initial Stock', 'Actual Stock', 'Actual Amount (₱)', 'Received', 'Issued', 'For Purchase', 'Location', 'Supplier', 'Remarks');
    fputcsv($output, $headers);

    // Loop through the data and write each row to the CSV file
    while($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close the file pointer
    fclose($output);
?>
