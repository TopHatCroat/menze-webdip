$(document).ready(function(){   
    setCities();

    $("#register").submit(function(e) {
        $.ajax({
            type: "POST",
            url: "api/register.php",
            data: $("#register").serialize(),
            success: function(data)
            {
                showMessage("error", data);
            }
        });

        e.preventDefault();
    });
})
