<?php
    include "connection.php";

    // Fetch data from the database
    $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table");
    $stmt->execute();
    $result = $stmt->get_result();

    function deduct_stock_history($item, $quantity, $remarks) {
        global $conn;

        // Set the time zone to Philippine time (Asia/Manila)
        date_default_timezone_set('Asia/Manila');

        # Get the current date and time
        $current_datetime = date("Y-m-d H:i:s");
        $type = "Bulk Deduct Stock";
    
        # Insert the data into your history table
        $sql = "INSERT INTO `history_table` (`date_time`, `item`, `qty`, `type`, `history_remarks`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            # Error preparing the statement and display SQL error
            echo "Error preparing the statement: " . $conn->error;
            return;
        }
    
        $stmt->bind_param("ssiss", $current_datetime, $item, $quantity, $type, $remarks);
    
        if ($stmt->execute()) {
            # Successfully added to history
            echo "Deduct shown succesfully to history.";
        } else {
            # Error adding to history and display SQL error
            echo "Error showing deduct to history: " . $stmt->error;
        }
    }

    if(isset($_POST['submit'])) {
        $atLeastOneInputValid = false;

        foreach($_POST['deduct_stock'] as $item_id => $input_num) {
            // Get the quantity to deduct (ensure it's a non-negative integer)
            $input_num = filter_var($input_num, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
            
            if($input_num !== false && $input_num > 0) {
                // At least one input is valid
                $atLeastOneInputValid = true;

                // Get the current stock information from the database
                $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table WHERE id = ?");
                $stmt->bind_param("i", $item_id);
                $stmt->execute();
                $result = $stmt->get_result();  

                if($row = $result->fetch_assoc()) {
                    // Compute the new values
                    $issued = $row['issued'];
                    $actual_stock = $row['actual_stock'];
                    $max_stock = $row['max_stock'];
                    $unit_price = $row['unit_price'];

                    $new_actual_stock = $actual_stock - $input_num;
                    $new_issued = $input_num + $issued;
                    $new_actual_amount = $new_actual_stock * $unit_price; 

                    if($max_stock != 0) {
                        $new_for_purchase = $max_stock - $new_actual_stock;
                    }else {
                        $new_for_purchase = 0;
                    }

                    # Automatically format the sum to 0 if it is a negative number
                    // if($new_actual_stock < 0) {
                    //     $new_actual_stock = 0;
                    // }
                    // if($new_issued < 0) {
                    //     $new_issued = 0;
                    // }
                    // if($new_actual_amount < 0) {
                    //     $new_actual_amount = 0;
                    // }
                    // if ($new_for_purchase < 0) {
                    //     $new_for_purchase = 0;
                    // }

                    // Update the database with the new values
                    $update_stmt = $conn->prepare("UPDATE itinventorysystem_table SET actual_stock = ?, issued = ?, for_purchase = ?, `actual_amount`=? WHERE id = ?");
                    $update_stmt->bind_param("iiidi", $new_actual_stock, $new_issued, $new_for_purchase, $new_actual_amount, $item_id);
                    $update_stmt->execute();

                    # Call the add_stock_history function to add the entry to the history table
                    $item = $row['item'];
                    $history_remarks = $_POST['history_remarks'][$item_id];
        
                    deduct_stock_history($item, $input_num, $history_remarks);
                }
            }
        }

        if($atLeastOneInputValid) {
            header("Location: ../index.php?msg=<strong>Success! </strong> Stock updated");
            exit();
        }else {
            // Display an alert if no inputs are provided
            echo '<script>
                    alert("Need input!");
                    window.location.href = "../bulk/bulk_deduct.php";
                </script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/nbc_bg.jpg" type="image/x-icon" />
    <title>Bulk Deduct Stock</title>

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

<body style="background-color: #3275b9;" class="hero">
    <form method="post" action="bulk_deduct.php">
        <nav class="navbar bg-body-tertiary sticky-top" style="background-color: #f7f7f7;">
            <div class="container-fluid">
                <div>
                    <a class="navbar-brand m-2" onclick="window.location.href='../index.php'" style="vertical-align: middle;"><img src="../images/nbc_bg.jpg" alt="NBC Logo" height="45"></a>
                    <a class="navbar-brand m-1 h2" style="vertical-align: middle; color: #3275b9; cursor: default;"><strong>IT Inventory System</strong></a>
                </div>

                <div>
                    <a href="../index.php?cancel=true" class="btn btn-danger me-2 shadow">Exit</a>
                    <button type="submit" name="submit" class="btn btn-success shadow">Save</button>
                </div>
            </div>
        </nav>  

        <div class="container-fluid">
            <h2 class="mt-3 mb-4 text-center text-white"><strong>Deduct Stock</strong></h2>
            <table class="table table-hover text-center table-sm table-bordered shadow-table" id="inventoryTable">
                <thead class="table-dark table-margin"> 
                    <tr class="table-header">
                        <th scope="col">Id</th>
                        <th scope="col">Item</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Category</th>
                        <th scope="col">Model/Part No.</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Max Stock</th>
                        <th scope="col">Ordering Point</th>
                        <th scope="col">Min Stock</th>
                        <th scope="col">Unit Price (₱)</th>
                        <th scope="col">Actual Stock</th>
                        <th scope="col">Actual Amount (₱)</th>
                        <th scope="col">Received</th>
                        <th scope="col">Issued</th>
                        <th scope="col">For Purchase</th>
                        <th scope="col">Enter no. of stock to deduct</th>
                        <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    
            <?php
                while($row = $result->fetch_assoc()) {
                    include "table_color.php";
            ?>
                    <tr class="table-body table-scroll <?= htmlspecialchars($row_color) ?>">
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['item']) ?></td>
                        <td><?= htmlspecialchars($row['brand']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['model_part_no']) ?></td>
                        <td><?= htmlspecialchars($row['unit']) ?></td>
                        <td><?= htmlspecialchars($row['max_stock']) ?></td>
                        <td><?= htmlspecialchars($row['ordering_point']) ?></td>
                        <td><?= htmlspecialchars($row['min_stock']) ?></td>
                        <td><?= htmlspecialchars($row['unit_price']) ?></td>
                        <td><?= htmlspecialchars($row['actual_stock']) ?></td>
                        <td><?= htmlspecialchars($row['actual_amount']) ?></td>
                        <td><?= htmlspecialchars($row['received']) ?></td>
                        <td><?= htmlspecialchars($row['issued']) ?></td>
                        <td><?= htmlspecialchars($row['for_purchase']) ?></td>
                        <td>
                            <input type="number" class="form-control" min="0" max="<?php echo $row['actual_stock'];?>" name="deduct_stock[<?= $row['id'] ?>]" value="" placeholder="Deduct quantity">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="history_remarks" name="history_remarks[<?= $row['id'] ?>]" placeholder="Remarks">
                        </td>
                    </tr>
            <?php
                }
            ?>
                </tbody>
            </table>
        </div>
    </form>
    
    <!-- Bootstrap -->
    <script src="../script/bootstrap.bundle.min.js"></script>    
</body>
</html>
