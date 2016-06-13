var loadRestaurants = function(){
    $.ajax({
        url: 'api/restaurant.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='restaurants'>";
            $.each(json, function(i, item){
                inHtml += "<a class='' href='restaurant.php?id=" + json[i].id  + "'> <div class='card card-shadowed'>";
                if(json[i].picture == "") inHtml += "<img src='" + "public/img/profile/defaultRestaurant.jpg" + "'/>";
                else inHtml += "<img src='" + json[i].picture.substring(3) + "'/>";
                inHtml += "<p class='card-title'>" + json[i].name + "</p>";
                inHtml += "<p class='card-body'>" + "Email: " + json[i].email + "</p>";
                inHtml += "<p class='card-body'>" + "Adresa: " + json[i].address + ", " + json[i].city + "</p>";
                inHtml += "</div></a>";
            });
            inHtml += "</div>";
            $("#content").html(inHtml);
        }
    });
}

var loadReservations = function () {

}

var setEditRestaurantView = function (restaurant) {
    var inHtml = '';
    inHtml += "<form class='item-info' id='editRestaurant' method='post' name='editRestaurant' action='api/restaurant.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='name'>Ime:</label></td><td><input type='text' id='name' name='name' value='" + restaurant.name + "'></td></tr>"
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label>" + restaurant.email + "</label></td></tr>";
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><select id='city' name='city'></select></td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><input type='text' id='address' name='address' value='" + restaurant.address + "'></td></tr>"
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form>";
    $("#content").prepend(inHtml);
    setCities("#city", restaurant.city);

};

var setRestaurantView = function (restaurant) {
    inHtml = '';
    if(restaurant.picture == "") inHtml += inHtml += "</tr><tr><td><img class='item-info' src='" + "public/img/profile/defaultRestaurant.jpg" + "'/>" + "</td><td>";
    else inHtml += "<img class='item-info' src='" + restaurant.picture.substring(3) + "'/>" + "";
    inHtml += "<table class='fill-horizontal item-info'>";
    inHtml += "<tr><td colspan='2'><label class='card-title'>" + restaurant.name + "</label></td></tr>";
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label>" + restaurant.email + "</label></td></tr>";
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><label>" + restaurant.city + "</label></td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><label>" + restaurant.address + "</label></td></tr>";
    inHtml += "</table>";
    return inHtml;
};

var setEditMenuView = function (menu, restaurantId) {
    var inHtml = "<div class='edit-menu'>";
    inHtml += "Uredi meni";
    inHtml += "<form id='editMenu' method='post' name='editMenu' action='api/menu.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='title'>Naslov:</label></td><td><input type='text' id='title' name='title' value='" + menu.name + "'></td></tr>"
    inHtml += "<tr><td><label for='description'>Opis:</label></td><td><input type='text' id='title' name='title' value='" + menu.description + "'></td></tr>";
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurantId + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form></div>";
    return inHtml;
};

var setNewMenuView = function (restaurant) {
    var inHtml = "<div class='new-menu'>";
    inHtml += "Dodaj novi meni";
    inHtml += "<form class='item-info' id='newMenu' method='post' name='newMenu' action='api/menu.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='title'>Naslov:</label></td><td><input type='text' id='title' name='title'></td></tr>"
    inHtml += "<tr><td><label for='description'>Opis:</label></td><td><input type='text' id='description' name='description'></td></tr>";
    inHtml += "</tr><tr><td><label for='image'>Slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newMenu' name='newMenu' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submitMenu' class='button' type='submit' value='Dodaj'></td></tr>";
    inHtml += "</table></form></div>";
    return inHtml;
};

