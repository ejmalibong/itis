// Function to export all content
function exportAllContent() {
    // Redirect to the export.php directly to download all data
    window.location.href = 'php/export.php';
}

// Function to export filtered content
function exportFiltered(filter) {
    // Create a hidden form to send the filter data to the export script
    var form = document.createElement("form");
    form.method = "post";
    form.action = "php/export_filtered.php";

    // Create a hidden input field for the filter data
    var filterInput = document.createElement("input");
    filterInput.type = "hidden";
    filterInput.name = "filter";
    filterInput.value = filter;

    // Append the input field to the form
    form.appendChild(filterInput);

    // Submit the form
    document.body.appendChild(form);
    form.submit();
}
