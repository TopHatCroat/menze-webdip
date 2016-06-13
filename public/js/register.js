$(document).ready(function(){   
    setCities("#city", null);

    $("#register").submit(function(e) {
        $.ajax({
            type: "POST",
            url: "api/register.php",
            data: $("#register").serialize(),
            success: function(data)
            {
                var parsed = JSON.parse(data);
                if(parsed['success'] == undefined){
                    showMessage("error", parsed);
                } else {
                    showMessage("success", parsed);
                }
            }
        });

        e.preventDefault();
    });
})
