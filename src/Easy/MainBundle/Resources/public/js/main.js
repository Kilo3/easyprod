/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(window).on('load', function () {
    if(typeof $.cookie('cityId') === 'undefined'){

    }
});

function toggleMenu(menuClass){
    $('.'+menuClass).fadeToggle(200);
    $('.'+menuClass).toggleClass('open');
    console.log(menuClass);
    $('.menu-button').toggleClass('activeNavMenuButton');
}

function coloring(color){
    colorCapitalize = color.charAt(0).toUpperCase() + color.slice(1);
    $('.title').addClass(color);
    //$('.advantage').addClass(color);
    $('.advantage').addClass('red');
    $('.contact p').addClass(color);
    $('.button-square').addClass(color+'Square');
    $('#dialog').addClass(color);
    $('#thankyou').addClass(color);
    $('.stick').addClass('bg'+colorCapitalize);
}
function closeVideo(){
    $("#angle-video").css({
        'width':'100%',
        'padding-top':'0'
    });
    $('#angle-video').appendTo('.angle-block-video');
    $("#video-container").remove();
    var video = document.getElementById('angle-video');
    video.volume = 0;
    video.controls = false;
    video.play();
};

function init () {
    var myMap = new ymaps.Map("map", {
        center: [52.28, 104.29],
        zoom: 10
    }, {
        searchControlProvider: 'yandex#search'
    });
    $(".address a[address]").each(function(index){
        try{
            var coor = JSON.parse($(this).attr('data-coordinates'));
        }catch(e){
            console.log(e);
        }

        console.log($(this).attr('data-coordinates'),coor);
        myMap.geoObjects
            .add(new ymaps.Placemark(coor, {
                balloonContent: $(this).html()
            }, {
                preset: 'islands#icon',
                iconColor: '#0095b6'
            }));
    });
    $(".address a[address]").on('click', function(){
        var coor = JSON.parse($(this).attr('data-coordinates'));
        myMap.setCenter(coor, 14, {
            duration: 500
        });
    });

    myMap.events.add('click', function (e) {
        var coords = e.get('coords');
        console.log(coords);
    });

}

