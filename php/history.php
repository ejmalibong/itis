<?php
    include "connection.php";

    # Getting the history data from the database
    $sql = "SELECT * FROM `history_table`";

    # Getting the history data from the database with optional date range filter
    if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        # Use the date range in the WHERE clause of the SQL query
        $sql .= " WHERE `date_time` BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    }

    # Check for the transaction type filter
    if(isset($_GET['transaction_type'])) {
        $transaction_type = $_GET['transaction_type'];
        # Append the type filter to the WHERE clause
        if ($transaction_type === 'add_stock') {
            $sql .= " AND (`type` = 'Bulk Add Stock' OR `type` = 'Add Stock')";
        } elseif ($transaction_type === 'deduct_stock') {
            $sql .= " AND (`type` = 'Bulk Deduct Stock' OR `type` = 'Deduct Stock')";
        }
    }

    $sql .= " ORDER BY `history_id` DESC";

    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/nbc_bg.jpg" type="image/x-icon" />
    <title>History</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../style/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../style/style.scss"/>
    <link rel="stylesheet" href="../style/custom-toast.css"/>

    <!-- Include jQuery and jQuery UI libraries -->
    <script src="../script/jquery-3.6.0.min.js"></script>
    <script src="../script/code.jquery.com_ui_1.13.1_jquery-ui.min.js"></script>
    <link rel="stylesheet" href="../style/code.jquery.com_ui_1.13.1_themes_smoothness_jquery-ui.css">
</head>
<body style="background-color: #3275b9;">
    <nav class="navbar bg-body-tertiary sticky-top" style="background-color: #f7f7f7;">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand m-2" onclick="window.location.href='../index.php'" style="vertical-align: middle;"><img src="../images/nbc_bg.jpg" alt="NBC Logo" height="45"></a>
                <a class="navbar-brand m-1 h2" style="vertical-align: middle; color: #3275b9; cursor: default;"><strong>IT Inventory System</strong></a>
            </div>

            <div>
                <a href="../index.php?cancel=true" class="btn btn-danger me-2 shadow">Exit</a>
            </div>
        </div>
    </nav>  
    
    <div class="container" style="padding-bottom: 5vw;">
        <h2 class="mt-3 mb-4 text-center text-white"><strong>History</strong></h2>

        <!-- Filter inputs for date range -->
        <div class="mb-3 row">
            <label for="startDate" class="col-form-label col-md-2 h3 text-white">Start Date</label>
            <div class="col-md-3">
                <input type="date" class="form-control" id="startDate" name="start_date">
            </div>

            <label for="endDate" class="col-form-label col-md-2 h3 text-white">End Date</label>
            <div class="col-md-3">
                <input type="date" class="form-control" id="endDate" name="end_date">
            </div>

            <div class="col-md-2 text-md-end">
                <button class="btn btn-warning" onclick="applyFilters()">Apply Filters</button>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="transactionType" class="col-form-label col-md-2 h3 text-white">Transaction Type</label>
            <div class="col-md-3">
                <select class="form-select" id="transactionType" name="transaction_type">
                    <option value="">All Transactions</option>
                    <option value="add_stock">Add Stock</option>
                    <option value="deduct_stock">Deduct Stock</option>
                </select>
            </div>

            <div class="col-md-7 text-md-end">
                <button class="btn btn-success" onclick="exportToCSV()">Export to CSV</button>
            </div>
        </div>

        <table class="table table-hover text-center table-sm table-bordered shadow-table" id="inventoryTable">
            <thead class="table-dark table-margin"> 
                <tr class="table-header">
                    <th scope="col">Date & Time</th>
                    <th scope="col">Item</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Type</th>
                    <th scope="col">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    # Loop through the history data and display each row
                    while($row = mysqli_fetch_assoc($result)) {
                        // Determine the Bootstrap class for the row based on the 'type' column
                        if($row['type'] === 'Bulk Add Stock' || $row['type'] === 'Add Stock') {
                            $row_class = 'table-success';
                        }elseif($row['type'] === 'Bulk Deduct Stock' || $row['type'] === 'Deduct Stock') {
                            $row_class = 'table-danger';
                        }else {
                            // If it doesn't match any of the specified types, use the default class
                            $row_class = '';
                        }

                        echo "<tr class='$row_class'>";
                        echo "<td>" . $row['date_time'] . "</td>";
                        echo "<td>" . $row['item'] . "</td>";
                        echo "<td>" . $row['qty'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['history_remarks'] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function applyFilters() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const transactionType = document.getElementById('transactionType').value;

            // Build the URL based on selected filters
            let url = `history.php?start_date=${startDate}&end_date=${endDate}`;

            if (transactionType) {
                url += `&transaction_type=${transactionType}`;
            }

            // Redirect to the same page with query parameters for filtering
            window.location.href = url;
        }

        function exportToCSV() {
            // Get the table element
            const table = document.getElementById('inventoryTable');

            // Initialize the CSV content
            let csvContent = 'Date & Time,Item,Qty,Type,Remarks\n';

            // Loop through each row of the table (skip the first row which is the header row)
            for(let i = 1; i < table.rows.length; i++) {
                const cells = table.rows[i].cells;

                // Extract the data from each cell and append to CSV content
                const rowData = [
                    cells[0].innerText,
                    cells[1].innerText,
                    cells[2].innerText,
                    cells[3].innerText,
                    cells[4].innerText
                ];

                csvContent += rowData.join(',') + '\n';
            }

            // Create a Blob object with the CSV content
            const blob = new Blob([csvContent], { type: 'text/csv' });

            // Create a download link for the CSV file
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'history.csv';

            // Programmatically click the link to trigger the download
            link.click();
        }
    </script>

    <!-- Bootstrap -->
    <script src="../script/bootstrap.bundle.min.js"></script>
    </body>
</html>