<?php
    include "connection.php";

    // Check if a search term is provided in the URL
    if(isset($_GET['searchKey'])) {
        $searchTerm = $_GET['searchKey'];
        $searchTerm = "%$searchTerm%";

        // Prepare the SQL query to fetch the search results
        $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table WHERE item LIKE ? OR brand LIKE ? OR model_part_no LIKE ?");
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results are found
        if($result->num_rows === 0) {
            echo '<div class="alert alert-danger mt-4"><strong>Item not found! </strong> Try again.</div>';
        }else {
            include "display_thead.php";

            // Loop through and display the search results
            while($row = $result->fetch_assoc()) {
                include "display_tbody.php";
            }

            echo '</tbody>';
            echo '</table>';
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
?>
