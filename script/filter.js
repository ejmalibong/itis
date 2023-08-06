$(document).ready(function() {
  $(".filter-button").click(function() {
      var filter = $(this).data("filter");

      // Show all rows initially
      $(".table-body").show();

      // Filter rows based on the selected filter
      if(filter === "ordering-point") {
          $(".table-body").not(".table-warning").hide();
      }else if(filter === "minimum-stock") {
          $(".table-body").not(".table-danger").hide();
      }
  });
});
