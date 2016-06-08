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

var setEditRestaurantView = function (restaurant) {
    var inHtml = '';
    inHtml += "<form id='editRestaurant' method='post' name='editRestaurant' action='api/restaurant.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
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
    if(restaurant.picture == "") inHtml += inHtml += "</tr><tr><td><img src='" + "public/img/profile/defaultRestaurant.jpg" + "'/>" + "</td><td>";
    else inHtml += "</tr><tr><td><img src='" + restaurant.picture.substring(3) + "'/>" + "</td><td>";
    inHtml += "<table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='username'>Korisničko ime: </label></td><td><label>" + restaurant.name + "</label></td></tr>";
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
    inHtml += "<form id='newMenu' method='post' name='newMenu' action='api/menu.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='title'>Naslov:</label></td><td><input type='text' id='title' name='title'></td></tr>"
    inHtml += "<tr><td><label for='description'>Opis:</label></td><td><input type='text' id='description' name='description'></td></tr>";
    inHtml += "</tr><tr><td><label for='image'>Slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' id='restaurant' name='restaurant' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newMenu' name='newMenu' value='" + restaurant.id + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submitMenu' class='button' type='submit' value='Dodaj'></td></tr>";
    inHtml += "</table></form>";

    $("#newMenu").submit(function(e) {
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
    });

    return inHtml;
};

var setMenuCards = function (menus) {
    inHtml = "<div class='menus'>"
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
            
            $("#restaurantDetails").append(setMenuCards(json["restaurant"]["menus"]))

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

})