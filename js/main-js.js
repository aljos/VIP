/**
 * Created by Yura Sokolovskyi on 22.08.2017.
 */


$('body').addClass('stop-scrolling');
$(window).load(function () {
    $('#dvLoading, .loading-mask').fadeOut(2000);
    $('body').removeClass('stop-scrolling');
});


$(document).ready(function () {

    /*-----contacts-----*/

    var windowWidth = $(window).width();
    $('.contacts-button').click(function () {
        $(".contacts-wrapper").toggleClass('active');
        if ($(".contacts-wrapper").hasClass('active')) {
            $(".main-navigation").fadeOut(100, function () {
                $(".line-move").animate({
                    marginRight: 345
                }, 300, function () {
                    $(".line-move").css('marginRight', '7px');
                    $(".contacts-wrapper").fadeIn(100);
                });
            });
        }
        else {
            $(".contacts-wrapper").css('width', '338px');
            $(".contacts").css('display', 'none');
            $(".contacts-wrapper").animate({
                width: 0
            }, 300, function () {
                $(".main-navigation").fadeIn(100);
                $(".contacts-wrapper").hide(function () {
                    $(".contacts").css('display', 'flex');
                    $(".contacts-wrapper").css('width', 'auto');
                });
            });
        }
    });

    /*-----contacts-end-----*/


    /*-----mobile-contacts-----*/

    $('.contacts-button').click(function () {
        $(".mobile-contacts-wrapper").toggleClass('active');
        $(".mobile-contacts-wrapper").show();
        if ($(".mobile-contacts-wrapper").hasClass('active')) {
            $(".mobile-contacts-wrapper").animate({
                height: '130'
            }, 500, function () {
                // Animation complete.
            });
        }
        else {
            $(".mobile-contacts-wrapper").animate({
                height:  '0',
                display: 'none'
            }, 500, function () {
                $(".mobile-contacts-wrapper").hide();
            });
        }
    });

    $('#mobile-catalog-button,.catalog-button,#mask,#cart-button').click(function () {

        $(".mobile-contacts-wrapper").removeClass('active');

        $(".mobile-contacts-wrapper").animate({
            height:  '0',
            display: 'none'
        }, 500, function () {
            $(".mobile-contacts-wrapper").hide();
        });


    });


    /*-----mobile-contacts-end-----*/

    var contentMargin = $('#topnavbar').height();

    $('#content').css('margin-top', contentMargin - 2)

    /*-----content-end-----*/


    /*-----content-end-----*/


    //slider

    $('select').niceSelect();

    $('.slider-popular').slick({
        slidesToShow:   4,
        slidesToScroll: 1,
        autoplay:       true,
        autoplaySpeed:  2000,
        responsive:     [
            {
                breakpoint: 768,
                settings:   {
                    slidesToShow:   2,
                    slidesToScroll: 1
                }
            },

            {
                breakpoint: 480,
                settings:   {
                    slidesToShow:   1,
                    slidesToScroll: 1
                }
            }

        ]
    });

    $('.slider-home-products').slick({
        slidesToShow:   4,
        slidesToScroll: 1,
        autoplay:       true,
        autoplaySpeed:  2000,
        responsive:     [
            {
                breakpoint: 768,
                settings:   {
                    slidesToShow:   2,
                    slidesToScroll: 1
                }
            },

            {
                breakpoint: 480,
                settings:   {
                    slidesToShow:   1,
                    slidesToScroll: 1
                }
            }]
    });


    $('.main-slider').slick({
        autoplay:       true,
        autoplaySpeed:  2000,
        centerMode:     true,
        slidesToShow:   1,
        slidesToScroll: 1,
        infinite:       true,
        cssEase:        'linear',
        centerPadding:  '0'


    });


    //end slider


    /*-----catalog-----*/
    var windowHeight  = $(window).height();
    var catalogHeight = windowHeight - contentMargin + 2;
    $('.main-catalog').css('height', catalogHeight);
    $('#catalog').hide();
    $('#catalog-button, #catalog-close-button').click(function () {
        $('#catalog').show();
        $('body').toggleClass('stop-scrolling');
        $(".main-catalog").toggleClass('active');
        $('#nav-icon3').toggleClass('open');
        if ($(".main-catalog").hasClass('active')) {
            $('.catalog-button span.hidden-lg').html('&times;');
            $(".main-catalog").animate({
                top: contentMargin - 2
            }, 500, function () {
                // Animation complete.
            });
        }
        else {
            $('.catalog-button span.hidden-lg').html('каталог товаріів');
            $(".main-catalog").scrollTop('.main-catalog');
            $(".main-catalog").animate({
                top: contentMargin - windowHeight
            }, 500, function () {
                // Animation complete.
                $('#catalog').hide();
            });
        }
    });

    $('#mask,#mobile-catalog-button,.contacts-button,#mask,#cart-button').click(function () {
        $(".main-catalog").animate({
            top: contentMargin - windowHeight
        }, 500, function () {
        });
        $("#nav-icon3").removeClass('open');
        $(".main-catalog").removeClass('active');
        $('.catalog-button span.hidden-lg').html('каталог товаріів');
        $('body').removeClass('stop-scrolling');

    });

    /*-----catalog-end-----*/

    /*-----mobile-menu-----*/

    $('#mobile-catalog-button').click(function () {
        $(".main-navigation-mobile").toggleClass('active');
        $('#nav-icon-menu').toggleClass('open');
        $(".main-navigation-mobile").show();
        if ($(".main-navigation-mobile").hasClass('active')) {
            $(".main-navigation-mobile").animate({
                height: '200'
            }, 500, function () {
                // Animation complete.
            });
        }
        else {
            $(".main-navigation-mobile").animate({
                height:  '0',
                display: 'none'
            }, 500, function () {
                $(".main-navigation-mobile").hide();
            });
        }
    });

    $('.contacts-button,.catalog-button,#mask,#cart-button').click(function () {

        $(".main-navigation-mobile").removeClass('active');
        $('#nav-icon-menu').removeClass('open');

        $(".main-navigation-mobile").animate({
            height:  '0',
            display: 'none'
        }, 500, function () {
            $(".main-navigation-mobile").hide();
        });

    });


    /*-----mobile-menu-end-----*/


    /*-----cart-----*/


    var CartHeight = windowHeight - contentMargin + ($('.shadow').height());
    var holderHeight;
    if (windowWidth < 768) {
        holderHeight = CartHeight - ($('.cart-to-order').height()) - 90;
    }
    else {
        holderHeight = CartHeight - ($('.nav-pills').height()) - ($('.cart-items-header').height()) - ($('.cart-to-order').height()) - 225;
    }

    var toorderHeight;
    if (windowWidth < 768) {
        toorderHeight = CartHeight - ($('.buttons-to-order').height()) - 160;
    }
    else {
        toorderHeight = CartHeight - ($('.nav-pills').height()) - ($('.buttons-to-order').height()) - 180;
    }


    $('.scrollbar-light').scrollbar();
    $('#cart-tab .scroll-wrapper').css("height", holderHeight);
    $('#to-order-tab .scroll-wrapper').css("height", toorderHeight);


    $('#cart-button, .continue-shopping-button a').click(function () {
        $("#cart").toggleClass('active');
        if ($("#cart").hasClass('active')) {
            $('#cart').animate({
                height:  CartHeight,
                display: "block",
            }, 500, function () {
                $('body').addClass('stop-scrolling');
            });
        }
        else {
            $("#cart").animate({
                height:  "0",
                display: "none",
            }, 500, function () {
                $('body').removeClass('stop-scrolling');
                $('.nav-pills .arrow').removeClass('active');
                $('.nav-pills li').first().addClass('active');
                $('#cart-tab').addClass('active');
                $('#to-order-tab').removeClass('active');
            });
        }
    });
    $('#cart-to-order-button').click(function () {
        $('.nav-pills .arrow').removeClass('active');
        $('.nav-pills li').first().addClass('active');
        $('#cart-tab').addClass('active');
        $('#to-order-tab').removeClass('active');
    });
    $('#mask').click(function () {
        $("#cart").animate({
            height:  "0",
            display: "none",
        }, 500, function () {
        });
        $("#cart").removeClass('active');
        $('.nav-pills .arrow').removeClass('active');
        $('.nav-pills li').first().addClass('active');
        $('#cart-tab').addClass('active');
        $('#to-order-tab').removeClass('active');
    });

    var count = $('.item-number').length;
    $('.remove-cart-item-button').click(function () {
        var item = $(this).closest('.row');
        item.animate({
            opacity: 0
        }, 500, function () {
            item.remove();
        });
        count = count - 1;
        $(".number").html(count);
        if (count > 0) {
            $('.cart-indicator').css('fill', '#91C11E')
        }
        else {
            $('.cart-indicator').css('fill', '#F05B22')
        }
    });
    if (count > 0) {
        $('.cart-indicator').css('fill', '#91C11E')
    }
    else {
        $('.cart-indicator').css('fill', '#F05B22')
    }
    $(".number").html(count);


    /*-----cart-end-----*/

    /*
     $('.minus').click(function () {
     var home = $(this).first().parent('.input-number-buttons');
     var $input = $(home).parent().find('input');
     var count = parseInt($input.val()) - 1;

     count = count < 1 ? 1 : count;
     $input.val(count);
     $input.change();
     return false;
     });
     $('.plus').click(function () {

     var home = $(this).first().parent('.input-number-buttons');
     var $input = $(home).parent().find('input');
     $input.val(parseInt($input.val()) + 1);
     $input.change();
     return false;
     });
     */


    /*----------Categories----------*/


    $('.left-nav-bar a').click(function () {

        $('.left-nav-bar ul li').removeClass('active');

        $(this).first().parent().addClass('active');

    });

    /*----------Categories-End----------*/

    /*----------More-products----------*/

    $('.catalog-item-wrapper .col-lg-3').hide();

    var productItems = $(".catalog-item-wrapper .col-lg-3").length;

    if (productItems <= 16) {
        $('.more-products').hide();
    }

    $(".catalog-content .col-lg-3").slice(0, 16).show().addClass("show");

    var productItemsToShow = $(".catalog-item-wrapper .show").length;

    var productShowOption = productItems - productItemsToShow;


    $(".more-products").click(function () {

        if (productShowOption > 16) {
            $(".catalog-item-wrapper .col-lg-3").slice(0, productItemsToShow + 16).fadeIn(700).addClass("show");
            productShowOption = productShowOption - 16;

        }
        else {
            $(".catalog-item-wrapper .col-lg-3").slice(0, productItems).fadeIn(700).addClass("show");
            $('.more-products').hide();


        }


        if (productShowOption < 16) {
            $('.more-products span').html(productShowOption);
        }

    });


    if (productShowOption < 16) {
        $('.more-products span').html(productShowOption);
    }


});


