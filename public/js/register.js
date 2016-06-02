$(document).ready(function(){
    $.ajax({
        url: "api/city.php",
        dataType: "json",
        success: function (data) {
            var selectOptions = '';
            $.each(data, function(key, value){
                selectOptions += '<option value="' + key + '">' + value + '</option>'
            });
            $("#city").html(selectOptions);
        }
    })
})
