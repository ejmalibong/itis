<?php include "php/filter_toast_data.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/nbc_bg.jpg" type="image/x-icon" />
    <title>IT Inventory System</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="style\bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="style/style.scss"/>
    <link rel="stylesheet" href="style/custom-toast.css"/>

    <!-- Include jQuery and jQuery UI libraries -->
    <script src="script/jquery-3.6.0.min.js"></script>
    <script src="script/code.jquery.com_ui_1.13.1_jquery-ui.min.js"></script>
    <link rel="stylesheet" href="style/code.jquery.com_ui_1.13.1_themes_smoothness_jquery-ui.css">
</head>

<body style="background-color: #3275b9;">
    <nav class="navbar bg-body-tertiary sticky-top" style="background-color: #f7f7f7;">
        <div class="container-fluid">
            <div>
                <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="cursor: pointer;"><img src="images/bars-solid.svg" alt="Menu" width="25" height="25"></a>
                <a class="navbar-brand m-2" onclick="window.location.href='index.php'" style="vertical-align: middle;"><img src="images/nbc_bg.jpg" alt="NBC Logo" height="45"></a>
                <a class="navbar-brand m-1 h2" style="vertical-align: middle; color: #3275b9; cursor: default;"><strong>IT Inventory System</strong></a>
            </div>

            <?php
                // Success message will appear if new values are successfully added to the database
                if(isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                        echo '<div class="alert alert-success alert-dismissible fade show alert-pos" role="alert" id="alertTest">
                                '.$msg.'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                }
            ?>

            <div>
                <form id="searchForm" method="GET" class="d-flex">
                    <input class="form-control me-2 shadow" type="text" id="searchInput" placeholder="Search: Item - Brand - Model/Part No.">
                    <input type="hidden" id="searchKey" name="searchKey">
                    <button id="searchButton" class="btn btn-secondary shadow" type="submit">Search</button>

                    <?php
                        // Counters
                        $totalCount = 0;
                        $orderPointCount = 0;
                        $minStockCount = 0;
                        $goodCount = 0;                        

                        // Switch button to exit if the user is on search_results.php
                        if(isset($_GET['searchKey'])) {
                            echo '<a href="index.php?cancel=true" class="btn btn-danger ms-3 shadow">Exit</a>';
                        }else {
                            echo '<a href="php/add_new.php" class="btn btn-success ms-3 shadow">Add New</a>';
                            
                            include "php/connection.php";

                            $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Loop through and count
                            while($row = $result->fetch_assoc()) {
                                $totalCount++; // Increment total count for each row

                                // Check conditions for ordering point and minimum stock
                                if($row['actual_stock'] > $row['min_stock'] && $row['actual_stock'] <= $row['ordering_point']) {
                                    $orderPointCount++;
                                }
                            
                                if($row['actual_stock'] <= $row['min_stock']) {
                                    $minStockCount++;
                                }
                            }

                            $goodCount = $totalCount - ($orderPointCount + $minStockCount);
                        }
                    ?>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid hero">
        <?php
            // Display search results when the user initiated search
            if(isset($_GET['searchKey'])) {
                include "php/search_results.php";
            }else {
                // Default - display main table
                include "php/connection.php";

                // Retrieve the sort parameters from the query string
                $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
                $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

                // Modify the SQL query to include the ORDER BY clause based on the sort parameters
                $stmt = $conn->prepare("SELECT * FROM itinventorysystem_table ORDER BY $sort $order");
                $stmt->execute();
                $result = $stmt->get_result();

                include "php/display_thead.php";

                // Loop through and display the tbody
                while($row = $result->fetch_assoc()) {
                    include "php/display_tbody.php";
                }
                
                echo '</tbody></table>';
            }
        ?>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #f7f7f7;" data-bs-animation="true">
        <div class="offcanvas-header" style="background-color: #3275b9; height: 80px; display: flex; color: #f7f7f7;">
            <img src="images/nbc logo.png" alt="NBC Logo" height="45">
            <button type="button" class="btn text-reset custom-button" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fas fa-xmark fa-lg" style="color: #f7f7f7;"></i>
            </button>
        </div>

        <div class="offcanvas-body container">
            <div class="pt-2 p-2 card shadow-table">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Number of items</h6>
                    </div>
                    <div>
                        <span class="badge rounded-pill text-bg-primary" id="displayCount"><?php echo $totalCount; ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <span class="nameCount">Good</span>
                    </div>
                    <div>
                        <span class="badge rounded-pill text-bg-success" id="displayCount"><?php echo $goodCount; ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <span class="nameCount">Ordering Point</span>
                    </div>
                    <div>
                        <span class="badge rounded-pill text-bg-warning" id="displayCount"><?php echo $orderPointCount; ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <span class="nameCount">Minimum Stock</span>
                    </div>
                    <div>
                        <span class="badge rounded-pill text-bg-danger" id="displayCount"><?php echo $minStockCount; ?></span>
                    </div>
                </div>
            </div>

            <div class="pt-4" style="display: flex; justify-content: end;">
                <button onclick="window.location.href='php/history.php'" type="button" class="btn btn-dark shadow">History</button>
            </div>

            <div class="pt-2">
                <h6>Filter by</h6>
                <div class="p-3" id="button-style">
                    <button type="button" class="btn btn-warning filter-button shadow" data-filter="ordering-point">Ordering Point</button>
                    <button type="button" class="btn btn-danger filter-button shadow" data-filter="minimum-stock">Minimum Stock</button>
                </div>
            </div>

            <div class="pt-3">
                <h6>Bulk</h6>
                <div class="p-3" id="button-style">
                    <button type="button" class="btn btn-primary pl-2 shadow" onclick="window.location.href='php/bulk_deduct.php'">Deduct Stock</button>
                    <button type="button" class="btn btn-primary shadow" onclick="window.location.href='php/bulk_add.php'">Add Stock</button>
                </div>
            </div>

            <div class="pt-3">
                <h6>Sort by</h6>
                <div class="p-3" id="dropdown-style">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort Options
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?sort=id&order=desc">Newest</a></li>
                            <li><a class="dropdown-item" href="index.php?sort=id&order=asc">Oldest</a></li>
                            <li><a class="dropdown-item" href="index.php?sort=item">Alphabetical</a></li>
                            <li><a class="dropdown-item" href="index.php?sort=for_purchase&order=desc">Largest For Purchase</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <h6>Export to CSV</h6>
                <div class="p-3" id="dropdown-style">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Content Options
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item" onclick="exportAllContent()">All Content</a></li>
                            <li><a href="#" class="dropdown-item export-filtered" data-filter="ordering-point" onclick="exportFiltered('ordering-point')">Ordering Point</a></li>
                            <li><a href="#" class="dropdown-item export-filtered" data-filter="minimum-stock" onclick="exportFiltered('minimum-stock')">Minimum Stock</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container p-3 bottom-0 end-0" style="z-index: 11">
        <?php
            // Check if the current page is the index page, a search has not been performed, a new item has not been added,
            // and the sort parameter is not present in the query string
            $isIndexPage = basename($_SERVER['PHP_SELF']) == 'index.php';
            $searchPerformed = isset($_GET['searchKey']);
            $newItemAdded = isset($_GET['msg']);
            $sortParameter = isset($_GET['sort']);
            $cancelClicked = isset($_GET['cancel']);

            if ($isIndexPage && !$searchPerformed && !$newItemAdded && !$sortParameter && !$cancelClicked) {
        ?>
            <div id="myToast" class="toast shadow" role="alert" aria-live="polite" data-bs-delay="5000">
                <div class="toast-header">
                    <strong class="me-auto" style="color: #f7f7f7;">Notification</strong>
                </div>

                <div class="toast-body">
                    <div class="row p-1">
                        <button class="btn btn-warning filter-toast-button shadow" type="button" data-filter="ordering-point" data-bs-toggle="collapse" data-bs-target="#collapseOP" aria-expanded="false" aria-controls="collapseOP">
                            <span class="name">Ordering Point</span>
                            <span class="badge text-dark" id="badgePos"><?php echo $orderPointCount; ?></span>
                            <span class="dropdown-toggle"></span>
                        </button>
                    </div>

                    <div class="collapse" id="collapseOP">
                        <div class="card card-body card-body-fixed-height shadow"></div>
                    </div>

                    <div class="row p-1">
                        <button class="btn btn-danger filter-toast-button shadow" type="button" data-filter="minimum-stock" data-bs-toggle="collapse" data-bs-target="#collapseMS" aria-expanded="false" aria-controls="collapseMS">
                            <span class="name">Minimum Stock</span>
                            <span class="badge" id="badgePos"><?php echo $minStockCount; ?></span>
                            <span class="dropdown-toggle"></span>
                        </button>
                    </div>
                    
                    <div class="collapse" id="collapseMS">
                        <div class="card card-body card-body-fixed-height shadow"></div>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
    </div>

    <!-- Bootstrap -->
    <script src="script/bootstrap.bundle.min.js"></script>
        
    <script src="script/search.js"></script>
    <script src="script/filter.js"></script>
    <script src="script/show_toast.js"></script>
    <script src="script/filter_toast.js"></script>
    <script src="script/export.js"></script>
    <script src="script/alertTimeout.js"></script>
    <script src="script/export_option.js"></script>

    <script>
        // Will pop up to confirm the deletion of an item
        function confirmDelete() {
            return confirm("Are you sure you want to delete this item?");
        }

        // Remove hyperlink on id and item for purchase header
        var idLink = document.getElementById('idLink');
        if(idLink) {
            idLink.removeAttribute('href');
        }
        var itemLink = document.getElementById('itemLink');
        if(itemLink) {
            itemLink.removeAttribute('href');
        }
        var for_purchaseLink = document.getElementById('for_purchaseLink');
        if(for_purchaseLink) {
            for_purchaseLink.removeAttribute('href');
        }        
    </script>

</body>
</html>
