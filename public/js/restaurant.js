var loadRestourants = function(){
    $.ajax({
        url: 'api/restaurant.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='restaurants'>"
            $.each(json, function(i, item){
                inHtml += "<a class='' href='restaurant.php?id=" + json[i].id  + "'> <div class='card card-shadowed'>";
                if(json[i].picture == "") inHtml += "<img src='" + "public/img/profile/defaultRestaurant.jpg" + "'>" + "</img>";
                else inHtml += "<img src='" + json[i].picture.substring(3) + "'>" + "</img>";
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

$('document').ready(function(e){
    clearContent();
    loadRestourants();

    var params = getParams();
    console.log(params);

})