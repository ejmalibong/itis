// Adding Option
$(document).ready(function() {
  $('#add_category_btn').click(function() {
      var newCategory = $('input[name="add_category"]').val();
      if(newCategory) {
          // AJAX request to add the new category option to the database
          $.post('../php/add_new.php', { add_category: newCategory, add: true }, function(response) {
          });

          $('select[name="category"]').append('<option>' + newCategory + '</option>');
          $('input[name="add_category"]').val('');
      }
  });
});

$(document).ready(function() {
  $('#add_unit_btn').click(function() {
      var newUnit = $('input[name="add_unit"]').val();
      if(newUnit) {
          // AJAX request to add the new unit option to the database
          $.post('../php/add_new.php', { add_unit: newUnit, add: true }, function(response) {
          });

          $('select[name="unit"]').append('<option>' + newUnit + '</option>');
          $('input[name="add_unit"]').val('');
      }
  });
});

$(document).ready(function() {
  $('#add_location_btn').click(function() {
      var newLocation = $('input[name="add_location"]').val();
      if(newLocation) {
          // AJAX request to add the new location option to the database
          $.post('../php/add_new.php', { add_location: newLocation, add: true }, function(response) {
          });

          $('select[name="location"]').append('<option>' + newLocation + '</option>');
          $('input[name="add_location"]').val('');
      }
  });
});

// Removing Option
$(document).ready(function() {
  $('#remove_category_btn').click(function() {
    var selectedCategory = $('select[name="category"]').val();
    if(selectedCategory) {
      // AJAX request to remove the selected category option from the database
      $.post('../php/add_new.php', { remove_category: selectedCategory }, function(response) {
      });

      // Remove the option from the select tag
      $('select[name="category"] option[value="' + selectedCategory + '"]').remove();
    }
  });
});

$(document).ready(function() {
  $('#remove_unit_btn').click(function() {
    var selectedUnit = $('select[name="unit"]').val();
    if(selectedUnit) {
      // AJAX request to remove the selected unit option from the database
      $.post('../php/add_new.php', { remove_unit: selectedUnit }, function(response) {
      });

      // Remove the option from the select tag
      $('select[name="unit"] option[value="' + selectedUnit + '"]').remove();
    }
  });
});

$(document).ready(function() {
  $('#remove_location_btn').click(function() {
    var selectedLocation = $('select[name="location"]').val();
    if(selectedLocation) {
      // AJAX request to remove the selected location option from the database
      $.post('../php/add_new.php', { remove_location: selectedLocation }, function(response) {
      });

      // Remove the option from the select tag
      $('select[name="location"] option[value="' + selectedLocation + '"]').remove();
    }
  });
});
