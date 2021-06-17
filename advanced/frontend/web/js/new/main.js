var map = [];
var placemarks = [];
var scroll_effect;
var filter_processing = false;
var version;
var font;
var images;

$(document).ready(function(){

    if($('.imp__sl').length){
        if (window.matchMedia("(min-width: 1024px)").matches) {
            $('.imp__sl').slick({
                dots: false,
                prevArrow: '.imp__sl-box .nav__prev',
                nextArrow: '.imp__sl-box .nav__next',
                infinite: false,
                slidesToShow: 2,
                slidesToScroll: 1
            });

            $('.imp__sl').on('beforeChange', function(event, slick, currentSlide, nextSlide){
                setTimeout(function () {
                    if($('.imp__sl-box .nav__prev').hasClass('slick-disabled')){
                        $('.sc__box-important .sl__before').removeClass('active');
                    }else{
                        $('.sc__box-important .sl__before').addClass('active');
                    }
                    if($('.imp__sl-box .nav__next').hasClass('slick-disabled')){
                        $('.sc__box-important .sl__after').removeClass('active');
                    }else{
                        $('.sc__box-important .sl__after').addClass('active');
                    }
                }, 200);
            });
        }


        $('.imp__sl .item__descr').matchHeight();
        $('.imp__sl .item__title').matchHeight();
    }

    if($('.ads__slider').length){
        if (window.matchMedia("(min-width: 1024px)").matches) {
            $('.ads__slider').slick({
                dots: false,
                prevArrow: '.ads__slider-box .nav__prev',
                nextArrow: '.ads__slider-box .nav__next',
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1
            });
        }

    }


    if($('.awards__slider').length){
        if (window.matchMedia("(min-width: 1024px)").matches) {
            $('.awards__slider').slick({
                dots: false,
                prevArrow: '.awards__slider-box .nav__prev',
                nextArrow: '.awards__slider-box .nav__next',
                infinite: false,
                slidesToShow: 5,
                slidesToScroll: 1
            });
        }

    }

    if($('.links__slider').length){
        if (window.matchMedia("(min-width: 1024px)").matches) {
            $('.links__slider').slick({
                dots: false,
                prevArrow: '.links__slider-box .nav__prev',
                nextArrow: '.links__slider-box .nav__next',
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1
            });
        }
    }

    $('.scroll').on('click', function(e){
        var anchor = $(this).attr('href');
        var anchor_link = $(anchor).offset().top;
        var offset = $(this).data('offset');
        var indent = $('.header-nav').outerHeight();
        $('html, body').stop().animate({
            scrollTop : anchor_link - indent +  "px"
        }, 1500, 'easeInOutExpo');
        e.preventDefault();
    });

    $(document).on('click', '.use__group-title', function (e) {
        if (window.matchMedia("(max-width: 767px)").matches) {
            var parent = $(this).closest('.use__group');
            if(parent.hasClass('active')){
                parent.removeClass('active');
                parent.find('.use__group-nav').slideUp();
            }else{
                $('.use__group').removeClass('active');
                $('.use__group-nav').slideUp();
                parent.addClass('active');
                parent.find('.use__group-nav').slideDown();
            }
            e.preventDefault();
        }

    });


    if (hasTouch()) {
        // remove all the :hover stylesheets
        try {
            // prevent exception on browsers not supporting DOM styleSheets properly
            for (const si in document.styleSheets) {
                const styleSheet = document.styleSheets[si];
                if (!styleSheet.rules) continue;

                for (var ri = styleSheet.rules.length - 1; ri >= 0; ri--) {
                    if (!styleSheet.rules[ri].selectorText) continue;

                    if (styleSheet.rules[ri].selectorText.match(':hover')) {
                        styleSheet.deleteRule(ri);
                    }
                }
            }
        } catch (ex) {}
    }


    if(!$.cookie('version')){
        $.cookie('version', 'normal', { path: '/' });
        $.cookie('font', 'x1', { path: '/' });
        $.cookie('images', '', { path: '/' });
    }else{
        version = $.cookie('version');
        font = $.cookie('font');
        images = $.cookie('images');
    }

    /*if(version === 'easy'){
        $('body').addClass('black-theme');
        $('img').addClass('grayscale');
        $('.education-main, .custom-map, .event-item-photo').addClass('grayscale');
    }*/

    if(images === 'no-image'){
        $('body').addClass('no-image-theme');
        $('.content img').each(function () {
            if(!$(this).closest('div').hasClass('main-item')){
                $(this).remove();
            }
        });
        $('.no-image').addClass('active');
        $('.education-main, .custom-map').addClass('grayscale');
    }else{
        $('.image').addClass('active');
    }

    if(font === 'x1'){
        $('.x1-font').addClass('active');
    }

    if(font === 'x2'){
        $('body').addClass('x2-font-theme');
        $('.x2-font').addClass('active');
    }

    if(font === 'x4'){
        $('body').addClass('x4-font-theme');
        $('.x4-font').addClass('active');
    }

    $('.easy-vers-link').on('click', function () {
        $.cookie('version', 'easy', { path: '/' });
        $.cookie('font', 'x1', { path: '/' });
        $.cookie('images', '', { path: '/' });
        location.reload();
    });

    $('.norm-vers-link').on('click', function () {
        $.cookie('version', 'normal', { path: '/' });
        $.cookie('font', 'x1', { path: '/' });
        $.cookie('images', '', { path: '/' });
        location.reload();
    });

    $('.easy-links a').on('click', function () {
        if(!$(this).hasClass('active')){
            if($(this).hasClass('no-image')){
                $.cookie('images', 'no-image', { path: '/' });
            }

            if($(this).hasClass('image')){
                $.cookie('images', '', { path: '/' });
            }


            if($(this).hasClass('x1-font')){
                $.cookie('font', 'x1', { path: '/' });
            }

            if($(this).hasClass('x2-font')){
                $.cookie('font', 'x2', { path: '/' });
            }

            if($(this).hasClass('x4-font')){
                $.cookie('font', 'x4', { path: '/' });
            }

            location.reload();
        }
    });

    var w_h = $(window).height();
    var w_w = $(window).width();
    $('.scroll').on('click', function(){
        var anchor = $(this).data('scroll');
        var anchor_link = $(anchor).offset().top;
        var offset = $(this).data('offset');
        var indent = 0;
        $('html, body').stop().animate({
            scrollTop : anchor_link - indent +  "px"
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

    scroll_effect = $.scrollorama({ blocks:'.wrapper' });

    scroll_effect.animate('.parallax-bg',{
        duration: 200,
        delay: 0,
        property:'top',
        start:0,
        end: -($('.parallax-bg').outerHeight() - $('.header-nav').outerHeight())
    });


    nav_arrow_pos();
    max_modal_content();

   /* $('.awards-modal-theme').on('click', function () {
        $('.custom-object-modal').addClass('awards-theme');
        $('.object-link').attr('data-slide', $(this).data('slide'));
        $('.object-link').trigger('click');
    });*/

    $('.custom-modal-open').fancybox({
        autoSize  : true,
        closeBtn: false,
        margin: 0,
        padding: 0,
        helpers: {
            overlay: {
                locked: false
            }
        },
        beforeShow: function() {
            $('input').removeClass('incorrect');
            $('input[type="text"]').val('');
            $('textarea').val('');
            var _this = this.element;

            if(this.element.hasClass('awards-modal-theme')){

                var parent = this.element.closest('.tab-pane');
                var aw_mod_title = parent.attr('id').substr(3);
                var aw_start_slide = this.element.closest('.awards-item').data('slide');
                $('#awards-modal .custom-modal-title').text(aw_mod_title + ' год');

                parent.find('.awards-item').each(function (i) {
                    var _this_aw_item = $(this);
                    var m_m_item = $('<div/>').addClass('modal-media-item');
                    var a_img_wrap = $('<div/>').addClass('award-img-wrap');
                    var img = $('<img/>');
                    if(i === aw_start_slide){
                        img.attr('src', _this.data('rel'));
                    }else{
                        img.attr('data-lazy', _this_aw_item.find('a').data('rel'));
                    }

                    var ph_info_item = $('<div/>').addClass('photo-info-item');
                    ph_info_item.text(_this_aw_item.find('a').data('title'));

                    img.appendTo(a_img_wrap);
                    a_img_wrap.appendTo(m_m_item);
                    m_m_item.appendTo('#awards-modal .modal-media-slider');
                    ph_info_item.appendTo('#awards-modal .photo-info-text');
                });
            }else{
                $('.custom-modal-content').scrollbar();
            }

            if(this.element.hasClass('object-link')){
                max_modal_content();


                $('body').addClass('fixed-modal-screen');

                if($('.modal-media-item').length){
                    $('.custom-modal .numb-slides').text($('.modal-media-item').length);
                    $('.custom-modal-block').css('padding-top', $(_this.attr('href')).find('.custom-modal-header').outerHeight() + "px");

                    $('.modal-media-slider').on('init', function(event, slick){
                        if($('.custom-object-modal').hasClass('awards-theme')){
                            setTimeout(function () {
                                $('.awards-theme .custom-modal-block').css('padding-bottom',  $('.awards-theme .media-descr').outerHeight() + "px");
                            }, 300);

                        }

                    });

                    var initial_slide = 0;
                    if(this.element.hasClass('awards-modal-theme')){
                        initial_slide = aw_start_slide;
                        $('.custom-modal .curr-slide').text(initial_slide + 1);
                    }

                    $('.modal-media-slider').slick({
                        dots: false,
                        lazyLoad: 'ondemand',
                        asNavFor: '.photo-info-text',
                        prevArrow: '.modal-media .nav-prev',
                        nextArrow: '.modal-media .nav-next',
                        initialSlide: initial_slide,
                        infinite: false
                    });

                    $('.photo-info-text').slick({
                        dots: false,
                        fade: true,
                        arrows: false,
                        asNavFor: '.modal-media-slider',
                        draggable: false,
                        initialSlide: initial_slide,
                        adaptiveHeight: true,
                        infinite: false
                    });


                    $('.modal-media-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
                        $('.custom-modal .curr-slide').text(nextSlide + 1);
                        if(_this.hasClass('awards-modal-theme')){
                            $('.custom-modal-content').scrollbar();

                        }

                    });

                    $('.modal-media-slider').on('afterChange', function(event, slick, currentSlide){
                        if(_this.hasClass('awards-modal-theme')){
                            $('.awards-theme .custom-modal-block').css('padding-bottom',  $('.awards-theme .media-descr').outerHeight() + "px");
                        }

                    });

                    $('.modal-media').removeClass('hidden');
                }else{
                    $('.modal-media').addClass('hidden');
                }







               /* $('.modal-media .photo-info-slider').slick({
                    dots: false,
                    fade: true,
                    arrows: false,
                    asNavFor: '.modal-media-slider',
                    draggable: false,
                    adaptiveHeight: true,
                    infinite: false
                });*/


            }


            $(".fancybox-skin").css("background-color", "transparent");

        },
        afterShow: function(){
            if($('.custom-modal-content').length){

                if(!$(this.element.attr('href')).hasClass('awards-theme')){
                    $('.custom-modal-content').scrollbar();

                }
                $('.custom-modal-block').css('padding-top', $(this.element.attr('href')).find('.custom-modal-header').outerHeight() + "px");
            }

            setTimeout(function () {
                $('.custom-modal-block .content-sections').addClass('active');
            }, 200);

        },
        beforeClose: function(){

        },
        afterClose: function() {
            if($('.modal-media-item').length){
                $('.modal-media-slider').slick('unslick');
                $('.photo-info-text').slick('unslick');
            }

            if(this.element.hasClass('awards-modal-theme')){
                $('#awards-modal .modal-media-slider').html('');
                $('#awards-modal .photo-info-text').html('');
            }
        }
    }).click(function() {
        if (typeof($(this).data('from')) !== 'undefined') {

        }
    });

    $('.modal-close').click(function() {
        $.fancybox.close();
        return false;
    });

    $('.main-item-content').hover(function () {
        $(this).find('.main-item-subtitle-wrap').slideDown(200);
    }, function () {
        $(this).find('.main-item-subtitle-wrap').slideUp(200);
    });

    $(".wrapper").mouseup(function(e){
        var targ_1 = $(".education-dropdown");
        var targ_2 = $(".add-calendar-block");
        var targ_3 = $(".calls-table");
        var targ_4 = $(".shedule-calls-link");
        var targ_5 = $(".open .dropdown-menu");

        if(!targ_1.has(e.target).length)
        {
            targ_1.removeClass('active');
        }

        if(!targ_2.has(e.target).length)
        {
            targ_2.removeClass('active');
        }

        if(!targ_3.has(e.target).length && !targ_4.has(e.target).length)
        {
            $('.shedule-calls').removeClass('active');
        }



    });

    if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) ) {
        $('.dropdown-link').on('click', function (e) {
            e.stopPropagation();
            $(this).closest('li').addClass('open');
        });
    }



    if($('[data-toggle="tooltip"]').length){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top'
        });
    }

    $('.shedule-calls-link').on('click', function () {
        $('.shedule-calls').toggleClass('active');
    });

    if($('.main-slider').length){
        $('.main-slider').slick({
            dots: true,
            prevArrow: '.main-slider-wrap .nav__prev',
            nextArrow: '.main-slider-wrap .nav__next',
            infinite: true,
            autoplay: true,
            lazyLoad: 'ondemand'
        });
    }

    if($('.media-slider').length){
        $('.numb-slides').text($('.media-item').length);
        $('.media-slider').slick({
            dots: false,
            asNavFor: '.photo-info-slider',
            prevArrow: '.media-slider-wrap .nav-prev',
            nextArrow: '.media-slider-wrap .nav-next',
            infinite: false
        });
    }

    $('.media-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        $('.curr-slide').text(nextSlide + 1);
    });

    if($('.photo-info-slider').length){
        $('.photo-info-slider').slick({
            dots: false,
            fade: true,
            arrows: false,
            asNavFor: '.media-slider',
            draggable: false,
            adaptiveHeight: true,
            infinite: false
        });
    }

    if($('.calendar-slider').length){
        $('.calendar-slider').slick({
            dots: false,
            prevArrow: '.calendar .slide-left',
            nextArrow: '.calendar .slide-right',
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        vertical: true,
                        nextArrow: '.more-calendar-items',
                        infinite: true
                    }
                }
            ]
        });
    }


    /*if($('.education-links').length){
        $('.education-links').slick({
            dots: false,
            arrows: false,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            vertical: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        vertical: false,
                        centerMode: true,
                        variableWidth: true,
                        centerPadding: '0px'
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        vertical: false,
                        centerMode: true,
                        variableWidth: true,
                        centerPadding: '0px'
                    }
                },
                {
                    breakpoint: 430,
                    settings: {
                        vertical: false,
                        centerMode: false,
                        infinite: false,
                        variableWidth: false,
                        centerPadding: '40px',
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }*/

    if($('.awards-slider').length){
        $('.awards-slider').slick({
            dots: false,
            prevArrow: '.awards .slide-left',
            nextArrow: '.awards .slide-right',
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true
                    }
                },
                {
                    breakpoint: 421,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
            ]
        });
    }

    if($('.links-slider').length){
        $('.links-slider').slick({
            dots: false,
            prevArrow: '.links .slide-left',
            nextArrow: '.links .slide-right',
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        vertical: true,
                        nextArrow: '.more-links-items',
                        infinite: true
                    }
                }
            ]
        });
    }

    if($('.education-info-slider').length){

        $('.education-info-slider').each(function(){
            $(this).slick({
                dots: false,
                arrows: false,
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            dots: true,
                            infinite: false
                        }
                    }
                ]
            });
        });
    }

    $('.main-nav > ul > li > a').on('click', function () {
        var parent = $(this).closest('li');
        if(parent.hasClass('open')){
            parent = $(this).closest('li').removeClass('open');
        }else{
            $('.main-nav > ul > li').removeClass('open');
            parent.addClass('open');
        }

    });

    $(document).on('click', '.education-change', function (e){
        var parent = $(this).closest('.education-info-item');
        parent.find('.education-dropdown').addClass('active');
        e.preventDefault();
    });

    $(document).on('click', '.education-dropdown-title a', function (e) {
        var parent = $(this).closest('.education-dropdown-item');
        if(!parent.hasClass('active')){
            $('.education-dropdown-item').removeClass('active');
            parent.addClass('active');
            var time = $(this).data('time');
            var type = $(this).data('type');
            var title = $(this).data('title');
            var field_ded_q1 = $(this).data('field_ded_q1');
            var field_ded_q2 = $(this).data('field_ded_q2');
            var field_ded_q3 = $(this).data('field_ded_q3');

            console.log(field_ded_q1);
            console.log(field_ded_q2);
            console.log(field_ded_q3);

            parent.closest('.education-info-item').find('.education-time').text(time);
            parent.closest('.education-info-item').find('.education-type').text(type);
            parent.closest('.education-info-item').find('.education-change').html(title);

            parent.closest('.education-info-item').find('.education-field_ded_q1').html(field_ded_q1);
            parent.closest('.education-info-item').find('.education-field_ded_q2').html(field_ded_q2);
            parent.closest('.education-info-item').find('.education-field_ded_q3').html(field_ded_q3);

            $('.education-dropdown').removeClass('active');
            e.preventDefault();
        }
    });

    /*$('.education-links').on('afterChange', function(event, slick, currentSlide){
        $('.education-tab-item').removeClass('active');
        $('.education-tab-item').eq( $('.education-link.slick-current a').data('slide') - 1).addClass('active');
    });*/

    $('.education-link a').on('click', function(){
        $('.education-info-slider').slick('slickGoTo', 0);
        if(!$(this).closest('.education-link').hasClass('active')){
            $('.education-link').removeClass('active');
            $(this).closest('.education-link').addClass('active');
            $('.education-tab-item').removeClass('active');
            $('.education-tab-item').eq( $(this).data('slide') - 1).addClass('active');

        }

    });

    $('.nav-bars').on('click', function(){
        $('.header-nav').addClass('active');
        $('body').addClass('overflow');
    });

    $('.close-nav').on('click', function(){
        $('.header-nav').removeClass('active');
        $('body').removeClass('overflow');
    });

    $('.search-link').on('click', function(){
        $('.search-block').addClass('active');
        $('body').addClass('overflow');
    });

    $('.close-search').on('click', function(){
        $('.search-block').removeClass('active');
        $('body').removeClass('overflow');
    });

    $('.custom-table-inner').on('scroll', function () {
        if($(this).scrollLeft() + $(this).innerWidth() >= $(this)[0].scrollWidth) {
            $(this).addClass('right-pos');
        } else if($(this).scrollLeft() === 0) {
            $(this).addClass('left-pos');
        } else {
            $(this).removeClass('left-pos right-pos');
        }
    })

    $(document).on('click', '.custom-list-header a', function (e) {
        var parent = $(this).closest('.custom-toggle-item');
        if(!parent.hasClass('disabled')){
            if(parent.hasClass('active')){
                parent.removeClass('active');
                parent.find('.custom-list-content').slideUp();
            }else{
                $('.custom-list-content').slideUp();
                $('.custom-toggle-item').removeClass('active');
                parent.addClass('active');
                parent.find('.custom-list-content').slideDown();
            }
        }

        e.preventDefault();

    });


     $('body').on('click', '.close-modal', function() {
         $.fancybox.close();
         return false;
     });

     $('.thanks-trigger').on('click', function() {
         $.fancybox('#thanks-modal', {
             autoSize: true,
             type: 'inline',
             closeBtn: false,
             padding: 0,
             scrolling: 'visible',
             fixed: true,
             autoCenter: false
         });
     });

    $(document).on('click', '.fb__share-js', function (e) {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '', 'toolbar=0,status=0,width=626,height=436');
        e.preventDefault();
    });

    $(document).on('click', '.vk__share-js', function (e) {
        window.open('http://vkontakte.ru/share.php?url=' + encodeURIComponent(window.location.href), '', 'toolbar=0,status=0,width=626,height=436');
        e.preventDefault();
    });

    $(document).on('click', '.ok__share-js', function (e) {
        var s_title = $('meta[property="og:title"]').attr('content');
        window.open('https://connect.ok.ru/offer?url=' + encodeURIComponent(window.location.href) + '&text=' + s_title, '', 'toolbar=0,status=0,width=626,height=436');
        e.preventDefault();
    });


    $('.modal-close').click(function() {
        $.fancybox.close();
        return false;
    });

    $('.close-info').on('click', function () {
        $.each(placemarks, function (index, element) {
            placemarks[index].options.set('visible', true);
            $('.map-info').removeClass('active');
        });
    });

    $(document).on('click', '.show-map', function (e) {
        $(this).closest('.vacancy-item').find('.custom-map').fadeIn();
        $(this).fadeOut(200);
        e.preventDefault();
    });

    $('.toggle-detail').on('click', function () {
        $(this).closest('.no-table-item').find('.no-table-details').slideToggle();
    });

    $('.close-detail').on('click', function () {
        $(this).closest('.no-table-item').find('.no-table-details').slideUp();
    });

    if($('[data-toggle="tooltip"]').length){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top'
        });
    }

    $('.shedule-calls-link').on('click', function () {
        $('.shedule-calls').toggleClass('active');
    });



    $('.add-calendar-link').on('click', function() {
        $('.add-calendar-block').toggleClass('active');
    });
    $('.shedule-calls-link').on('click', function () {
        $('.shedule-calls').toggleClass('active');
    });

    $('.calendar-filter a').on('click', function() {
        var parent = $(this).closest('li');
        if (!parent.hasClass('active')) {
            if (!filter_processing) {
                $('.calendar-slider').slick('slickUnfilter');
                $('.calendar-filter li').removeClass('active');
                parent.addClass('active');
                filter_processing = true;
                var filter = $(this).data('filter');
                $('.calendar-slider').slick('slickFilter', filter);
                setTimeout(function() {
                    filter_processing = false;
                }, 500);
            }
        }

    });

    $('.radio-item a').on('click', function() {
        var parent = $(this).closest('.radio-item');
        $(parent).find('input').trigger('click');
        if (!parent.hasClass('active')) {
            $('.radio-item').removeClass('active');
            parent.find('input').prop('checked', true);
            parent.addClass('active');
        }
    });

    $('.filter-select select').on('change', function() {
        $(this).closest('.filter-select').prev('ul').find('a[href="#' + $(this).val() + '"]').trigger('click');
    });


    if ($('.checkbox-wrap').length) {
        $('.checkbox-wrap input').styler();
    }

    if ($('.numb-only-field').length) {
        $('.numb-only-field').each(function() {
            $(this).find('input').inputmask('9{1,' + $(this).data('numb-lenght') + '}');
        });

    }

    if ($('.phone-field').length) {
        $('.phone-field input').inputmask("+7 (999) 999 99 99");
    }

    if ($('.serial-field').length) {
        $('.serial-field input').inputmask("9999 999999");
    }

    $('.close-message').on('click', function() {
        $('.custom-input-message').hide();
    });


    if ($('.date-field').length) {
        $('.date-field').each(function() {
            $(this).find('input').datetimepicker({
                locale: 'ru',
                format: 'DD.MM.YYYY',
                icons: {
                    previous: 'icon-left',
                    next: 'icon-right'
                }
            });
        });

    }

    $('.toggle-calendar').on('click', function() {
        $(this).closest('.date-field').find('input').focus();
    });

    $('.redirector').on('change', function () {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    if ($('.select-wrap').length) {
        $('.select-wrap').each(function() {
            var _this = $(this);
            _this.find('select').styler({
                selectSearch: _this.hasClass('search-select-wrap'),
                selectSearchLimit: 5,
                selectSearchPlaceholder: _this.data('search-placeholder'),
                onSelectOpened: function() {
                    $('.jq-selectbox ul').addClass('scrollbar-dynamic')
                    $('.jq-selectbox ul').scrollbar();
                    if (_this.find('option[value="select_or_other"]').length) {
                        var fixed_li = $('<div/>').addClass('fixed-li').text('Р”СЂСѓРіРѕРµ');
                        if (_this.find('li:last-child').hasClass('selected')) {
                            fixed_li.addClass('selected');
                        }
                        _this.find('.jq-selectbox__dropdown').append(fixed_li);
                    }


                },
                onSelectClosed: function() {
                    if (_this.find('option[value="select_or_other"]').length) {
                        $('.fixed-li').remove();
                    }
                }
            });
        });

        jQuery('body').on('click', '.fixed-li', function () {
            jQuery(this).closest('.select-wrap').find('li:last-child').trigger('click');
            jQuery(this).closest('.select-wrap').find('select').trigger('refresh');

        });

    }

    $(document).on('click', '.next__step-js', function (e){
       $('.step__tab').removeClass('active');
       $($(this).attr('href')).addClass('active');
       if($(this).attr('href') === '#step-5'){
           $('.steps__bl').addClass('steps__bl-final');
       }else{
           $('.steps__bl').removeClass('steps__bl-final');
       }

       if($(this).attr('data-param') !== undefined){
           var param = $(this).attr('data-param');
           var val = $(this).attr('data-value');
           switch(param){
               case 'nationality':
                   switch(val){
                       case 'rf':
                           $('#step-2 .btn__custom.next__step-js').attr('href', '#step-3');
                           $('.budget-item').removeClass('disabled');
                           $('#step-4 .back-step .next__step-js').attr('href', '#step-3');
                           $('#step-4 .step-current').text(4);
                           $('.show__doc-modal').attr('href', '#doc-modal-rf');
                           $('.step-count').text('4');
                           break;
                       case 'other':
                           $('#step-2 .btn__custom.next__step-js').attr('href', '#step-4-2');
                           $('#step-4 .back-step .next__step-js').attr('href', '#step-2');
                           $('.budget-item').addClass('disabled');
                           $('.step-count').text('3');
                           $('#step-4 .step-current').text(3);
                           $('.show__doc-modal').attr('href', '#doc-modal-other');
                           break;
                   }
                   break;
               case 'region':
                   switch(val){
                       case 'moscow':
                           $('.budget-item').removeClass('disabled');
                           $('.budget-item a').attr('href', 'https://www.mos.ru/pgu/ru/services/procedure/0/0/7700000010000186812/');
                           $('.budget-item a').attr('target', '_blank');
                           $('.budget-item a').removeClass('next__step-js');
                           break;
                       case 'mo':
                           $('.budget-item').removeClass('disabled');
                           $('.budget-item a').attr('href', '#step-5');
                           $('.budget-item a').attr('target', '_self');
                           $('.budget-item a').addClass('next__step-js');
                           break;
                       case 'other':
                           $('.budget-item').addClass('disabled');
                           $('.budget-item a').attr('href', '#step-5');
                           $('.budget-item a').attr('target', '_self');
                           $('.budget-item a').addClass('next__step-js');
                           break;
                   }
                   break;
           }
       }


       e.preventDefault();
    });

    $(document).on('click', '.prog__item-header', function (e){
        if (window.matchMedia("(max-width: 1023px)").matches) {
            var parent = $(this).closest('.prog__item');
            if(parent.hasClass('active')){
                parent.removeClass('active');
                parent.find('.prog__item-ct').slideUp();
            }else{
                $('.prog__item').removeClass('active');
                $('.prog__item-ct').slideUp();
                parent.addClass('active');
                parent.find('.prog__item-ct').slideDown();
            }
        }

        e.preventDefault();
    });

    $(document).on('click', '.action__hint-hide', function (e){
        $('.action__hint-tab').removeClass('active');
        $($(this).attr('href')).addClass('active');
       e.preventDefault();
    });

    $(document).on('click', '.modal-close-js', function (e) {
        $.fancybox.close(true);
        e.preventDefault();
    });

    $(document).on('click', '.load__faq-js', function (e){
        $('.faq-item').addClass('active');
        $(this).closest('.pager').addClass('hidden');
        e.preventDefault();
    });

    $(document).on('click', '[data-tog="tab"]', function (e){
       let parent = $(this).closest('li');
       let box = $(this).closest('.tab-list');
       let tab_ct = $($(this).attr('href')).closest('.tab-content');

       if(!parent.hasClass('active')){
           box.find('li').removeClass('active');
           tab_ct.find('.tab-pane').removeClass('active');
           $($(this).attr('href')).addClass('active');
           parent.addClass('active');
       }
       e.preventDefault();
    });

    $(document).on('click', '.search-field button', function (e){
        var search = $(this).closest('form').find('.search-field input').val();
        window.location.href = '/search?s=' + search;
        e.preventDefault();
    });

    autoHeight();
});

