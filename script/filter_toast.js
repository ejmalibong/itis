$(document).ready(function() {
    $(".filter-toast-button").click(function() {
        var filter = $(this).data("filter");

        // Show all rows initially
        $(".table-body").show();

        // Send AJAX request to fetch filtered data
        $.ajax({
            url: "php/filter_toast_data.php", // Replace with the correct PHP file path
            method: "POST",
            data: { filter: filter },
            success: function(response) {
                // Display the filtered data in the respective card-body
                $(".card-body").empty().append(response);
            }
        });
    });
});
