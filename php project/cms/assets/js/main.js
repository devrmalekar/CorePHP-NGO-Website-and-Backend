/**
 * Created by root on 10/6/15.
 */
/*Image and Video upload add remove*/
    var photoCount = 1;
    var videoCount = 1;

    function addPhoto(){
        var addPhoto = $("#addMorePhoto");
        $("#addMorePhoto").remove();
        var removePhoto =  '<button type="button" id="RemovePhoto-'+photoCount+'" onClick="removePhoto('+photoCount+');"  class="btn btn-default removePhoto"><span class="fa fa-remove"></span></button>';
        $(removePhoto).insertAfter($("#img-"+photoCount));

        var photos ='<div class="row"  id="photo-'+(++photoCount)+'">' +
            ' <input type="file" id="'+photoCount+'" onchange="readImg(this, this.id)" class="form-control addPhoto" name="Photo-'+photoCount+'"  tabindex="7"' +
            '  placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, image/png"/>  ' +
            '<img class="img-responsive" id="img-'+photoCount+'" src="" /></div>';
        var insertAfter = "photo-"+(photoCount-1);

        $(photos).insertAfter($("#"+insertAfter));
        $(addPhoto).insertAfter($("#img-"+photoCount));

        $("input[name='photoCount']").val(photoCount);
    }

    function addVideo(){
        var addVideo = $("#addMoreVideo");
        $("#addMoreVideo").remove();
        var removeVideo =  '<button type="button" id="RemoveVideo-'+videoCount+'" onClick="removeVideo('+videoCount+');"  class="btn btn-default removeVideo"><span class="fa fa-remove"></span></button>';
        $(removeVideo).insertAfter($("#vid-"+videoCount));

        var video ='<div class="row"  id="video-'+(++videoCount)+'">' +
            ' <input type="text" id="vid-'+videoCount+'"  class="form-control addVideo" name="Video-'+videoCount+'"  tabindex="7"' +
            '  placeholder="Please input video url." />  ' +
            '</div>';
        var insertAfter = "video-"+(videoCount-1);

        $(video).insertAfter($("#"+insertAfter));
        $(addVideo).insertAfter($("#vid-"+videoCount));
        $("input[name='videoCount']").val(videoCount);
    }


    function removePhoto(photoCount){
        $("#photo-"+photoCount).remove();
        $("#RemovePhoto-"+photoCount).remove();
    }

    function removeVideo(videoCount){
        $("#video-"+videoCount).remove();
    }

    function readImg(input, id){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-'+id)
                    .attr('src', e.target.result)
                    .css('margin-bottom', '4px')
                    .css('margin-top', '4px');
                if(id.indexOf("Photo") > 0) {
                    $('#img-' + id).width(90)
                        .css('float', 'left')
                        .height(60);
                } else {
                    $('#img-' + id).css("width", "240px")
                        .css("margin-right", "4px");
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readVideo(src, id){
        /*  var arr = id.split("-");
         var videoCount = arr[1];
         var $iframeName = '<iframe class="embed-responsive-item" id="iframe-'+videoCount+'" src="'+src+'" ></iframe>';
         alert($iframeName);
         var $appendTo =  $("#embed-"+videoCount);
         $("#iframe-"+videoCount).remove();
         $($iframeName).appendTo($appendTo);
         */
    }


/*Image and Video upload add remove addGallery.php*/

function showMap(lat, lng, content){
    var mapCanvas = document.getElementById('map');
    $("#map").css("height","400px");

    var latlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        center: latlng,
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    var map = new google.maps.Map(mapCanvas, mapOptions);

    var marker = new google.maps.Marker({
        position: latlng,
        label: 'MFN',
        animation: google.maps.Animation.DROP,
        map: map
    });

    var contents = content;
    var infoWindow = null;

    infoWindow = new google.maps.InfoWindow();
    infoWindow.setOptions({
        content: contents,
        position: latlng,
        maxWidth: 1100
    });
    infoWindow.open(map, marker);

    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
}

function initBootPag(total) {
    $('#page-selection').bootpag({
        total: total,
        page: 1,
        maxVisible: 5,
        leaps: true,
        firstLastUse: true,
        first: '←',
        last: '→',
        wrapClass: 'pagination',
        activeClass: 'active',
        disabledClass: 'disabled',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first'
    }).on("page", function (event, /* page number here */ num) {
        $("#content").find("section[class='active']").removeClass("active");
        $("#content").find("section[id='section-" + (num - 1) + "']").addClass("active");
    });
}