$(window).resize(function(){
    var w_w = $(window).width();
    nav_arrow_pos();
    max_modal_content();

    if($('.custom-modal-content').length){
        if(!$('.custom-object-modal').hasClass('awards-theme')){
            $('.custom-modal-content').scrollbar();

        }

    }
    if($('.custom-object-modal').hasClass('awards-theme')){
        $('.award-img-wrap').css('width', $('.custom-object-modal').outerWidth() + "px");

    }

    if (scroll_effect != null) {
        scroll_effect.animate('.parallax-bg',{ duration: 200, delay: 0, property:'top', start:0, end: -($('.parallax-bg').outerHeight() - $('.header-nav').outerHeight()) });
    }

    if($('#map').length){
        if($(window).width() >= 1024){
            map[0].panTo(
                [55.747486, 37.658432], {
                    flying: true
                }
            )
        }
    }

    autoHeight();
});

$(window).scroll(function(e){
    var y = $(window).scrollTop();
    if(y > 0){
        $('.wrapper').addClass('scrolled');
    }else{
        $('.wrapper').removeClass('scrolled');
    }

    if(y > $('.content').offset().top - $('.header-nav').outerHeight()){
        $('.header-nav').addClass('fixed');
        $('.parallax-bg').addClass('fixed');
    }else{
        $('.parallax-bg').removeClass('fixed');
        $('.header-nav').removeClass('fixed');
    }

    if(y > 1000){
        $('.up-scroll').addClass('active');
    }else{
        $('.up-scroll').removeClass('active');
    }
});

