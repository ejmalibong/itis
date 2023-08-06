// Toast Notification
window.addEventListener('DOMContentLoaded', function() {
    var toastEl = document.getElementById('myToast');
    var toast = new bootstrap.Toast(toastEl);
    if(toastEl) {
      toast.show();
    }
});

// Will close the first open buttoned when the second button is toggled
$(document).ready(function() {
    $(".btn").click(function() {
      // Check if the clicked button is in the same collapse group
      if($(this).data("target") !== $(".collapse.show").attr("id")) {
        // Hide any open card-body
        $(".collapse.show").collapse("hide");
      }
    });
});

// For fixed height of both card-body
$(document).ready(function() {
    $('.collapse').on('show.bs.collapse', function() {
      $('.card-body-fixed-height').removeClass('card-body-fixed-height');
      $(this).find('.card-body').addClass('card-body-fixed-height');
    });
  
    $('.collapse').on('hide.bs.collapse', function() {
      $(this).find('.card-body').removeClass('card-body-fixed-height');
    });
});