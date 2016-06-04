$(document).ready(function(e) {
    setup();

})
function showMessage(type, messages){
    $("#message").remove();
    var str = '';
    $.each(messages, function (s, val) {
        str += val + "\n";
    })

    $('<div/>', {
        id: 'message',
        class: type,
        text: str,
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
                $("#userInfo").html("<p><a href='login.php'>Prijavi se</a></p>");
            } else {
                data = JSON.parse(data);
                $("#userInfo").html("<p>Dobrodošao " + data["username"] + "| <a id='logoutLink' href='#'>Odjavi se</a></p>");

                $("#logoutLink").on("click", function () {
                    $.ajax({
                        type: "GET",
                        url: "api/login.php",
                        data: {logout: 1},
                        success: function (data) {
                            location.reload();
                        }
                    });
                })
            }

        }
    });

}

function getParams(){
    var qd = {};
    location.search.substr(1).split("&").forEach(function(item) {
        var s = item.split("="),
            k = s[0],
            v = s[1] && decodeURIComponent(s[1]);
        (k in qd) ? qd[k].push(v) : qd[k] = [v]
    })
    return qd;
}

function clearContent(){
    $("#content").html("");
}

function index(event){
    $("#content").append("hi");

    event.preventDefault();
}