$(window).on('load', function(){
    var w_h = $(window).height();

    if($('.custom-map').length){
        ymaps.ready(function () {
            $('.custom-map').each(function (index, element) {
                $(this).find('.map').attr('index', index);
                init($(this).find('.map').attr('id'), $(this).find('.map').data('type'), $(this).find('.map').data('lt'), $(this).find('.map').data('lg'), index);
            });
        });
    }

    nav_arrow_pos();
    max_modal_content();
    autoHeight();
});

function init(id, type, lt, lg, index){

    var coord = [lt, lg];
    map[index] = new ymaps.Map(id, {
        center: coord,
        zoom: 17,
        type:'yandex#publicMap',
        controls: []
    });

    if( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) ) {
        map[index].behaviors.disable('multiTouch');
        map[index].behaviors.disable('drag');
    }

    if(type === 'vacancy-type'){
        placemarks[index] = new ymaps.Placemark(coord, {
            iconCaption: ''
        }, {
            preset: 'islands#redDotIconWithCaption'
        });
    }else{
        placemarks[index] = new ymaps.Placemark(coord, {}, {
            iconLayout: 'default#image',
            iconImageHref: 'images/elements/marker.svg',
            /*iconImageHref: 'images/elements/marker.svg',*/
            iconImageSize: [52, 78],
            iconImageOffset: [-26, -78]
        });
    }


    if(type !== 'front' && type !== 'vacancy-type'){
        placemarks[index].events.add('click', function (e) {
            e.get('target').options.set('visible', false);
            $('.tab-pane.active').find('.map-info').addClass('active');

        });
    }


    map[index].behaviors.disable(['scrollZoom']);
    map[index].geoObjects.add(placemarks[index]);

    if(type === 'front'){
        if($(window).width() < 1024 && $(window).width() > 767){
           /* map[index].panTo(
                [55.74651377, 37.658432], {
                    flying: true
                }
            )*/
        }
    }
}

