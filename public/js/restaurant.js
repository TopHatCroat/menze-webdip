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
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><select id='city' name='city'></select>" + restaurant.city + "</td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><input type='text' id='address' name='address' value='" + restaurant.address + "'></td></tr>"
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form>";
    return inHtml;
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
    var inHtml = '';
    inHtml += "<form id='editMenu' method='post' name='editMenu' action='api/menu.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='title'>Naslov:</label></td><td><input type='text' id='title' name='title' value='" + menu.name + "'></td></tr>"
    inHtml += "<tr><td><label for='description'>Opis:</label></td><td><input type='text' id='title' name='title' value='" + menu.description + "'></td></tr>";
    inHtml += "</tr><tr><td><label for='image'>Profilna slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurantId + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Izmjeni'></td></tr>";
    inHtml += "</table></form>";
    return inHtml;
};

var setNewMenuView = function (restaurant) {
    var inHtml = '';
    inHtml += "<form class='item-info' id='newMenu' method='post' name='newMenu' action='api/menu.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='title'>Naslov:</label></td><td><input type='text' id='title' name='title'></td></tr>"
    inHtml += "<tr><td><label for='description'>Opis:</label></td><td><input type='text' id='description' name='description'></td></tr>";
    inHtml += "</tr><tr><td><label for='image'>Slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newMenu' name='newMenu' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submitMenu' class='button' type='submit' value='Dodaj'></td></tr>";
    inHtml += "</table></form>";


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

var loadEditReservations = function (reservation) {
    $.each(reservation, function (i, item) {
        var inHtml = "<form><table id='user-reservations'>";
        //TODO:: complete this here you dumb ass
        inHtml += "<tr><td><label>Reserved at:</label></td></td><td><label>" + reservation[i].reservedAt.substring(5, 17) + "</label></td><td>Prihvaćeno: " + reservation[i].accepted + "</td></tr>";
        inHtml += "<tr class='" + "reservation-item-" + i + "' ><td colspan='3'>" + reservation[i].acceptedMessage + "</td></tr>";
        inHtml += "<tr class='" + "reservation-item-" + i + "' ><td colspan='3'>" + reservation[i].completedMessage + "</td></tr>";
        inHtml += "<tr><td colspan='3'><input type='hidden' id='newMenu' name='newMenu' value='" + restaurant.id + "'></td></tr>"
        inHtml += "</table></form>";
        $("#restaurantDetails").append(inHtml);

        $("#newMenu").submit(function(e) {
            $.ajax({
                type: "POST",
                url: "api/reservations.php",
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
    })
    return inHtml;
}

var setReservationView = function (restaurant) {
    inHtml = "<div class='reservation'>"
    inHtml += "<form id='newReservation' method='post' name='newReservation' action='api/reservation.php'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='dateTime'>Vrijeme i datum:</label></td><td><input type='text' value='' name='dateTime' id='newReservationPicker'/></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newReservation' name='newReservation' value='1'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Rezerviraj'></td></tr>";
    inHtml += "</table></form></div>";

    return inHtml;
};

var setReservationEditView = function (restaurant) {
    inHtml = "<div class='reservation'>"
    inHtml += "<form id='editReservation' method='post' name='editReservation' action='api/reservation.php'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='dateTime'>Vrijeme i datum:</label></td><td><input type='text' value='' name='dateTime' id='editReservationPicker'/></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newReservation' name='newReservation' value='1'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submit' class='button' type='submit' value='Rezerviraj'></td></tr>";
    inHtml += "</table></form></div>";

    return inHtml;
};

var completeSetup = function (e) {
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
};

var loadRestaurant = function (restaurantId) {
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
            } else {
                $("#restaurantDetails").append(setRestaurantView(json["restaurant"]));
            }
            $("#restaurantDetails").append(setReservationView(json["restaurant"]));

            $("#restaurantDetails").append(setMenuCards(json["restaurant"]["menus"]));

            $.datetimepicker.setLocale('hr');
            $('#newReservationPicker').datetimepicker({
                dayOfWeekStart : 1,
                lang:'hr',
            });

            completeSetup();

        }
    });    
};

$('document').ready(function(e){
    clearContent();
    var params = getParams();

    if(params["id"] != undefined){
        loadRestaurant(params["id"][0]);
    } else {
        loadRestaurants();
    }

    completeSetup(e);

})