/*----------More-products-End----------*/

function CheckNumb(event) {
    event = event || window.event;
    if (event.charCode && (event.charCode < 48 || event.charCode > 57))// проверка на event.charCode - чтобы пользователь мог нажать backspace, enter, стрелочку назад...
    {
        if (event.charCode != 44 && event.charCode != 46 && event.charCode != 45) {
            //alert("Дозволено вводити лише цифри!");
            return false;
        }
    }
}

function changeWareQtyPlus(idware) {
    var inputQty = parseFloat($("#qty-" + idware).val());
    var wareUnit = $("#qty-" + idware).attr("data-unit");
    var step;

    switch (wareUnit) {
        case "кг.":
            step = 0.1;
            break;
        case "л.":
            step = 0.5;
            break;
        case "шт.":
            step = 1;
            break;
        case "уп.":
            step = 1;
            break;
        default:
            step = 1;
    }

    var newInputQty = parseFloat(inputQty + step).toFixed(2);
    //alert(newInputQty);
    $("#qty-" + idware).val(newInputQty);

}

function changeWareQtyMinus(idware) {
    var inputQty = parseFloat($("#qty-" + idware).val());
    var wareUnit = $("#qty-" + idware).attr("data-unit");
    var wareMin  = parseFloat($("#qty-" + idware).attr("data-min-weight"));
    var step;

    switch (wareUnit) {
        case "кг.":
            step = 0.1;
            break;
        case "л.":
            step = 0.5;
            break;
        case "шт.":
            step = 1;
            break;
        case "уп.":
            step = 1;
            break;
        default:
            step = 1;
    }


    var newInputQty = parseFloat(inputQty - step).toFixed(2);
    //alert(newInputQty);
    if (newInputQty < step) {
        newInputQty = parseFloat(step).toFixed(2);
    }

    if (newInputQty < wareMin && wareMin > 1) {
        newInputQty = parseFloat(wareMin).toFixed(2);
    }

    $("#qty-" + idware).val(newInputQty);

}