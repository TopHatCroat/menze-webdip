$(document).ready(function(e) {


})



function setup(e){
    $("#usersLink").on("click", function() {users(e)});
    $("#indexLink").on("click", function() {users(e)});
    $("#registerLink").on("click", function() {users(e)});
}

function clearContent(){
    $("#content").html("");
}

function index(event){
    $("#content").append("hi");

    event.preventDefault();
}

function users(event){
    clearContent();
    setup(e);
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

}
