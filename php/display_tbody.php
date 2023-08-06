<?php
    include "table_color.php";

    echo '<tr class="table-body table-scroll ' . htmlspecialchars($row_color) . '">
            <td>' . htmlspecialchars($row['id']) . '</td>
            <td>' . htmlspecialchars($row['item']) . '</td>
            <td>' . htmlspecialchars($row['brand']) . '</td>
            <td>' . htmlspecialchars($row['category']) . '</td>
            <td>' . htmlspecialchars($row['model_part_no']) . '</td>
            <td>' . htmlspecialchars($row['specifications']) . '</td>
            <td>' . htmlspecialchars($row['unit']) . '</td>
            <td>' . htmlspecialchars($row['max_stock']) . '</td>
            <td>' . htmlspecialchars($row['ordering_point']) . '</td>
            <td>' . htmlspecialchars($row['min_stock']) . '</td>
            <td>' . htmlspecialchars($row['unit_price']) . '</td>
            <td>' . htmlspecialchars($row['initial_stock']) . '</td>
            <td>' . htmlspecialchars($row['actual_stock']) . '</td>
            <td>' . htmlspecialchars($row['actual_amount']) . '</td>
            <td>' . htmlspecialchars($row['received']) . '</td>
            <td>' . htmlspecialchars($row['issued']) . '</td>
            <td>' . htmlspecialchars($row['for_purchase']) . '</td>
            <td>' . htmlspecialchars($row['location']) . '</td>
            <td>' . htmlspecialchars($row['supplier']) . '</td>
            <td>' . htmlspecialchars($row['remarks']) . '</td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="php/edit.php?id=' . htmlspecialchars($row['id']) . '"
                            class="dropdown-item">Edit</a></li>
                        <li><a href="php/add_stock.php?id=' . htmlspecialchars($row['id']) . '"
                            class="dropdown-item">Add Stock</a></li>
                        <li><a href="php/deduct_stock.php?id=' . htmlspecialchars($row['id']) . '"
                            class="dropdown-item">Deduct Stock</a></li>
                        <li><a href="php/delete.php?id=' . htmlspecialchars($row['id']) . '"
                            class="dropdown-item" onclick="return confirmDelete()">Delete</a></li>
                    </ul>
                </div>
            </td>
        </tr>';
?>