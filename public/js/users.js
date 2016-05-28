$('document').ready(function(){
    $.ajax({
        url: 'api/user.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='users'>"
            $.each(json, function(i, item){
                inHtml += "<p>" + "Korisničko ime: " + json[i].username + "<p>"
            })
            inHtml += "</div>"
            $("#content").html(inHtml);
        }
    });


})