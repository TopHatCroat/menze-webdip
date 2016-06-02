$(document).ready(function() {
    // $.getJSON('api/city.php', function (data) {
    //     $("#city").autocomplete({
    //         source: data
    //     });
    // });

    $.ajax({
        url: "api/city.php",
        dataType: "json",
        success: function (data) {
            var selectOptions = '';
            $.each(data, function(key, value){
                selectOptions += '<option value="' + key + '">' + value + '<option/>'
            });
            $("#city").html(selectOptions);
        }
    })
})