var setNewDailyMenuView = function (restaurant) {
    var inHtml = "<div class='new-daily-menu'>";
    inHtml += "Dodaj novi dnevni meni";
    inHtml += "<form class='item-info' id='new-daily-menu' method='post' name='newDailyMenu' action='api/dailymenu.php' enctype='multipart/form-data'><table>";
    inHtml += "<tr><td><label for='type'>Tip:</label></td><td><input type='text' id='type' name='type'></td></tr>"
    inHtml += "<tr><td><label for='amount'>Količina:</label></td><td><input type='number' id='amount' name='amount' value='50' required='true'></td></tr>";
    inHtml += "<tr><td><label for='sold'>Prodano:</label></td><td><input type='number' id='sold' name='sold' value='0' required='true'></td></tr>";
    inHtml += "<tr><td><label for='menu'>Meni:</label></td><td><select id='menu' name='menu'></select>" + "</td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' name='newDailyMenu'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submitMenu' class='button' type='submit' value='Dodaj'></td></tr>";
    inHtml += "</table></form></div>";
    return inHtml;
};

var setMenuCards = function (menus) {
    inHtml = "<div class='clearfix'></div><div class='menus'>"
    $.each(menus, function(i, item){
        inHtml += "<div class='card card-shadowed'>";
        if(menus[i].image == "") inHtml += "<img src='" + "public/img/profile/defaultRestaurant.jpg" + "'/>";
        else inHtml += "<img src='" + menus[i].image.substring(3) + "'/>";
        inHtml += "<p class='card-title'>" + menus[i].title + "</p>";
        inHtml += "<p class='card-body'>" + menus[i].description + "</p>";
        inHtml += "</div></a>";
    });
    return inHtml += "</div>";
};

var setDailyMenuCards = function (dailyMenus) {
    inHtml = "<div class='clearfix'></div><div class='daily-menus'>"
    $.each(dailyMenus, function(i, item){
        inHtml += "<a href='picture.php?dailyMenu=" + dailyMenus[i].id + "'>";
        var diff = dailyMenus[i].amount - dailyMenus[i].sold;
        if(diff > 10) inHtml += "<div class='card card-shadowed'>";
        else inHtml += "<div class='card card-shadowed daily-menu-critical'>";
        if(dailyMenus[i].menu.image == "") inHtml += "<img src='" + "public/img/profile/defaultRestaurant.jpg" + "'/>";
        else inHtml += "<img src='" + dailyMenus[i].menu.image.substring(3) + "'/>";
        inHtml += "<p class='card-title'>" + dailyMenus[i].menu.title + "</p>";
        inHtml += "<p class='card-body'>" + dailyMenus[i].type + "</p>";
        inHtml += "<p class='card-body'>" + dailyMenus[i].menu.description + "</p>";
        inHtml += "</div></a>";
    });
    return inHtml += "</div>";
};


var setEditReservationsView = function (reservation) {
    var inHtml = "<div id='user-reservations'>Uređivanje rezervacija";
    $.each(reservation, function (i, item) {
        inHtml += "<form class='edit-reservation'><table class='user-reservation'>";
        inHtml += "<tr><td colspan='5'><a href='users.php?id=" + reservation[i].user.id + "'>" + reservation[i].user.username + "</td></tr>";
        inHtml += "<tr><td><label>Reservirano u </label></td></td><td><label>" + reservation[i].reservedAt.substring(5, 17) + "</label></td>";
        if(reservation[i].accepted == "1") inHtml += "<td>" + "<input type='checkbox' name='accepted' value='1' checked>" + "Prihvaćeno" + "</td>";
        else inHtml += "<td>" + "<input type='checkbox' name='accepted' value='1'>" + "Prihvaćeno" + "</td>";
        if(reservation[i].completed == "1") inHtml += "<td>" + "<input type='checkbox' name='completed' value='1' checked>"+ "Završeno" + "</td></tr>";
        else inHtml += "<td>" + "<input type='checkbox' name='completed' value='1'>"+ "Završeno" + "</td></tr>";
        inHtml += "<tr><td colspan='5'><input type='text' name='acceptedMessage' value='" + reservation[i].acceptedMessage + "' size='50'>" +  "</td></tr>";
        inHtml += "<tr><td colspan='5'><input type='text' name='acceptedMessage' value='" + reservation[i].acceptedMessage + "' size='50'>" +  "</td></tr>";
        inHtml += "<tr><td colspan='5'><input type='hidden' id='editReservation' name='editReservation' value='" + reservation[i].id + "'></td></tr>"
        inHtml += "<tr><td></td><td><input id='submitReservation' class='button' type='submit' value='Izmjeni'></td></tr>";
        inHtml += "</table></form>";
    });
    return inHtml + "</div>";
};

