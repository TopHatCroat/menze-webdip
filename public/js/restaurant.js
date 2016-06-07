var loadRestaurants = function(){
    $.ajax({
        url: 'api/restaurant.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='restaurants'>"
            $.each(json, function(i, item){
                inHtml += "<a class='' href='restaurant.php?id=" + json[i].id  + "'> <div class='card card-shadowed'>";
                if(json[i].picture == "") inHtml += "<img src='" + "public/img/profile/defaultRestaurant.jpg" + "'/>";
                else inHtml += "<img src='" + json[i].picture.substring(3) + "'/>";
                inHtml += "<p class='card-title'>" + json[i].name + "</p>";
                inHtml += "<p class='card-body'>" + "Email: " + json[i].email + "</p>";
                inHtml += "<p class='card-body'>" + "Adresa: " + json[i].address + ", " + json[i].city + "</p>";
                inHtml += "</div></a>";
            })
            inHtml += "</div>"
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
    if(restaurant.picture == "") inHtml += inHtml += "</tr><tr><td><img src='" + "public/img/profile/defaultRestaurant.jpg" + "'>" + "</img></td><td>";
    else inHtml += "</tr><tr><td><img src='" + restaurant.image.substring(3) + "'>" + "</img></td><td>";
    inHtml += "<table class='fill-horizontal'>";
    inHtml += "<tr><td><label for='username'>Korisničko ime: </label></td><td><label>" + restaurant.name + "</label></td></tr>";
    inHtml += "<tr><td><label for='email'>Email:</label></td><td><label>" + user.email + "</label></td></tr>";
    inHtml += "<tr><td><label for='city'>Grad:</label></td><td><label>" + user.city + "</label></td></tr>";
    inHtml += "<tr><td><label for='address'>Adresa:</label></td><td><label>" + user.address + "</label></td></tr>";
    inHtml += "</table>";
    return inHtml;
};

var loadRestaurant = function (restaurantId) {
    $.ajax({
        url: 'api/restaurant.php',
        type: 'GET',
        data: {id: restaurantId},
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='restaurant card card-detail'>"
            if(json["admin"] != undefined){
                inHtml += setEditRestaurantView(json["restaurant"]);
            } else {
                inHtml += setRestaurantView(json["restaurant"]);
            }

            inHtml += "</div>"
            $("#content").html(inHtml);
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