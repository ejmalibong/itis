<?php
    include "connection.php";
    include "add_remove_btn.php";

    if (isset($_POST['submit'])) {
        $item = $_POST['item'];
        $brand = $_POST['brand'];
        $category = isset($_POST['category']) ? $_POST['category'] : '';
        $model_part_no = $_POST['model_part_no'];
        $specifications = $_POST['specifications'];
        $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
        $max_stock = $_POST['max_stock'];
        $ordering_point = $_POST['ordering_point'];
        $min_stock = $_POST['min_stock'];
        $unit_price = $_POST['unit_price'];
        $initial_stock = $_POST['actual_stock'];
        $actual_stock = $_POST['actual_stock'];
        $location = isset($_POST['location']) ? $_POST['location'] : '';
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

        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO `itinventorysystem_table`(`id`, `item`, `brand`, `category`, `model_part_no`, `specifications`, `unit`, `max_stock`, `ordering_point`, `min_stock`, `unit_price`, `initial_stock`, `actual_stock`, `actual_amount`, `for_purchase`, `location`, `supplier`, `remarks`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssssiiidiidisss", $item, $brand, $category, $model_part_no, $specifications, $unit, $max_stock, $ordering_point, $min_stock, $unit_price, $initial_stock, $actual_stock, $actual_amount, $for_purchase, $location, $supplier, $remarks);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if($result) {
            header("Location: ../index.php?msg=<strong>Success! </strong> New item added");
            exit;
        }else {
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
    <title>New Item</title>

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
        <h2 class="mt-3 mb-4 text-center text-white"><strong>Add New Item</strong></h2>

        <!-- Forms/Table-->
        <div class="container d-flex justify-content-center">
            <form method="post" style="width:50vw; min-width:300px;">
                <div class="mb-1">
                    <label class="form-label text-white">Item<span class="required-field">*</span></label>
                    <input type="text" class="form-control shadow" name="item" required>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Brand</label>
                    <input type="text" class="form-control shadow" name="brand">
                </div>

                <div class="row mb-1">
                    <div class="col">
                        <div class="form-group mb-2">
                            <label class="form-label text-white">Category</label>
                            <select class="form-control shadow" name="category">
                                <option disabled selected>Choose a category</option>
                                <?php foreach ($categoryOptions as $categoryOption): ?>
                                    <option value="<?php echo $categoryOption; ?>" <?php if ($categoryOption == ($row['category'] ?? '')) echo 'selected'; ?>>
                                        <?php echo $categoryOption; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col mt-2 ml-5">
                        <label></label>
                        <div class="input-group">
                            <input type="text" class="form-control shadow" name="add_category" placeholder="Add new category option">
                            <button class="btn btn-danger shadow" id="remove_category_btn" type="button" name="remove_category">Remove</button>
                            <button class="btn btn-success shadow" id="add_category_btn" type="button" name="add_category">Add</button>
                        </div>
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Model/Part No.</label>
                    <input type="text" class="form-control shadow" name="model_part_no">
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Specifications</label>
                    <input type="text" class="form-control shadow" name="specifications">
                </div>
                
                <div class="row mb-1">
                    <div class="col">
                        <div class="form-group mb-2">
                            <label class="form-label text-white">Unit</label>
                            <select class="form-control shadow" name="unit">
                                <option disabled selected>Choose a unit</option>
                                <?php foreach ($unitOptions as $unitOption): ?>
                                    <option value="<?php echo $unitOption; ?>" <?php if ($unitOption == ($row['unit'] ?? '')) echo 'selected'; ?>>
                                        <?php echo $unitOption; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col mt-2 ml-5">
                        <label></label>
                        <div class="input-group">
                            <input type="text" class="form-control shadow" name="add_unit" placeholder="Add new unit option">
                            <button class="btn btn-danger shadow" id="remove_unit_btn" type="button" name="remove_unit">Remove</button>
                            <button class="btn btn-success shadow" id="add_unit_btn" type="button" name="add_unit">Add</button>
                        </div>
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Maximum Stock <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" id="max_stock" min="0" name="max_stock" required>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Ordering Point <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" name="ordering_point" required>
                </div> 

                <div class="mb-1">
                    <label class="form-label text-white">Minimum Stock <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" name="min_stock" required>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Unit Price (₱) <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" min="0" step="any" name="unit_price" required>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Actual Stock <span class="required-field">*</span></label>
                    <input type="number" class="form-control shadow" id="actual_stock" min="0" name="actual_stock" required>
                </div>

                <div class="row mb-1">
                    <div class="col">
                        <div class="form-group mb-2">
                            <label class="form-label text-white">Location</label>
                            <select class="form-control shadow" name="location">
                                <option disabled selected>Choose a location</option>
                                <?php foreach ($locationOptions as $locationOption): ?>
                                    <option  value="<?php echo $locationOption; ?>" <?php if ($locationOption == ($row['location'] ?? '')) echo 'selected'; ?>>
                                        <?php echo $locationOption; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col mt-2 ml-5">
                        <label></label>
                        <div class="input-group">
                            <input type="text" class="form-control shadow" name="add_location" placeholder="Add new location option">
                            <button class="btn btn-danger shadow" id="remove_location_btn" type="button" name="remove_location">Remove</button>
                            <button class="btn btn-success shadow" id="add_location_btn" type="button" name="add_location">Add</button>
                        </div>
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Supplier</label>
                    <input type="text" class="form-control shadow" name="supplier">
                </div>

                <div class="mb-1">
                    <label class="form-label text-white">Remarks</label>
                    <input type="text" class="form-control shadow" name="remarks">
                </div>

                <!-- Save and cancel button -->
                <div class="pb-5 pt-4" style="display: flex; justify-content: flex-end;">
                    <a href="../index.php?cancel=true" class="btn btn-danger me-2 shadow">Cancel</a>
                    <!-- Add an onclick event to the submit button to trigger form validation -->
                    <button type="submit" class="btn btn-success shadow" name="submit" onclick="return validateForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap -->
    <script src="../script/bootstrap.bundle.min.js"></script>
</body>
</html>