var setReservationView = function (restaurant) {
    inHtml = "<div class='reservation'>"
    inHtml += "Napravi novu rezervaciju";
    inHtml += "<form id='newReservation' method='post' name='newReservation' action='api/reservation.php'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='dateTime'>Vrijeme i datum:</label></td><td><input type='text' value='' name='dateTime' id='newReservationPicker'/></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newReservation' name='newReservation' value='1'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Rezerviraj'></td></tr>";
    inHtml += "</table></form></div>";

    return inHtml;
};

var completeSetup = function (e, restaurnat) {
    $("#newMenu").submit(function() {
        $.ajax({
            type: "POST",
            url: "api/menu.php",
            data: $("#newMenu").serialize(),
            success: function (data) {
                var parsed = JSON.parse(data);
                if (parsed['success'] == undefined) {
                    showMessage("error", parsed);
                } else {
                    showMessage("success", parsed);
                }
            }
        });

        e.preventDefault();
    });

    $("#newReservation").submit(function(e) {
        console.log("wtf!!!!");
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "api/reservation.php",
            data: $("#newReservation").serialize(),
            success: function(data) {
                var parsed = JSON.parse(data);
                if(parsed['success'] == undefined){
                    showMessage("error", parsed);
                } else {
                    showMessage("success", parsed);
                }
            }
        });

    });

    $(".editReservation").submit(function(e) {
        $.ajax({
            type: "POST",
            url: "api/reservation.php",
            data: $(this).serialize(),
            success: function (data) {
                var parsed = JSON.parse(data);
                if (parsed['success'] == undefined) {
                    showMessage("error", parsed);
                } else {
                    showMessage("success", parsed);
                }
            }
        });

        e.preventDefault();
    });
    
    $("#editRestaurant").submit(function(e) {
        $.ajax({
            type: "POST",
            url: "api/restaurant.php",
            data: $("#editRestaurant").serialize(),
            success: function (data) {
                var parsed = JSON.parse(data);
                if (parsed['success'] == undefined) {
                    showMessage("error", parsed);
                } else {
                    showMessage("success", parsed);
                }
            }
        });

        e.preventDefault();
    });

    setMenus("#menu", restaurnat);
};

var loadRestaurant = function (e, restaurantId) {
    $.ajax({
        url: 'api/restaurant.php',
        type: 'GET',
        data: {id: restaurantId},
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div id='restaurantDetails' class='restaurant card card-detail'></div>";
            $("#content").html(inHtml);

            if(json["admin"] != undefined){
                $("#restaurantDetails").append(setEditRestaurantView(json["restaurant"]));
                $("#restaurantDetails").append(setNewMenuView(json["restaurant"]));
                $("#restaurantDetails").append(setEditReservationsView(json["restaurant"]["reservations"]));
                $("#restaurantDetails").append(setNewDailyMenuView(json["restaurant"]));
                $("#restaurantDetails").append(setMenuCards(json["restaurant"]["menus"]));
            } else {
                $("#restaurantDetails").append(setRestaurantView(json["restaurant"]));
            }
            $("#restaurantDetails").append(setReservationView(json["restaurant"]));

            $("#restaurantDetails").append(setDailyMenuCards(json["restaurant"]["dailymenus"]));

            $.datetimepicker.setLocale('hr');
            $('#newReservationPicker').datetimepicker({
                dayOfWeekStart : 1,
                lang:'hr',
            });

            completeSetup(e, restaurantId);


        }
    });    
};

$('document').ready(function(e){
    clearContent();
    var params = getParams();

    if(params["id"] != undefined){
        loadRestaurant(e, params["id"][0]);
    } else {
        loadRestaurants();
    }

})