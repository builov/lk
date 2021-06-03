$(document).ready(function(){

    // $('a#modal-link').fancybox({
    //     src: '/site/request-password-reset',
    //     type: 'ajax',
    //     afterShow: function(instance, current) {
    //         console.log($(instance.$trigger));
    //         // $('form.form-recovery').attr('action', this.src);
    //     }
    // });


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

    $('.scroll').on('click', function(e){
        var anchor = $(this).data('scroll');
        var anchor_link = $(anchor).offset().top;
        var offset = $(this).data('offset');
        var indent = 0;
        $('html, body').stop().animate({
            scrollTop : anchor_link - indent +  "px"
        }, 1500, 'easeInOutExpo');
        e.preventDefault();
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
            $(this).find('input').inputmask({ mask: "9", repeat: $(this).data('numb-length'), greedy: false});
        });
    }

    if ($('.phone-field').length) {
        $('.phone-field input').inputmask("+7 (999) 999 99 99");
    }

    if($('.snils-field').length){
        $('.snils-field input').inputmask("999-999-999 99");
    }

    if ($('.serial-field').length) {
        $('.serial-field input').inputmask("9999 999999");
    }

    $('.close-message').on('click', function() {
        $('.custom-input-message').hide();
    });

    if ($('.date-field').length) {
        $('.date-field').each(function (){
            let _this = $(this);
            let format = 'dd.mm.yyyy';
            let placeholder = 'дд.мм.гггг';
            if(_this.hasClass('date-field-years')){
                format = 'yyyy';
                placeholder = 'ГГГГ';
            }
            _this.find('input').inputmask({
                showMaskOnHover: false,
                alias: "datetime",
                separator: ".",
                inputFormat: format,
                placeholder: placeholder
            });
        });
    }

    if($('.pass-code').length){
        $('.pass-code input').inputmask("999-999");
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

    $(document).on('click', '[data-name="same"] input', function () {
        var same = $('[data-name="same"] input:checked').length;
        if(same === 0){
            $('[data-name="d-address-2"], [data-name="d-house-2"]').addClass('req-field');
        }else{
            $('[data-name="d-address-2"], [data-name="d-house-2"]').removeClass('req-field');
        }

        validateStep($(this).closest('.form__step').attr('data-step'));
    });

    $(document).on('click', '.form__step [type="checkbox"]', function () {
        validateStep($(this).closest('.form__step').attr('data-step'));
    });

    $(document).on('click', '.next-step-js', function (e) {
        var step = parseInt($('.form__step.active').attr('data-step'));
        $('.ct__progress-item').eq(step).addClass('active');
        $('.ct__progress-item').eq(step - 1).addClass('passed').removeClass('active');
        $('.form__step').removeClass('active');
        $('.form__step').eq(step).addClass('active');
        $('.back-js').addClass('active');
        switch(step){
            case 1:
                setStepProgress(37);
                break;
            case 2:
                setStepProgress(63);
                break;
            case 3:
                setStepProgress(100);
                switchAction('action-submit');
                break;
            case 4:
                break;
        }
        $('.ct__progress-steps span').text(step + 1);
        $('.next-step-js').attr('disabled', true);
        if(window.matchMedia("(max-width: 767px)").matches){
            $('html, body').stop().animate({
                scrollTop : 0 + "px"
            }, 400);
        }
        e.preventDefault();
    });

    $(document).on('click', '.back-js', function (e) {
        var step = parseInt($('.form__step.active').attr('data-step'));
        $('.ct__progress-item').eq(step - 1).removeClass('active');
        $('.ct__progress-item').eq(step - 2).removeClass('passed').addClass('active');
        $('.form__step').removeClass('active');
        $('.form__step').eq(step - 2).addClass('active');
        if(step === 2){
            $('.back-js').removeClass('active');
        }
        switch(step - 1){
            case 1:
                setStepProgress(0);
                break;
            case 2:
                setStepProgress(37);
                break;
            case 3:
                setStepProgress(63);
                switchAction('action-submit');
                break;
        }
        $('.ct__progress-steps span').text(step - 1);
        $('.next-step-js').attr('disabled', false);
        if(window.matchMedia("(max-width: 767px)").matches){
            $('html, body').stop().animate({
                scrollTop : 0 + "px"
            }, 400);
        }
        e.preventDefault();
    });

    // $('form.form-reg').submit(function () {
    //     $('.reg-state').removeClass('active');
    //     $('.reg__result').addClass('active');
    //    return false;
    // });

    $('form.form-recovery').submit(function () {
        $('#recovery-modal .fade-state').removeClass('active');
        $('#recovery-result').addClass('active');
        return false;
    });

    $(document).on('click', '.modal-close-js', function (e) {
        $.fancybox.close(true);
        e.preventDefault();
    });

    $(document).on('click', '.tabs__lk-toggle a', function (e){
        var parent = $(this).closest('.tabs__lk-toggle');
        if(!parent.hasClass('active')){
            $('.tabs__lk-toggle').removeClass('active');
            $('.tabs__lk-pane').removeClass('active');
            parent.addClass('active');
            $($(this).attr('href')).addClass('active');
        }
        e.preventDefault();
    });

    $(document).on('keyup', '.req-field .input', function (e){
        validateField($(this).closest('.req-field').attr('data-name'));
    });

    $(document).on('change', '.select-wrap .input', function (e){
        validateField($(this).closest('.req-field').attr('data-name'));
    });

    if($('[data-name="d-address-1"]').length){
        $('[data-name="d-address-1"] input').blur(function (){
            var _this = $(this);
            setTimeout(function (){
                var box = _this.closest('.form__field').find('.ac__box');
                box.removeClass('active');
            }, 400);
        });
        $('.fias-field input').keyup(function() {
            var box = $(this).closest('.form__field').find('.ac__box');
            var dInput = this.value;
            var type = 'street';
            var mode = 1;
            if(dInput.length > 0){
                var params = {
                    query: dInput,
                    limit: 14,
                    withParent: false
                }

                if($(this).closest('.form__group').attr('id') === 'main-address'){
                    switch(parseInt($('[data-name="d-region"] select').val())){
                        case 1:
                            params['parentType'] = 'city';
                            params['parentId'] = '7700000000000';
                            params['type'] = type;
                            break;
                        case 2:
                            type = 'city';
                            params['parentType'] = 'region';
                            params['parentId'] = '5000000000000';
                            params['oneString'] = true;
                            params['type'] = type;
                            mode = 2;
                            break;
                        case 3:
                            params['oneString'] = true;
                            params['withParent'] = true;
                            mode = 3;
                            break;
                    }
                }else{
                    params['oneString'] = true;
                    params['withParent'] = true;
                    mode = 3;
                }

                $.fias.api(params, function(results){
                    if(results.length > 1){
                        box.addClass('active');
                        box.find('.ac__list').html('');
                        $.each(results, function (key, val){
                            if(key !== 0){
                                switch(mode){
                                    case 3:
                                        var res_name = '';
                                        $.each(val.parents, function (par_ind, par_item){
                                           if(par_ind === 0){
                                               res_name += par_item.typeShort + ' ' + par_item.name;
                                           }else{
                                               res_name += ', ' + par_item.typeShort + ' ' + par_item.name;
                                           }
                                        });
                                        res_name += ', ' + val.typeShort + ' ' + val.name;
                                        box.find('.ac__list').append('<div class="ac__item" data-value="' + res_name + '" data-zip="' + val.zip + '" data-id="' + val.id + '">' + res_name + '</div>');
                                        break;
                                    default:
                                        box.find('.ac__list').append('<div class="ac__item" data-value="' + val.typeShort + ' ' + val.name + '" data-zip="' + val.zip + '" data-id="' + val.id + '">' + val.typeShort + ' ' + val.name + '</div>');
                                        break;
                                }

                            }
                        });
                    }else{
                        box.removeClass('active');
                        box.find('.ac__list').html('');
                    }
                });
            }

        });
    }

    if($('.ac__box-bl').length){
        $('.ac__box-bl').scrollbar();
    }

    $(document).on('click', '.ac__item', function (e){
        var field = $(this).closest('.form__field');
        var input = field.find('.input');
        var box = $(this).closest('.form__field').find('.ac__box');
        input.val($(this).attr('data-value'));
        field.find('.field-fias-id input').val($(this).attr('data-id'));
        box.removeClass('active');
        e.preventDefault();
    });

    if($('[data-name="d-nationality"]').length){
        $(document).on('change', '[data-name="d-nationality"] select', function (){
           if(parseInt($(this).val()) === 1){
               $('[data-name="d-passport-serial"]').addClass('numb-only-field');
               $('[data-name="d-passport-serial"]').attr('data-numb-length', 4);
               $('[data-name="d-passport-serial"] input').inputmask({ mask: "9", repeat: $('[data-name="d-passport-serial"]').data('numb-length'), greedy: false});

               $('[data-name="d-passport-numb"]').attr('data-numb-length', 6);
               $('[data-name="d-passport-numb"] input').inputmask({ mask: "9", repeat: $('[data-name="d-passport-numb"]').data('numb-length'), greedy: false});
           }else{
               $('[data-name="d-passport-serial"]').removeClass('numb-only-field');
               $('[data-name="d-passport-serial"] input').inputmask('remove');

               $('[data-name="d-passport-numb"]').attr('data-numb-length', 25);
               $('[data-name="d-passport-numb"] input').inputmask({ mask: "9", repeat: $('[data-name="d-passport-numb"]').data('numb-length'), greedy: false});
           }
        });
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

    if(y > 1000){
        $('.up-scroll').addClass('active');
    }else{
        $('.up-scroll').removeClass('active');
    }
});

$(window).on('load', function(){
    var w_h = $(window).height();
    autoHeight();
});

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

function validateField(field){
    var input = $('[data-name="' + field + '"] .input:not(div)');
    var item = input.closest('.form__field');
    var val = input.val();
    var form = input.closest('form');
    var error = input.closest('.form__field').find('.error__message');

    item.removeClass('has-error');

    if(val.length === 0){
        item.addClass('has-error');
        error.text('Обязательное поле');
    }else{
        item.removeClass('has-error');
        switch(field){
            case 'd-surname':
                if(hasNumber(val)){
                    item.addClass('has-error');
                    error.text('Поле не должно содержать цифры');
                }
                if(val.length < 2){
                    item.addClass('has-error');
                    error.text('Фамилия должна быть больше 2 символов');
                }
                break;
            case 'd-name':
                if(hasNumber(val)){
                    item.addClass('has-error');
                    error.text('Поле не должно содержать цифры');
                }
                if(val.length < 2){
                    item.addClass('has-error');
                    error.text('Имя должно быть больше 2 символов');
                }
                break;
            case 'd-birthday':
                var date_parts = val.match(/(\d{2}).(\d{2}).(\d{4})/);
                var year_max = new Date().getFullYear();
                if(calculateAge(new Date(date_parts[2] + '/' + date_parts[1] + '/' + date_parts[3])) <= 14){
                    item.addClass('has-error');
                    error.text('Ваш возраст должен быть мин. 14 лет');
                }
                if(year_max < parseInt(date_parts[3])){
                    item.addClass('has-error');
                    error.text('Введите корректную дату рождения');
                }
                break;
            case 'd-snils':
                var snils = val.replace(/-/g, '');
                snils = snils.replace(/_/g, '');
                snils = snils.replace(' ', '');
                if(snils.length !== 11){
                    item.addClass('has-error');
                    error.text('Введите корректное значение');
                }
                break;
            case 'd-email':
                var regEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!regEmail.test(val)){
                    item.addClass('has-error');
                    error.text('Введите корректный email');
                }
                break;
            case 'd-password':
                if(val.length < 6){
                    item.addClass('has-error');
                    error.text('Пароль должен содержать минимум 6 символов');
                }
                break;
            case 'd-inst':
                if(val.length < 6){
                    item.addClass('has-error');
                    error.text('Введите минимум 6 символов');
                }
                break;
            case 'd-inst-year':
                var year_max = new Date().getFullYear();
                var year_min = 1930;
                if(year_max < parseInt(val) || parseInt(val) < year_min){
                    item.addClass('has-error');
                    error.text('Введите корректный год');
                }
                break;
            case 'd-inst-doc':
                if(val.length < 5){
                    item.addClass('has-error');
                    error.text('Введите минимум 5 символов');
                }
                break;
            case 'd-passport-serial':
                if(val.length < 2){
                    item.addClass('has-error');
                    error.html('Введите минимум 2&nbsp;символа');
                }
                break;
            case 'd-passport-numb':
                if(val.length < 4){
                    item.addClass('has-error');
                    error.text('Введите минимум 4 символа');
                }
                break;
            case 'd-passport-code':
                var code = val.replace(/-/g, '');
                code = code.replace(/_/g, '');
                code = code.replace(' ', '');
                if(code.length !== 6){
                    item.addClass('has-error');
                    error.text('Введите корректное значение');
                }
                break;
            case 'd-passport-inst':
                if(val.length < 6){
                    item.addClass('has-error');
                    error.text('Введите минимум 6 символов');
                }
                break;
            case 'd-passport-date':
                var date_parts = val.match(/(\d{2}).(\d{2}).(\d{4})/);
                var year_max = new Date().getFullYear();
                var year_min = 1930;
                if(year_max < parseInt(date_parts[3]) || parseInt(date_parts[3]) < year_min){
                    item.addClass('has-error');
                    error.text('Введите корректную дату');
                }
                break;
            case 'd-phone':
                var phone = val.replace('(', '');
                phone = phone.replace(')', '');
                phone = phone.replace(/_/g, '');
                phone = phone.replace(/ /g, '');
                if(phone.length !== 12){
                    item.addClass('has-error');
                    error.text('Введите корректное значение');
                }
                break;
            case 'd-region':
                switch(parseInt(val)){
                    case 1://Москва
                        $('.region-label').text('Улица');
                        break;
                    case 2://МО
                        $('.region-label').text('Город, улица');
                        break;
                    case 3://Другое
                        $('.region-label').text('Регион, город, улица');
                        break;
                }
                $('[data-step="4"] .form__item-disabled').removeClass('form__item-disabled');
                break;
        }
    }

    if(form.hasClass('form-reg')){
        validateStep(input.closest('.form__step').attr('data-step'));
    }
    if(form.hasClass('form-login')){
        validateLogin();
    }

}

