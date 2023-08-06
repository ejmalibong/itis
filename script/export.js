$(document).ready(function() {
    // Function to download the CSV file
    function downloadCSV(content, filename) {
        var blob = new Blob([content], { type: 'text/csv' });
        var url = URL.createObjectURL(blob);

        var a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    // Function to export all content
    $(".export-all").click(function(e) {
        e.preventDefault();
        var csvContent = ''; // Variable to store the CSV content

        function exportData(page) {
            $.ajax({
                url: '../php/export.php',
                type: 'GET',
                data: { page: page },
                success: function(data) {
                    csvContent += data; // Append the data to the CSV content

                    // Check if there is more data to export
                    if(data.trim().length > 0) {
                        // Export the next page
                        exportData(page + 1);
                    }else {
                        // When all data is retrieved, trigger the CSV download
                        downloadCSV(csvContent, 'all_content_inventory_data.csv');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        exportData(1); // Start exporting from the first page
    });

    // Function to export filtered content
    $(".export-filtered").click(function(e) {
        e.preventDefault();
        var filter = $(this).data("filter");
        // Call the appropriate exportFiltered function passing the filter as an argument
        exportFiltered(filter);
    });
});
