<?php
    include "connection.php";
    
    function deduct_stock_history($item, $quantity, $remarks) {
        global $conn;

        // Set the time zone to Philippine time (Asia/Manila)
        date_default_timezone_set('Asia/Manila');

        # Get the current date and time
        $current_datetime = date("Y-m-d H:i:s");
        $type = "Deduct Stock";
    
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

    $id = $_GET['id'];
    
    # Getting the values from the database
    $sql = "SELECT * FROM `itinventorysystem_table` WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    # Check if the form is submitted
    if(isset($_POST['submit'])) {
        $input_num = $_POST['deduct_stock'];

        $issued = $row['issued'];
        $actual_stock = $row['actual_stock'];
        $max_stock = $row['max_stock'];
        $unit_price = $row['unit_price'];
        
        # Compute actual_stock
        $new_actual_stock = $actual_stock - $input_num;

        # Compute issued
        $new_issued = $input_num + $issued;

        # Compute for_purchase
        if($max_stock != 0) {
            $new_for_purchase = $max_stock - $new_actual_stock;
        }else {
            $new_for_purchase = 0;
        }
        # Compute the actual amount
        $new_actual_amount = $new_actual_stock * $unit_price; 

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

        # Update the item's actual_stock quantity
        $sql = "UPDATE `itinventorysystem_table` SET `actual_stock`=?, `issued`=?, `for_purchase`=?, `actual_amount`=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiidi", $new_actual_stock, $new_issued, $new_for_purchase, $new_actual_amount, $id);

        if($stmt->execute()) {
            echo "Stock deducted successfully.";
            header("Refresh:0");
            echo "<script>window.open('../index.php','_self')</script>";

            if($result) {
                header("Location: ../index.php?msg=<strong>Success! </strong> Stock updated");
                echo "<script>window.open('../index.php','_self')</script>";
            }else {
                echo "Failed: " . $conn->error;
            }
        }else {
            echo "Error deducting stock: " . $stmt->error;
        }

        # Call the add_stock_history function to add the entry to the history table
        $item = $row['item'];
        $history_remarks = $_POST['history_remarks'];
        
        deduct_stock_history($item, $input_num, $history_remarks);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/nbc_bg.jpg" type="image/x-icon" />
    <title>Deduct Stock</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../style/bootstrap.min.css"/>

    <!-- Style -->
    <link rel="stylesheet" href="../style/style.scss"/>
    <link rel="stylesheet" href="../style/custom-toast.css"/>
</head>

<body style="background-color: #3275b9;">
    <nav class="navbar bg-body-tertiary sticky-top" style="background-color: #f7f7f7;">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand m-2" onclick="window.location.href='../index.php'" style="vertical-align: middle;"><img src="../images/nbc_bg.jpg" alt="NBC Logo" height="45"></a>
                <a class="navbar-brand m-1 h2" style="vertical-align: middle; color: #3275b9; cursor: default;"><strong>IT Inventory System</strong></a>
            </div>
        </div>
    </nav>   

    <div class="container">
        <h2 class="mt-3 mb-4 text-center text-white"><strong>Deduct Stock</strong></h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>">
            <div class="form-group mb-4">
                <input type="number" class="form-control shadow" id="deduct_stock" name="deduct_stock" min="0" max="<?php echo $row['actual_stock'];?>" placeholder="Enter quantity to deduct" required>
            </div>

            <div class="form-group mb-4">
                <input type="text" class="form-control shadow" id="history_remarks" name="history_remarks" placeholder="Remarks">
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <a href="../index.php?cancel=true" class="btn btn-danger shadow me-2">Exit</a>
                <button type="submit" class="btn btn-success shadow" name="submit">Deduct Stock</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap -->
    <script src="../script/bootstrap.bundle.min.js"></script>
</body>
</html>
