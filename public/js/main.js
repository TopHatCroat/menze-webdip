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
                $("#user-info").html("<p><a href='login.php'>Prijavi se</a></p>");
            } else {
                data = JSON.parse(data);
                $("#user-info").html("<p>Dobrodošao " + data["username"] + "| <a id='logoutLink' href='#'>Odjavi se</a></p>");

                $("#logoutLink").on("click", function () {
                    $.ajax({
                        type: "GET",
                        url: "api/login.php",
                        data: {logout: 1},
                        success: function (data) {
                            location.reload();
                            showMessage(data);
                        }
                    });
                })
            }

        }
    });


    
    $.ajax({
        type: "GET",
        url: "api/time.php",
        data: { time: 1},
        success: function (data) {
            data = JSON.parse(data);
            var date = new Date(data['time'] * 1000);
            var hours = date.getHours();
            var minutes = "0" + date.getMinutes();
            var seconds = "0" + date.getSeconds();
            var time = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
            
            $("#timeDisplay").html("Vrijeme: " + time);
        }
    })

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


var setCities = function () {
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
}