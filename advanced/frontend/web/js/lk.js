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
        if($(this).closest('.ct__box-profile')){
            var form = $(this).closest('.toggle__box');
            validateProfile(form);
        }else{
            validateStep($(this).closest('.form__step').attr('data-step'));
        }

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
            var region_name = 'd-region-1';
            if($(this).closest('.form__group').attr('id') === 'additional-address'){
                region_name = 'd-region-2';
            }
            if(dInput.length > 0){
                var params = {
                    query: dInput,
                    limit: 14,
                    withParent: false
                }

                if($(this).closest('.form__group').attr('id') === 'main-address'){
                    switch(parseInt($('[data-name="' + region_name + '"] select').val())){
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
        var group = $(this).closest('.form__group');
        group.find('.zip-field input').val($(this).attr('data-zip'));
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

    $(document).on('click', '.toggle__instr-js', function (e){
        $('.sc__instruction .sc__box-bl.fadeIn').addClass('active');
        $(this).closest('.actions__wrap').removeClass('active');
        $('.close__box').addClass('active');
        autoHeight();
        e.preventDefault();
    });

    $(document).on('click', '.close__box', function (e){
        $('.sc__instruction .sc__box-bl.fadeIn').removeClass('active');
        $('.toggle__instr-js').closest('.actions__wrap').addClass('active');
        $('.close__box').removeClass('active');
        e.preventDefault();
    });

    $(document).on('click', '.toggle__box-header', function (e){
        let parent = $(this).closest('.toggle__box');
        if(parent.hasClass('active')){
            parent.removeClass('active');
            parent.find('.toggle__box-content').slideUp();
        }else{
            $('.toggle__box').removeClass('active');
            $('.toggle__box-content').slideUp();
            parent.addClass('active');
            parent.find('.toggle__box-content').slideDown();
        }
        e.preventDefault();
    });

    // if($('.dz-field').length){
    //     $('.dz-field').each(function (){
    //        let _this = $(this);
    //        new Dropzone('#' + _this.attr('id'), {
    //             url: '/profile/upload-file',
    //             maxFiles: 10,
    //             uploadMultiple: true,
    //             thumbnailWidth: 170,
    //             thumbnailHeight: 130,
    //             createImageThumbnails: true,
    //             params: {
    //                 'action': 'file_upload'
    //             },
    //             init: function () {
    //                 this.on("processing", function (file) {
    //                     //for local testing only, comment while integrate with backend
    //                     validateFiles();
    //                 });
    //
    //                 this.on("success", function (file, response) {
    //                     //for local testing only, comment while integrate with backend
    //                     validateFiles();
    //                 });
    //
    //                 this.on("error", function (file, error, xhr) {
    //
    //                 });
    //
    //                 this.on("removedfile", function (file, error, xhr) {
    //                     if(!_this.find('.dz-preview').length){
    //                         _this.find('.dz-add').remove();
    //                     }
    //                     validateFiles();
    //                 });
    //
    //                 this.on("addedfile", function (){
    //                     if(!_this.find('.dz-add').length){
    //                         _this.append('<div class="dz-add">\n' +
    //                             '                                                        <div class="icon__add">\n' +
    //                             '                                                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
    //                             '                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18 3C18.5523 3 19 3.44772 19 4V17H32C32.5523 17 33 17.4477 33 18C33 18.5523 32.5523 19 32 19H19V32C19 32.5523 18.5523 33 18 33C17.4477 33 17 32.5523 17 32V19H4C3.44772 19 3 18.5523 3 18C3 17.4477 3.44772 17 4 17H17V4C17 3.44772 17.4477 3 18 3Z" fill="#245FA2"/>\n' +
    //                             '                                                            </svg>\n' +
    //                             '                                                        </div>\n' +
    //                             '                                                    </div>');
    //                     }
    //                 });
    //             },
    //             previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n" +
    //                 "                                                        <div class=\"dz__img\">\n" +
    //                 "                                                            <img data-dz-thumbnail/>\n" +
    //                 "                                                        </div>\n" +
    //                 "                                                        <div class=\"dz-details-rows\">\n" +
    //                 "                                                            <div class=\"dz-details-row dz-details-row-1 d-flex align-items-start justify-content-between\">\n" +
    //                 "                                                                <div class=\"dz-filename\"><span data-dz-name></span></div>\n" +
    //                 "                                                                <div class=\"dz-remove\" data-dz-remove>Удалить</div>\n" +
    //                 "                                                            </div>\n" +
    //                 "                                                            <div class=\"dz-details-row d-flex align-items-start justify-content-between\">\n" +
    //                 "                                                                <div class=\"dz-date\"></div>\n" +
    //                 "                                                                <div class=\"dz-size\" data-dz-size></div>\n" +
    //                 "                                                            </div>\n" +
    //                 "                                                        </div>\n" +
    //                 "                                                        <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n" +
    //                 "                                                        <div class=\"dz-success-mark\"><span>✔</span></div>\n" +
    //                 "                                                        <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n" +
    //                 "                                                    </div>"
    //         });
    //     });
    // }

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

    $(document).on('click', '.toggle__mb-content', function (e){
        if(window.matchMedia("(max-width: 767px)").matches){
            var parent = $(this).attr('data-parent');
            if($(this).hasClass('active')){
                $('#' + parent).slideUp();
                $(this).removeClass('active');
            }else{
                $('.mb-content').slideUp();
                $('.toggle__mb-content').removeClass('active');
                $('#' + parent).slideDown();
                $(this).addClass('active');
            }
        }

        e.preventDefault();
    });

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

$(window).resize(function (){
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

    if($('.icon__ct-item-text').length){
        $('.icon__ct-item-text').matchHeight();
    }
}

function setStepProgress(value){
    $('.ct__progress-bar span').css('width', value + '%');
}

function validateFiles(){
    if($('.dz-field .dz-preview').length > 1){
        $('.orders__item-start').find('button').attr('disabled', false);
    }else{
        $('.orders__item-start').find('button').attr('disabled', true);
    }
}

function validateField(field){
    var input = $('[data-name="' + field + '"] .input:not(div)');
    var item = input.closest('.form__field');
    var val = input.val();
    var form = input.closest('form');
    var error = input.closest('.form__field').find('.error__message');

    if(input.closest('.ct__box-profile')){
        form = input.closest('.toggle__box');
    }

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
            case 'd-index-1':
                if(val.length < 6){
                    item.addClass('has-error');
                    error.text('Введите 6 цифр');
                }
                break;
            case 'd-index-2':
                if(val.length < 6){
                    item.addClass('has-error');
                    error.text('Введите 6 цифр');
                }
                break;
            case 'd-region-1':
                switch(parseInt(val)){
                    case 1://Москва
                        $('#main-address .region-label').text('Улица');
                        break;
                    case 2://МО
                        $('#main-address .region-label').text('Город, улица');
                        break;
                    case 3://Другое
                        $('#main-address .region-label').text('Регион, город, улица');
                        break;
                }
                $('[data-step="4"] #main-address .form__item-disabled').removeClass('form__item-disabled');
                break;
            case 'd-region-2':
                switch(parseInt(val)){
                    case 1://Москва
                        $('#additional-address .region-label').text('Улица');
                        break;
                    case 2://МО
                        $('#additional-address .region-label').text('Город, улица');
                        break;
                }
                $('[data-step="4"] #additional-address .form__item-disabled').removeClass('form__item-disabled');
                break;
        }
    }

    if(form.hasClass('form-reg')){
        validateStep(input.closest('.form__step').attr('data-step'));
    }
    if(form.hasClass('form-login')){
        validateLogin();
    }
    if(form.hasClass('toggle__box')){
        validateProfile(form);
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

function validateProfile(box){
    var same = $('[data-name="same"] input:checked').length;
    if(same === 0){
        showToggleFields('additional-address');
    }
    var enabled = true;
    box.find('.req-field .input').each(function (){
        if($(this).val().length === 0 || $(this).closest('.form__item').hasClass('has-error')){
            enabled = false;
        }
    });
    if(!enabled){
        box.find('button').attr('disabled', true);
    }else{
        box.find('button').attr('disabled', false);
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