function hasNumber(str){
    var hasNumber = /\d/;
    return hasNumber.test(str);
}

function validateStep(step){
    $('.next-step-js').attr('disabled', true);
    $('.submit-js').attr('disabled', true);
    var enabled = true;
    if(parseInt(step) === 4){
        switchAction('action-submit');
    }else{
        switchAction('action-next');
    }

    hideToggleFields('additional-address');

    $('.form__step[data-step="' + step + '"]').find('.req-field .input:not(div)').each(function (){
        if($(this).val().length === 0 || $(this).closest('.form__field').hasClass('has-error')){
            enabled = false;
        }
    });

    switch(parseInt(step)){
        case 1://Шаг 1
            if(!enabled){
                setStepProgress(0);
            }else{
                $('.next-step-js').attr('disabled', false);
                setStepProgress(30);
            }
            break;
        case 2://Шаг 2
            if(!enabled){
                setStepProgress(33.3333);
            }else{
                $('.next-step-js').attr('disabled', false);
                setStepProgress(59);
            }
            break;
        case 3://Шаг 3
            if(!enabled){
                setStepProgress(67);
            }else{
                $('.next-step-js').attr('disabled', false);
                setStepProgress(95);
            }
            break;
        case 4://Шаг 4
            var same = $('[data-name="same"] input:checked').length;
            if(same === 0){
                showToggleFields('additional-address');
            }

            var agree = $('[data-name="agree"] input:checked').length;

            if(enabled && agree !== 0){
                $('.submit-js').attr('disabled', false);
            }

            break;
    }
}

function validateLogin(){
    var enabled = true;
    $('.form-login').find('.req-field .input').each(function (){
        if($(this).val().length === 0 || $(this).closest('.form__item').hasClass('has-error')){
            enabled = false;
        }
    });
    if(!enabled){
        $('.form-login button').attr('disabled', true);
    }else{
        $('.form-login button').attr('disabled', false);
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

function calculateAge(birthday) {
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}
