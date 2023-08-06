<?php
    $sortQuery = isset($_GET['sort']) ? $_GET['sort'] : 'id';
    $orderQuery = isset($_GET['order']) ? $_GET['order'] : 'asc';
    $idOrder = $sortQuery === 'id' ? ($orderQuery === 'asc' ? 'desc' : 'asc') : 'asc';
    $itemOrder = $sortQuery === 'item' ? ($orderQuery === 'asc' ? 'desc' : 'asc') : 'asc';
    $forPurchaseOrder = $sortQuery === 'for_purchase' ? ($orderQuery === 'asc' ? 'desc' : 'asc') : 'asc';
    
    echo '
        <table class="table table-hover text-center table-sm table-bordered shadow-table" id="inventoryTable">
            <thead class="table-dark table-margin"> 
                <tr class="table-header">
                    <th scope="col"><a href="index.php?sort=id&order=' . $idOrder . '" id="idLink">Id</a></th>
                    <th scope="col"><a href="index.php?sort=item&order=' . $itemOrder . '" id="itemLink">Item</a></th>
                    <th scope="col">Brand</th>
                    <th scope="col">Category</th>
                    <th scope="col">Model/Part No.</th>
                    <th scope="col">Specifications</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Max Stock</th>
                    <th scope="col">Ordering Point</th>
                    <th scope="col">Min Stock</th>
                    <th scope="col">Unit Price (₱)</th>
                    <th scope="col">Initial Stock</th>
                    <th scope="col">Actual Stock</th>
                    <th scope="col">Actual Amount (₱)</th>
                    <th scope="col">Received</th>
                    <th scope="col">Issued</th>
                    <th scope="col"><a href="index.php?sort=for_purchase&order=' . $forPurchaseOrder . '" id="for_purchaseLink">For Purchase</a></th>
                    <th scope="col">Location</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Remarks</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';
?>