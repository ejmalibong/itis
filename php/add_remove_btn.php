<?php
    // Fetch category options from the database
    $categoryOptions = [];
    $categoryQuery = "SELECT category_select FROM category_dd";
    $categoryResult = mysqli_query($conn, $categoryQuery);

    while($row = mysqli_fetch_assoc($categoryResult)) {
        $categoryOptions[] = $row['category_select'];
    }

    // Fetch unit options from the database
    $unitOptions = [];
    $unitQuery = "SELECT unit_select FROM unit_dd";
    $unitResult = mysqli_query($conn, $unitQuery);

    while($row = mysqli_fetch_assoc($unitResult)) {
        $unitOptions[] = $row['unit_select'];
    }

    // Fetch location options from the database
    $locationOptions = [];
    $locationQuery = "SELECT location_select FROM location_dd";
    $locationResult = mysqli_query($conn, $locationQuery);

    while($row = mysqli_fetch_assoc($locationResult)) {
        $locationOptions[] = $row['location_select'];
    }

    if(isset($_POST['add_category'])) {
        $newCategory = $_POST['add_category'];

        if(!empty($newCategory)) {
            // Remove any existing blank row from the category_dd table
            $deleteQuery = "DELETE FROM category_dd WHERE category_select = ''";
            mysqli_query($conn, $deleteQuery);

            // Insert the new category option into the category_dd table at the lowest available position
            $insertQuery = "INSERT INTO category_dd (category_select) SELECT * FROM (SELECT '$newCategory') AS tmp WHERE NOT EXISTS (SELECT * FROM category_dd WHERE category_select = '$newCategory') LIMIT 1";
            $insertResult = mysqli_query($conn, $insertQuery);

            if($insertResult) {
                // Update the category options array
                $categoryOptions[] = $newCategory;
                echo "New category option added successfully!";
            }else {
                echo "Failed to add the new category option.";
            }
        }
    }

    // Adding options
    if(isset($_POST['add_unit'])) {
        $newUnit = $_POST['add_unit'];

        if(!empty($newUnit)) {
            // Remove any existing blank row from the unit_dd table
            $deleteQuery = "DELETE FROM unit_dd WHERE unit_select = ''";
            mysqli_query($conn, $deleteQuery);

            // Insert the new unit option into the unit_dd table at the lowest available position
            $insertQuery = "INSERT INTO unit_dd (unit_select) SELECT * FROM (SELECT '$newUnit') AS tmp WHERE NOT EXISTS (SELECT * FROM unit_dd WHERE unit_select = '$newUnit') LIMIT 1";
            $insertResult = mysqli_query($conn, $insertQuery);

            if($insertResult) {
                // Update the unit options array
                $unitOptions[] = $newUnit;
                echo "New unit option added successfully!";
            }else {
                echo "Failed to add the new unit option.";
            }
        }
    }

    if(isset($_POST['add_location'])) {
        $newLocation = $_POST['add_location'];

        if(!empty($newLocation)) {
            // Remove any existing blank row from the location_dd table
            $deleteQuery = "DELETE FROM location_dd WHERE location_select = ''";
            mysqli_query($conn, $deleteQuery);

            // Insert the new location option into the location_dd table at the lowest available position
            $insertQuery = "INSERT INTO location_dd (location_select) SELECT * FROM (SELECT '$newLocation') AS tmp WHERE NOT EXISTS (SELECT * FROM location_dd WHERE location_select = '$newLocation') LIMIT 1";
            $insertResult = mysqli_query($conn, $insertQuery);

            if($insertResult) {
                // Update the location options array
                $locationOptions[] = $newLocation;
                echo "New location option added successfully!";
            }else {
                echo "Failed to add the new location option.";
            }
        }
    }

    // Removing option
if (isset($_POST['remove_category'])) {
    $selectedCategory = $_POST['remove_category'];

    // AJAX request to remove the selected category option from the database
    $deleteQuery = "DELETE FROM category_dd WHERE category_select = '$selectedCategory'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if($deleteResult) {
        // Remove the option from the category options array
        $categoryKey = array_search($selectedCategory, $categoryOptions);

        if($categoryKey !== false) {
            unset($categoryOptions[$categoryKey]);
        }

        echo "Category option removed successfully!";
    }else {
        echo "Failed to remove the category option.";
    }
}

if (isset($_POST['remove_unit'])) {
    $selectedUnit = $_POST['remove_unit'];

    // AJAX request to remove the selected unit option from the database
    $deleteQuery = "DELETE FROM unit_dd WHERE unit_select = '$selectedUnit'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if($deleteResult) {
        // Remove the option from the unit options array
        $unitKey = array_search($selectedUnit, $unitOptions);

        if ($unitKey !== false) {
            unset($unitOptions[$unitKey]);
        }

        echo "Unit option removed successfully!";
    }else {
        echo "Failed to remove the unit option.";
    }
}

if (isset($_POST['remove_location'])) {
    $selectedLocation = $_POST['remove_location'];

    // AJAX request to remove the selected location option from the database
    $deleteQuery = "DELETE FROM location_dd WHERE location_select = '$selectedLocation'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if($deleteResult) {
        // Remove the option from the location options array
        $locationKey = array_search($selectedLocation, $locationOptions);

        if ($locationKey !== false) {
            unset($locationOptions[$locationKey]);
        }

        echo "Location option removed successfully!";
    }else {
        echo "Failed to remove the location option.";
    }
}


    if(isset($_POST['selected_category'])) {
        $selectedCategory = $_POST['selected_category'];

        // AJAX request to remove the selected category option from the database
        $deleteQuery = "DELETE FROM category_dd WHERE category_select = '$selectedCategory'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if($deleteResult) {
            // Remove the option from the category options array
            $categoryKey = array_search($selectedCategory, $categoryOptions);

            if($categoryKey !== false) {
                unset($categoryOptions[$categoryKey]);
            }

            echo "Category option removed successfully!";
        }else {
            echo "Failed to remove the category option.";
        }
    }

    if(isset($_POST['selected_unit'])) {
        $selectedUnit = $_POST['selected_unit'];

        // AJAX request to remove the selected unit option from the database
        $deleteQuery = "DELETE FROM unit_dd WHERE unit_select = '$selectedUnit'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if($deleteResult) {
            // Remove the option from the unit options array
            $unitKey = array_search($selectedUnit, $unitOptions);

            if ($unitKey !== false) {
                unset($unitOptions[$unitKey]);
            }

            echo "Unit option removed successfully!";
        }else {
            echo "Failed to remove the unit option.";
        }
    }

    if(isset($_POST['selected_location'])) {
        $selectedLocation = $_POST['selected_location'];

        // AJAX request to remove the selected location option from the database
        $deleteQuery = "DELETE FROM location_dd WHERE location_select = '$selectedLocation'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if($deleteResult) {
            // Remove the option from the location options array
            $locationKey = array_search($selectedLocation, $locationOptions);

            if ($locationKey !== false) {
                unset($locationOptions[$locationKey]);
            }

            echo "Location option removed successfully!";
        }else {
            echo "Failed to remove the location option.";
        }
    }
?>
