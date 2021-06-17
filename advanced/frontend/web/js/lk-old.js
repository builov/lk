var version;
var font;
var images;

$(document).ready(function(){
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

    nav_arrow_pos();
    max_modal_content();

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

    if($('[data-toggle="tooltip"]').length){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top'
        });
    }

     $('body').on('click', '.close-modal', function() {
         $.fancybox.close();
         return false;
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
                format: 'DD-MM-YYYY',
                /*debug: true,*/
                icons: {
                    previous: 'icon-left',
                    next: 'icon-right'
                }
            });
        });

    }

    $('.toggle-calendar, .show-calendat-js').on('click', function() {
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


    $(document).on('change', '.field-prog select', function () {
         $('.field-st-form input').attr('disabled', false);
         setStepProgress(5);
    });

    $(document).on('change', '.form__step input, .form__step select, .form__step textarea', function () {
       validateStep($(this).closest('.form__step').attr('data-step'));
    });

    autoHeight();
});

$(window).resize(function(){
    var w_w = $(window).width();
    nav_arrow_pos();
    max_modal_content();

    if($('.news__item-title').length){
        $('.news__item-title').matchHeight();
    }

    if($('.imp__sl').length){
        $('.imp__sl .item__title').matchHeight();
        $('.imp__sl .item__descr').matchHeight();
    }
});

$(window).scroll(function(e){
    var y = $(window).scrollTop();
    if(y > 0){
        $('.wrapper').addClass('scrolled');
    }else{
        $('.wrapper').removeClass('scrolled');
    }

    if(y > 1000){
        $('.up-scroll').addClass('active');
    }else{
        $('.up-scroll').removeClass('active');
    }
});

$(window).on('load', function(){
    var w_h = $(window).height();

    nav_arrow_pos();
    max_modal_content();
    autoHeight();
});

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
}

function setStepProgress(value){
    $('.ct__progress-bar span').css('width', value + '%');
}

function validateStep(step){
    $('.next-step-js').attr('disabled', true);
    switchAction('action-next');
    hideToggleFields('region-group,mess-budg,educ-group,mess-region-1,mess-region-2');
    switch(parseInt(step)){
        case 1://Шаг 1
            var study_form = $('.field-st-form input:checked').val();
            switch(parseInt(study_form)){
                case 1://Договор
                    $('.next-step-js').attr('disabled', false);
                    setStepProgress(31);
                    break;
                case 2://Бюджет
                    setStepProgress(12);
                    showToggleFields('region-group,mess-budg');
                    var region = $('.field-region input:checked').val();
                    var educ = $('.field-educ select').val();
                    switch(parseInt(region)){
                        case 1://Москва
                            showToggleFields('educ-group');
                            switch(parseInt(educ)){
                                case 1://Среднее
                                    $('.next-step-js').attr('disabled', false);
                                    break;
                                case 2://Высшее
                                    showToggleFields('mess-region-1');
                                    break;
                            }
                            break;
                        case 2://МО
                            showToggleFields('educ-group');
                            switch(parseInt(educ)){
                                case 1://Среднее
                                    $('.next-step-js').attr('disabled', false);
                                    break;
                                case 2://Высшее
                                    showToggleFields('mess-region-1');
                                    break;
                            }
                            break;
                        case 3: //Другой регион
                            showToggleFields('mess-region-2');
                            switchAction('action-dog');
                            break;
                    }
                    break;
            }
            break;
    }
}

function showToggleFields(fields) {
    $.each(fields.split(','), function (key, val) {
        $('#' + val).addClass('active');
    });
}

function hideToggleFields(fields) {
    $.each(fields.split(','), function (key, val) {
        $('#' + val).removeClass('active');
    });
}

function switchAction(action) {
    var parent = $('#' + action).closest('.form__actions-btn-list');
    $('.form__actions-btn-item', parent).removeClass('active');
    $('#' + action).addClass('active');
}