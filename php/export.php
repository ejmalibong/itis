<?php
    include "connection.php";

    $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table");
    $stmt->execute();
    $result = $stmt->get_result();

    // Set the appropriate headers for CSV file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="ITIS_ALL.csv"');

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
