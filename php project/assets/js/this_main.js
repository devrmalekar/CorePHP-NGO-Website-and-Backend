/**
 * Created by root on 10/27/15.
 */
$(document).ready(function(){
    jssor_1_slider_init();
});

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
        $("nav").find("section[class='eventList active']").removeClass("active");
        $("nav").find("section[id='section-" + (num - 1) + "']").addClass("active");
    });
}

function redirectMemory(id){
    $("#memory-"+id).submit();
}