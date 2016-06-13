function loadUser(userId) {
    $.ajax({
        url: 'api/user.php',
        type: 'GET',
        data: {id: userId},
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='user card card-detail'>"
            if(json["admin"] != undefined){
                if(json["admin"].role != "3") setEditUserView(json["user"]);
                else setAdminEditUserView(json["user"]);
            } else {
                inHtml += setUserView(json["user"]);
            }
            inHtml += loadReservations(json["reservations"]);
            inHtml += "</div>"
            $("#content").append(inHtml);
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
    inHtml += "<a class='' href='users.php?id=" + item.id  + "'><div class='card card-shadowed'>";
    if(item.image == "") inHtml += "<img src='" + "public/img/profile/defaultUser.jpg" + "'>" + "</img>";
    else inHtml += "<img src='" + item.image.substring(3) + "'/>";
    inHtml += "<p class='card-title'>" + item.username + "</p>";
    inHtml += "<p class='card-body'>" + item.email + "</p>";
    inHtml += "<p class='card-body'>" + item.address + ", " + item.city + "</p>";
    inHtml += "</div></a>";
    return inHtml;
}

var setEditUserView = function (user) {
    var inHtml = '';
    inHtml += "<form id='editUser' method='post' name='editUser' action='api/user.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='username'>Korisničko ime: </label></td><td><label>" + user.username + "</label></td></tr>";
    inHtml += "<tr><td><label for='pass'>Lozinka:</label></td><td><input type='password' id='pass' name='pass' placeholder='lozinka'></td></tr>";
    inHtml += "<tr><td><label for='pass-confirm'>Provjera lozinke:</label></td><td><input type='password' id='pass-confirm' name='pass-confirm' placeholder='lozinka'></td></tr>";
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label>" + user.email + "</label></td></tr>";
    inHtml += "<tr><td><label for='name'>Ime:</label></td><td><input type='text' id='name' name='name' value='" + user.name + "'></td></tr>"
    inHtml += "<tr><td><label for='surname'>Prezime:</label></td><td><input type='text' id='surname' name='surname' value='" + user.surname + "'></td></tr>"
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><select id='city' name='city'></select>" + "</td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><input type='text' id='address' name='address' value='" + user.address + "'></td></tr>"
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form>";
    $("#content").prepend(inHtml);

    setCities("#city", user.city);

};

var setAdminEditUserView = function (user) {
    var inHtml = '';
    inHtml += "<form id='editUser' method='post' name='editUser' action='api/user.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='username'>Korisničko ime: </label></td><td><label>" + user.username + "</label></td></tr>";
    inHtml += "<tr><td><label for='pass'>Lozinka:</label></td><td><input type='password' id='pass' name='pass' placeholder='lozinka'></td></tr>";
    inHtml += "<tr><td><label for='pass-confirm'>Provjera lozinke:</label></td><td><input type='password' id='pass-confirm' name='pass-confirm' placeholder='lozinka'></td></tr>";
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label>" + user.email + "</label></td></tr>";
    inHtml += "<tr><td><label for='name'>Ime:</label></td><td><input type='text' id='name' name='name' value='" + user.name + "'></td></tr>"
    inHtml += "<tr><td><label for='surname'>Prezime:</label></td><td><input type='text' id='surname' name='surname' value='" + user.surname + "'></td></tr>"
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><select id='city' name='city'></select>" +  "</td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><input type='text' id='address' name='address' value='" + user.address + "'></td></tr>"
    if(user.active == "1") inHtml += "<td>" + "<input type='checkbox' name='active' value='1' checked>" + "Aktivan" + "</td>";
    else inHtml += "<td>" + "<input type='checkbox' name='active' value='1'>" + "Aktivan" + "</td>";
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td colspan='5'><input type='hidden' id='editUser' name='editUser' value='" + user.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form>";
    $("#content").prepend(inHtml);

    setCities("#city", user.city);

};

var setUserView = function (user) {
    var inHtml = '';
    inHtml += "<table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='username'>Korisničko ime: </label></td><td><label>" + user.username + "</label></td></tr>";
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label>" + user.email + "</label></td></tr>";
    inHtml += "<tr><td><label for='name'>Ime:</label></td><td><label>" + user.name + "</label></td></tr>"
    inHtml += "<tr><td><label for='surname'>Prezime:</label></td><td><label>" + user.surname + "</label></td></tr>"
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><label>" + user.city + "</label></td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><label>" + user.address + "</label></td></tr>";
    if(user.image == "") inHtml += inHtml += "</tr><tr><td><img src='" + "public/img/profile/defaultUser.jpg" + "'>" + "</img></td><td>";
    else inHtml += "</tr><tr><td><img src='" + user.image.substring(3) + "'>" + "</img></td><td>";
    inHtml += "</table>";
    return inHtml;

};

var loadReservations = function (reservation) {
    var inHtml = "<table id='user-reservations'>";
    $.each(reservation, function (i, item) {
        inHtml += "<tr><td>" + reservation[i].restaurant + "</td><td>" + reservation[i].reservedAt.substring(5, 17) + "</td><td>Prihvaćeno: " + reservation[i].accepted + "</td></tr>";
        inHtml += "<tr class='" + "reservation-item-" + i + "' ><td colspan='3'>" + reservation[i].acceptedMessage + "</td></tr>";
        inHtml += "<tr class='" + "reservation-item-" + i + "' ><td colspan='3'>" + reservation[i].completedMessage + "</td></tr>";
    })
    inHtml += "</table>"
    return inHtml;
}

var completeSetupUser = function (e) {
    $(document).on("submit", "#editUser", function(event) {
        event.preventDefault();

        var url=$(this).attr("action");
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),
            success: function (data, status) {
                if (data['success'] == undefined) {
                    showMessage("error", data);
                } else {
                    showMessage("success", data);
                }
            }
        });

    });
    //
    // $("#editUser").submit(function() {
    //     $.ajax({
    //         type: "POST",
    //         url: "api/user.php",
    //         data: $(this).serialize(),
    //         success: function (data) {
    //             var parsed = JSON.parse(data);
    //             if (parsed['success'] == undefined) {
    //                 showMessage("error", parsed);
    //             } else {
    //                 showMessage("success", parsed);
    //             }
    //         }
    //     });
    //
    //     e.preventDefault();
    // });

};
$('document').ready(function(e){
    clearContent();

    var params = getParams();

    if(params["id"] != undefined){
        loadUser(params["id"][0]);
    } else {
        loadUsers();
    }

    completeSetupUser(e);
})