function nav_arrow_pos(){
    if($('.arrow').length){
        $('.arrow').each(function(){
            var parent = $(this).closest('.main-nav li');
            $(this).css('left', parent.position().left + parent.outerWidth()/2 + "px")
        });
    }
}

function max_modal_content() {
    if($('.custom-modal-block').length){
        var w_h = $(window).outerHeight();
        var w_w = $(window).width();

        if(w_w < 768){
            $('.custom-modal-block').css('height', w_h - 100 + 'px');
        }else{
            $('.custom-modal-block').css('max-height', w_h - 100 + 'px');

        }

        $('.custom-modal-block').css('padding-top', $('.fancybox-inner .custom-modal-header').outerHeight() + "px");
        $('#object-modal').find('.custom-modal-content').css('height', w_h - 100 - $('.fancybox-inner .custom-modal-header').outerHeight()  + 'px');
        $('#info-modal').find('.custom-modal-content').css('max-height', w_h - 100 - $('.fancybox-inner .custom-modal-header').outerHeight()  + 'px');
    }
}

function hasTouch() {
    return (
        'ontouchstart' in document.documentElement ||
        navigator.maxTouchPoints > 0 ||
        navigator.msMaxTouchPoints > 0
    );
}

function autoHeight(){
    if($('.ads__item-title').length){
        $('.ads__item-title').matchHeight();
    }

    if($('.news__item-title').length){
        $('.news__item-title').matchHeight();
    }


    if ($('.structure-table').length) {
        $('.structure-table td').matchHeight({
            byRow: true
        });
    }

    if ($('.news-page-list').length) {
        $('.news-page-list .news-item-title').matchHeight({
            byRow: true
        });
    }

    if ($('.advert-list').length) {
        $('.advert-list .calendar-item-block').matchHeight({
            byRow: true
        });
    }

    if ($('.row-value-2').length) {
        $('.row-value-2').matchHeight({
            byRow: false
        });
    }

    if ($('.row-value-4').length) {
        $('.row-value-4').matchHeight({
            byRow: false
        });
    }

    if ($('.net-link-block').length) {
        $('.net-link-block').matchHeight({
            byRow: false
        });
    }

    if($('.icon__ct-item-content').length){
        $('.icon__ct-item-content').matchHeight();
    }

    if($('.prog__item-title').length){
        $('.prog__item-title').matchHeight();
    }

    if($('.equal__value').length){
        $('.equal__value').matchHeight();
    }
}
