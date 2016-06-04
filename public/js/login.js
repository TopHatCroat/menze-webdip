$(document).ready(function(){
    var params = getParams();
    if(params["activation"][0] != undefined){
        $.ajax({
            type: "GET",
            url: "api/login.php",
            data: {activation : params["activation"][0]},
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
    }

    $("#login").submit(function(e) {
        $.ajax({
            type: "POST",
            url: "api/login.php",
            data: $("#login").serialize(),
            success: function(data)
            {
                var parsed = JSON.parse(data);
                if(parsed['success'] == undefined){
                    showMessage("error", parsed);
                } else {
                    location.reload();
                }
            }
        });

        e.preventDefault();
    });
})