$(document).ready(function(){
    $("#login").submit(function(e) {
        $.ajax({
            type: "POST",
            url: "api/login.php",
            data: $("#login").serialize(),
            success: function(data)
            {
                showMessage("error", data);
            }
        });

        e.preventDefault();
    });
})