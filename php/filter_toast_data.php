<?php
    include "connection.php";

    if(isset($_POST['filter'])) {
        $filter = $_POST['filter'];
        $filteredData = array();

        // Filter the data based on the selected filter
        if($filter === "ordering-point") {
            $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table WHERE actual_stock > min_stock AND actual_stock <= ordering_point ORDER BY id ASC");
        }elseif($filter === "minimum-stock") {
            $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table WHERE actual_stock <= min_stock ORDER BY id ASC");
        }else {
            // Invalid filter parameter or no filter selected
            echo "Invalid filter selected.";
            exit();
        }

        // Execute the prepared statement and handle errors
        if(!$stmt->execute()) {
            echo "Error executing query: " . $stmt->error;
            exit();
        }

        $filteredData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        echo '
            <table class="table table-hover text-center table-sm" style="margin-top: 0;">
                <thead>
                    <tr style="vertical-align: middle;">
                        <th scope="col">Id</th>
                        <th scope="col">Item</th>
                        <th scope="col">Initial Stock</th>
                        <th scope="col">Actual Stock</th>
                        <th scope="col">For Purchase</th>
                    </tr>
                </thead>
                <tbody>        
        ';

        foreach($filteredData as $row) {
            echo '
                    <tr> 
                        <td>' . htmlspecialchars($row['id']) . '</td>
                        <td>' . htmlspecialchars($row['item']) . '</td>
                        <td>' . htmlspecialchars($row['initial_stock']) . '</td>
                        <td>' . htmlspecialchars($row['actual_stock']) . '</td>
                        <td>' . htmlspecialchars($row['for_purchase']) . '</td>
                    </tr>    
            ';
        }

        echo '  
                </tbody>
            </table>
        ';

    }
?>
