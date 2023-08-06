<?php
    # Inside this php script are the conditions that will put a background color
    # on each row of the table depending on their met conditions
    # condition 1: actual stock > minimum stock and actual stock <= ordering point = bg color: yellow
    # condition 2: actual stock <= minimum stock = bg color: red
    
    $actual_stock = $row['actual_stock'];
    $min_stock = $row['min_stock'];
    $ordering_point = $row['ordering_point'];

    // If actual stock is at ordering point or lower than ordering point
    if($actual_stock > $min_stock && $actual_stock <= $ordering_point) {
        $row_color = 'table-warning';
    }elseif($actual_stock <= $min_stock) {
        $row_color = 'table-danger';
    }else {
        $row_color = 'table-light';
    }
?>
