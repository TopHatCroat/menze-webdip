function loadUser(userId) {
    $.ajax({
        url: 'api/user.php',
        type: 'GET',
        data: {id: userId},
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='user'>"
            if(json["admin"] != undefined){
                if(json["admin"] == "3") inhtml += setEditUserView(json["user"]);
                else inHtml += setAdminEditUserView(json["user"]);
            } else {
                inHtml += setUserView(json["user"]);
            }

            inHtml += "</div>"
            $("#content").html(inHtml);
        }
    });
}

var loadUsers = function(){
    $.ajax({
        url: 'api/user.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='users'>"
            $.each(json, function(i, item){
                inHtml += setCardUserView(json[i])
            })
            inHtml += "</div>"
            $("#content").html(inHtml);
        }
    });
}

var setCardUserView = function(item) {
    var inHtml = '';
    inHtml += "<a class='' href='users.php?id=" + item.id  + "'> <div class='card card-shadowed'>";
    if(item.image == "") inHtml += "<img src='" + "public/img/profile/defaultUser.jpg" + "'>" + "</img>";
    else inHtml += "<img src='" + item.image.substring(3) + "'>" + "</img>";
    inHtml += "<p class='card-title'>" + item.username + "</p>";
    inHtml += "<p class='card-body'>" + item.email + "</p>";
    inHtml += "<p class='card-body'>" + item.address + ", " + item.city + "</p>";
    inHtml += "</div></a>";
    return inHtml;
}

var setEditUserView = function (user) {
    var inHtml = '';
    inHtml += "<form id='editUser' method='post' name='editUser' action='api/user.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='username'>Korisničko ime: </label></td><td><label id='username' name='username' value='" + user.username + "''></td></tr>";
    inHtml += "<tr><td><label for='pass'>Lozinka:</label></td><td><input type='password' id='pass' name='pass' placeholder='lozinka'></td></tr>";
    inHtml += "<tr><td><label for='pass-confirm'>Provjera lozinke:</label></td><td><input type='password' id='pass-confirm' name='pass-confirm' placeholder='lozinka'></td></tr>";
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label id='email' value='" + user.email + "'></td></tr>";
    inHtml += "<tr><td><label for='name'>Ime:</label></td><td><input type='text' id='name' name='name' value='" + user.name + "'></td></tr>"
    inHtml += "<tr><td><label for='surname'>Prezime:</label></td><td><input type='text' id='surname' name='surname' value='" + user.surname + "'></td></tr>"
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><select id='city' name='city'></select>" + user.city + "</td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><input type='text' id='address' name='address' value='" + user.address + "'></td></tr>"
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form>";
    return inHtml;

};

var setAdminEditUserView = function (user) {
    var inHtml = '';

};

var setUserView = function (user) {
    var inHtml = '';

};

$('document').ready(function(e){
    clearContent();
    loadUsers();

    var params = getParams();

    if(params["id"] != undefined){
        loadUser(params["id"][0]);
    } else {
        loadUsers();
    }
})