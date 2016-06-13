var pictures = [];

var filterPictures = function(filter){
    $("#pictures").empty();
    $.each(pictures, function(i){
        var inHtml = '';

        if(filter == '' || pictures[i].tags.search(filter) != -1){
            inHtml += "<div class='card card-shadowed-inactive'>";
            inHtml += "<img src='" + pictures[i].path.substring(3) + "'/>";
            inHtml += "<p class='card-title'>" + pictures[i].title + "</p>";
            inHtml += "<p class='card-body'>" + pictures[i].tags + "</p>";
            inHtml += "<p class='card-body'>" + pictures[i].dailyMenu + ", " + pictures[i].restaurant + "</p>";
            inHtml += "</div>";
        }
        $("#pictures").append(inHtml);
    })

}

var loadFilter = function () {
    inHtml = "<div id='filter'>";
    inHtml += "Pretraživanje: <input id='filterInput' type='text'/>";
    inHtml += "</div>";
    $("#content").prepend(inHtml);
    $("#filterInput").on('keyup', function () {
        filterPictures($(this).val());
    })
}

var loadPictures = function(){
    if(pictures.length != 0) var url = "api/picture.php?skip=" + pictures.length;
    else var url = "api/picture.php?"
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function (json) {
            $.each(json, function(i, item){
                pictures.push(json[i]);
            });
            filterPictures($("#filterInput").val());

        }
    });
}

var setNewPictureView = function (dailyMenu) {
    var inHtml = "";
    inHtml += "<form class='item-info' id='newPictureForm' method='post' name='newPicture' action='api/picture.php' enctype='multipart/form-data'><table class='fill-horizontal'>";
    inHtml += "Dodaj novu sliku";
    inHtml += "<tr><td><label for='title'>Naslov:</label></td><td><input type='text' id='title' name='title'></td></tr>"
    inHtml += "<tr><td><label for='tags'>Oznake:</label></td><td><input type='text' id='tags' name='tags'></td></tr>";
    inHtml += "</tr><tr><td><label for='image'>Slika:</label></td><td><input type='file' id='image' name='image'></td></tr>";
    inHtml += "<tr><td></td><td><input type='hidden' id='dailyMenu' name='dailyMenu' value='" + dailyMenu + "'></td></tr>"
    inHtml += "<tr><td></td><td><input type='hidden' id='newPicture' name='newPicture' value='" + 1 + "'></td></tr>"
    inHtml += "<tr><td></td><td><input id='submitPicture' class='button' type='submit' value='Dodaj'></td></tr>";
    inHtml += "</table></form>";
    return inHtml;
};

var completeSetupPicture = function (){
    $("body").on('submit', '#newPictureForm', function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "api/picture.php",
            data: $("#newPictureForm").serialize(),
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
}

$('document').ready(function(e){
    clearContent();
    var params = getParams();
    if (params['success'] != undefined) {
        showMessage("success", params);
    }
    if (params['errors'] != undefined) {
        showMessage("error", params);
    }


    if(params["dailyMenu"] != undefined){
        $("#content").append(setNewPictureView(params["dailyMenu"], e));
    } else {
        $("#content").append("<div id='pictures'></div>");
        loadFilter();
        loadPictures();
    }

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            loadPictures();
        }
    });


    //completeSetupPicture(e);

});