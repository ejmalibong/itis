<?php
    include "connection.php";
    include "add_remove_btn.php";

    $id = $_GET['id'];

    $sql_select = "SELECT actual_stock, unit_price FROM `itinventorysystem_table` WHERE id=?";
    $stmt_select = mysqli_prepare($conn, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result = mysqli_stmt_get_result($stmt_select);

    // Fetch the result from the prepared statement
    $row = mysqli_fetch_assoc($result);

    // Get the value from the fetched row
    $actual_stock = $row['actual_stock'];
    $unit_price = $row['unit_price'];

    if (isset($_POST['submit'])) {
        $item = $_POST['item'];
        $brand = $_POST['brand'];
        $category = $_POST['category'];
        $model_part_no = $_POST['model_part_no'];
        $specifications = $_POST['specifications'];
        $unit = $_POST['unit'];
        $max_stock = $_POST['max_stock'];
        $ordering_point = $_POST['ordering_point']; 
        $min_stock = $_POST['min_stock'];
        $unit_price = $_POST['unit_price'];
        $location = $_POST['location'];
        $supplier = $_POST['supplier'];
        $remarks = $_POST['remarks'];

        if($max_stock != 0) {
            $for_purchase = $max_stock - $actual_stock;
        }else {
            $for_purchase = 0;
        }

        $actual_amount = $actual_stock * $unit_price;

        if($actual_amount < 0) {
            $actual_amount = 0;
        }
        if($for_purchase < 0) {
            $for_purchase = 0;
        }

        // Prepare the SQL statement with placeholders
        $sql = "UPDATE `itinventorysystem_table` SET `item`=?, `brand`=?, `category`=?, `model_part_no`=?, `specifications`=?,
        `unit`=?, `max_stock`=?, `ordering_point`=?, `min_stock`=?, `unit_price`=?, `actual_amount`=?,`for_purchase`=?, `location`=?, `supplier`=?, `remarks`=? WHERE id=?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssiiiddissss",
            $item,
            $brand,
            $category,
            $model_part_no,
            $specifications,
            $unit,
            $max_stock,
            $ordering_point,
            $min_stock,
            $unit_price,
            $actual_amount,
            $for_purchase,
            $location,
            $supplier,
            $remarks,
            $id
        );

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: ../index.php?msg=<strong>Success! </strong>Item updated");
            exit;
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/nbc_bg.jpg" type="image/x-icon" />
    <title>Edit Item</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../style/bootstrap.min.css"/>

    <!-- Style -->
    <link rel="stylesheet" href="../style/style.scss"/>
    <link rel="stylesheet" href="../style/custom-toast.css"/>

    <!-- jQuery -->
    <script src="../script/jquery-3.6.0.min.js"></script>
    
    <script src="../script/add_remove_btn.js"></script>
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
        <h2 class="mt-3 mb-4 text-center text-white"><strong>Edit Item</strong></h2>

        <?php
            // Fetch item details from the database
            $sql = "SELECT * FROM `itinventorysystem_table` WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
        ?>

        <!-- Forms -->
        <div class="container d-flex justify-content-center">
            <form method="post" style="width:50vw; min-width:300px;">
                <div class="mb-1">
                    <label class="form-label">Item <span class="required-field">*</span></label>
                    <input type="text" class="form-control shadow" name="item" value="<?php echo $row['item'] ?>" required>
                </div>
                
                <div class="mb-1">
                    <label class="form-label">Brand</label>
                    <input type="text" class="form-control shadow" name="brand" value="<?php echo $row['brand'] ?>">
                </div>
                
                <div class="form-group mb-2">
                    <label class="form-label">Category</label>
                    <select class="form-control shadow" name="category">
                        <option disabled selected>Choose a category</option>
                        <?php foreach ($categoryOptions as $categoryOption): ?>
                            <option><?php echo $categoryOption; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-1">
                    <label class="form-label">Model/Part No.</label>
                    <input type="text" class="form-control shadow" name="model_part_no" value="<?php echo $row['model_part_no'] ?>">
                </div>

                <div class="mb-1">
                    <label class="form-label">Specifications</label>
                    <input type="text" class="form-control shadow" name="specifications" value="<?php echo $row['specifications'] ?>">
                </div>
                
                <div class="form-group mb-1">
                    <label class="form-label">Unit</label>
                    <select class="form-control shadow" name="unit">
                        <option disabled selected>Choose a unit</option>
                        <?php foreach ($unitOptions as $unitOption): ?>
                            <option><?php echo $unitOption; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-1">
                    <label class="form-label">Maximum Stock <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" name="max_stock" value="<?php echo $row['max_stock'] ?>" required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Ordering Point <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" name="ordering_point" value="<?php echo $row['ordering_point'] ?>" required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Minimum Stock <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" name="min_stock" value="<?php echo $row['min_stock'] ?>" required>
                </div>

                <div class="mb-1">
                    <label class="form-label">Unit Price (₱) <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" step="any" name="unit_price" value="<?php echo $row['unit_price'] ?>" required>
                </div>
                
                <div class="form-group mb-1">
                    <label class="form-label">Location</label>
                    <select class="form-control shadow" name="location">
                        <option disabled selected>Choose a location</option>
                        <?php foreach ($locationOptions as $locationOption): ?>
                            <option><?php echo $locationOption; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-1">
                    <label class="form-label">Supplier</label>
                    <input type="text" class="form-control shadow" name="supplier" value="<?php echo $row['supplier'] ?>">
                </div>

                <div class="mb-1">
                    <label class="form-label">Remarks</label>
                    <input type="text" class="form-control shadow" name="remarks" value="<?php echo $row['remarks'] ?>">
                </div>
                
                <input type="hidden" name="actual_stock shadow" value="<?php echo $row['actual_stock'] ?>">

                <!-- Edit and cancel button -->
                <div class="pb-5 pt-4" style="display: flex; justify-content: flex-end;">
                    <a href="../index.php?cancel=true" class="btn btn-danger me-2 shadow">Cancel</a>
                    <button type="submit" class="btn btn-success shadow" name="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="../script/bootstrap.bundle.min.js"></script>
</body>
</html>
