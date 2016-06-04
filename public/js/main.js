$(document).ready(function(e) {
    setup();

})
function showMessage(type, messages){
    $('<div/>', {
        id: 'message',
        class: type,
        text: messages,
    }).prependTo('#content');
    $("#message").animate({
        opacity: 1,
    });
}

function setup() {
    $.ajax({
        type: "GET",
        url: "api/login.php",
        data: { user: 1},
        success: function(data)
        {
            if(data == ""){
                $("#userInfo").html("<a href='login.php'>Prijavi se</a>");
            } else {
                data = JSON.parse(data);
                $("#userInfo").html("<p>Dobrodošao " + data["username"] + "| <a id='logoutLink' href='#'>Odjavi se</a></p>");

                $("#logoutLink").on("click", function () {
                    $.ajax({
                        type: "GET",
                        url: "api/login.php",
                        data: {logout: 1},
                        success: function (data) {

                        }
                    });
                })
            }

        }
    });
}

function clearContent(){
    $("#content").html("");
}

function index(event){
    $("#content").append("hi");

    event.preventDefault();
}
