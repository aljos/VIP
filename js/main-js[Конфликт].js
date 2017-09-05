/**
 * Created by Yura on 22.08.2017.
 */
$(document).ready(function () {

    /*-----catalog-----*/

    $('#catalog-button, #catalog-close-button').click(function () {
        $(".main-catalog").toggleClass('active');
        $('#nav-icon3').toggleClass('open');
        if ($(".main-catalog").hasClass('active')) {
            $(".main-catalog").animate({
                top: 0,
            }, 500, function () {
                // Animation complete.
            });
        }
        else {
            $(".main-catalog").animate({
                top: '-600px',
            }, 500, function () {
                // Animation complete.
            });
        }
    });


    $('#mask').click(function () {
        $(".main-catalog").animate({
            top: '-600px',
        }, 500, function () {
        });
        $("#nav-icon3").removeClass('open');
        $(".main-catalog").removeClass('active');
    });

    /*-----catalog-end-----*/


    /*-----cart-----*/


    var windowHeight = $(window).height();
    var holderHeight = windowHeight - 450;

    $('.cart-items-holder').css("height", holderHeight);

    var CartHeight = windowHeight - 110;


    $('#cart-button, #continue-shopping-button').click(function () {
        $("#cart").toggleClass('active');

        if ($("#cart").hasClass('active')) {

            $('#cart').animate({
                height:  CartHeight,
                display: "block",

            }, 500, function () {
                // Animation complete.
            });
        }
        else {
            $("#cart").animate({
                height:  "0",
                display: "none",
            }, 500, function () {
                // Animation complete.
            });
        }
    });


    $('#cart-to-order-button').click(function () {

        $('.nav-pills .arrow').toggleClass('active');

        $('li').first().removeClass('active');
    });

    $('#mask').click(function () {

        $("#cart").animate({
            height:  "0",
            display: "none",
        }, 500, function () {
        });
        $("#cart").removeClass('active');
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


    $('.minus').click(function () {
        var home   = $(this).first().parent('.input-number-buttons');
        var $input = $(home).parent().find('input');
        var count  = parseInt($input.val()) - 1 + " шт";

        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {

        var home   = $(this).first().parent('.input-number-buttons');
        var $input = $(home).parent().find('input');
        $input.val(parseInt($input.val()) + 1 + " шт");
        $input.change();
        return false;
    });


});

