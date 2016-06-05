var showAdminPanel = function () {
    $("#getTimeButton").on("click", function () {
        $.ajax({
            type: "GET",
            url: "https://barka.foi.hr/WebDiP/pomak_vremena/pomak.php",
            data: {format: 'xml'},
            success: function (data) {
                var pomak = $(data).find("pomak");
                var pomak = parseInt(pomak.text());
                if(pomak == NaN){
                    $("#timeInput").val(0);
                } else {
                    $("#timeInput").val(pomak);
                }

            }
        })
    })

    $("#setTimeButton").on("click", function () {
        $.ajax({
            type: "GET",
            url: "api/admin.php",
            data: {time: $("#timeInput").val, session: getCookie("PHPSESSID")},
            success: function (data) {
                location.reload();
            }
        })
    })
};

$(document).ready(function (e) {
    $.ajax({
        type: "GET",
        url: "api/admin.php",
        data: { session: getCookie("PHPSESSID")},
        success: function(data)
        {
            if(data == ""){
                $("#content").html("<p>Neautorizirani pristup</p>");
            } else {
                data = JSON.parse(data);
                if(data["admin"]["role"] == '3'){
                    showAdminPanel();
                } else{
                    $("#content").html("<p>Neautorizirani pristup</p>");
                }
            }

        }
    });

    e.preventDefault();

})
