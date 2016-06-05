var loadRestourants = function(){
    $.ajax({
        url: 'api/restaurant.php',
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            var inHtml = "<div class='restaurants elavated'>"
            $.each(json, function(i, item){
                inHtml += "<div class='restaurant'>";
                inHtml += "<img src='" + json[i].picture.substring(3) + "'>" + "</img>"
                inHtml += "<p>" + "Naziv: " + json[i].name + "</p>"
                inHtml += "<p>" + "Email: " + json[i].email + "</p>"
                inHtml += "<p>" + "Grad: " + json[i].city + "</p>"
                inHtml += "<p>" + "Adresa: " + json[i].address + "</p>"
                inHtml += "</div>";

            })
            inHtml += "</div>"
            $("#content").html(inHtml);
        }
    });
}

$('document').ready(function(e){
    clearContent();
    loadRestourants();
})