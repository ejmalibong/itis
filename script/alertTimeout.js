// Hide the success message alert after 2 seconds
setTimeout(function() {
    var alertTest = document.getElementById('alertTest');
    if(alertTest) {
        alertTest.style.display = 'none';
    }
}, 2000);