$(function(){


    $('.inside table').closest('.inside').css({'overflow-x':'scroll'});


    $('#nav>a').on('click', function(){
        var navigation = $('#nav');
        navigation.toggleClass('open');
        //navigation.css({'left':'-170px'});
    });

    //$('a[href*=#]:not([href=#])').click(function() {
    $('a[href*=#anchor]').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 300);
                return false;
            }
        }
    });




    $('a.submit').on('click', function(){
        //отправка
        var path = $('#form-controller-path').attr('data');
        var data = $('#callback').serializeArray();
        console.log(path);
        $.ajax({
            type: "POST",
            url: path,
            data: data,
            success: function(data, dataType)
            {
                console.log(data);
                if(data == 'sended'){
                    $( '#dialog' ).dialog( 'close' );
                    $( '#thankyou' ).dialog( 'open' );
                }
            },

            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown);
            }
        });


    });

    if($(".popup").length) {
        $(".popup").colorbox({
            inline: true,
            width: "auto",
            height: "auto",
            maxWidth: "90%",
            maxHeight: "100%",
            rel: "stuff",
            closeButton: true,
            arrowKey: false,
            previous: '',
            next: '',
            close: '',
            onComplete: function () {
                //$('#cboxLoadedContent').slimScroll({});
            }
        });
    }
    if($("#dialog").length) {
        $("#dialog").dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            draggable: false,
            minWidth: 450,
            height: 350,
            close: function (event, ui) {
                $("#dialog").removeClass("open");
            },
            open: function () {
                $('.ui-widget-overlay').bind('click', function () {
                    $('#dialog').dialog('close');
                })
            }
        });
    }
    if($("#thankyou").length) {
        $("#thankyou").dialog({
            autoOpen: false,
            modal: true,
            resizable: false,
            draggable: false,
            height: 300,
            minWidth: 400,
            open: function (event, ui) {
                $("#thankyou").addClass("open");
            },
            close: function (event, ui) {
                $("#thankyou").removeClass("open");
            }
        });
    }

    $( ".opener" ).click(function() {
        $( "#dialog" ).dialog( "open" );
        $( "#dialog" ).addClass("open");
    });

    if($("#map").length){
        ymaps.ready(init);
    }




    //angle-video start play and loop
    if($('#angle-video').length) {
        var video = document.getElementById('angle-video');
        video.defaultMuted = false;
        video.controls = false;
        video.volume = 0;
        video.play;
        var videoStartTime = 0;
        var durationTime = 0;

        video.addEventListener('loadedmetadata', function () {
            videoStartTime = 3;
            durationTime = 8;
            this.currentTime = videoStartTime;
        }, false);

        video.addEventListener('timeupdate', function () {
            if (this.currentTime > videoStartTime + durationTime && $('#video-container').length == 0) {
                this.currentTime = videoStartTime;
            }
        });

        //play and expand

        $('.play').on('click', function () {
            $("#page").before("<div id='video-container'></div>");
            $("#video-container").html("<a href='#' onclick='closeVideo()' class='close'><i class='fa fa-times-circle-o'></i></a>");
            $("#angle-video").appendTo("#video-container");

            var total = window.innerHeight - $('#video-container video').height();
            var foo = Math.round(total / 2);
            $('#video-container video').css({'padding-top': foo + 'px'});
            video.controls = true;
            video.volume = 0.7;
            video.currentTime = 1;
        });
    }





    if($('.slidesCont').length) {
        $('.slidesCont').slidesjs({
            width: 940,
            height: 450,
            navigation: false,
            play: {
                auto: false,
                interval: 5000
            },
            pauseOnHover: true
        });
    }
    if($('.slides-container').length) {
        $('.slides-container').slidesjs({
            width: 940,
            height: 540,
            navigation: false,
            play: {
                auto: false,
                interval: 5000
            },
            pauseOnHover: true
        });
    }

    if($(".content-slider").length){
        $(".content-slider").slidesjs({
            play: {
                active: false,
                effect: "slide",
                interval: 10000,
                auto: false,
                swap: false,
                pauseOnHover: true,
                restartDelay: 5000
            },
            autoHeight: true,
            navigation: false,
            pagination: false,
            callback: {
                complete: function(current) {
                    /*$('.content-slider').each(function() {
                     var maxHeight = 0;
                     $(this).find('figure.slidesjs-slide').each(function() {
                     if($(this).css('left') == '0px') {
                     maxHeight = $(this).height();
                     }
                     });
                     $(this).find(".slidesjs-container").animate({height: maxHeight});
                     });*/
                }
            }
        });

        $('.content-slider').each(function() {
            /*var maxHeight = 0;
             $(this).find('figure.slidesjs-slide').each(function() {
             if($(this).css('left') == '0px') {
             maxHeight = $(this).height();
             }
             });
             $(this).find(".slidesjs-container").animate({height: maxHeight});*/
        });

    }



    $('.calendar div.leftBlock a').on('click', function(){
        $('.calendar div.leftBlock a').removeClass('active');
        $(this).addClass('active');
        var data = $(this).attr('data');
        $('div.calendarMonth').removeClass('active');
        $('div.calendarMonth[month='+data+']').addClass('active');
    });

    //var colors = new Array('purple', 'yellow', 'lightBlue', 'blue', 'green', 'salad');
    $('.nav-menu:not(.mainMenu) .menuList div a').each(function(index, value){
        var color = $('#color').attr('data');
        $(this).attr('class', color+'Hover');
    });

    if($("#mainVideoSource").length){
        var video = document.getElementById("mainVideoSource");
        video.volume = 0.5;
    }

    if($(window).width() > 480 && $(window).height() < 1000){
        var foo = -(1000-$(window).height())/2;
        $('#nav').css({'top':foo+'px'});
    }


    $('.menu-section-link a').on('click', function(){
        $('.menu-section-content').css({'display':'none'});
        var section = $(this).attr('info');
        $('.menu-section-content[info='+section+']').css({'display':'block'});
    });

});


