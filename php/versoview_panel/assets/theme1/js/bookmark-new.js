$(document).ready(function() {
    $('#myTab a').on('click', function(e) {
        e.preventDefault()
        $(this).show()
        lg(e)
    })