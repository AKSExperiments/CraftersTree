(function ($) {
    "use strict"; // Start of use strict

    var serializeObject        = function ($form) {
        var o = {};
        var a = $form.serializeArray();
        $.each(a, function () {
            if ( o[ this.name ] ) {
                if ( !o[ this.name ].push ) {
                    o[ this.name ] = [ o[ this.name ] ];
                }
                o[ this.name ].push(this.value || '');
            } else {
                o[ this.name ] = this.value || '';
            }
        });
        return o;
    };
    $.fn.reload_content_items  = function () {
        var _this   = $(this),
            _id     = _this.attr('id').replace('menu-item-', ''),
            _button = _this.find('.ovic-menu-settings'),
            _icon   = _this.find('.menu-icon'),
            _label  = _this.find('.menu-label');

        _icon.html('').addClass('loading');
        _label.html('').addClass('loading');
        $.ajax({
            type: 'POST',
            url: ovic_megamenu_backend.ajaxurl,
            data: {
                action: 'ovic_button_settings',
                item_id: _id,
            },
            success: function (response) {
                if ( response[ 'success' ] == 'yes' ) {
                    _icon.html(response[ 'icon' ]);
                    _label.html(response[ 'label' ]);
                    if ( response[ 'megamenu' ] !== '' ) {
                        _button.addClass(response[ 'megamenu' ]);
                    } else {
                        _button.removeClass('button-primary');
                    }
                }
                _icon.removeClass('loading');
                _label.removeClass('loading');
            },
        });
    };
    $.fn.reload_builder_button = function (item_id) {
        var _this = $(this);

        _this.find('.ovic-menu-tab-builder').html('');
        $.ajax({
            type: 'POST',
            url: ovic_megamenu_backend.ajaxurl,
            data: {
                action: 'ovic_menu_create_mega_menu',
                item_id: item_id
            },
            success: function (response) {
                if ( response.status == true ) {
                    if ( response.url != "" ) {
                        _this.find('.ovic-menu-tab-builder').html('<p style="margin: 50px auto;text-align: center;">' +
                            '<a href="' + response.url + '" data-post_id="' + response.post_id + '" class="button button-primary button-hero button-updater load-content-iframe">' +
                            'LOAD EDITOR</a></p>');
                    }
                }
            },
        });
    };
    /* SELECT IMAGE */
    $(document).on('click', '.upload_image_button', function (event) {

        event.preventDefault();

        var _file_frame,
            _this   = $(this),
            _parent = _this.closest('.field-image-select'),
            _input  = _parent.find('.process_custom_images'),
            _img    = _parent.find('.preview_thumbnail');

        // If the media frame already exists, reopen it.
        if ( _file_frame ) {
            _file_frame.open();
            return;
        }

        // Create the media frame.
        _file_frame = wp.media.frames.downloadable_file = wp.media({
            title: 'Choose an image',
            button: {
                text: 'Use image'
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        _file_frame.on('select', function () {
            var attachment           = _file_frame.state().get('selection').first().toJSON();
            var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

            _input.val(attachment.id);
            _img.find('img').attr('src', attachment_thumbnail.url);
            _parent.find('.remove_image_button').show();
        });

        // Finally, open the modal.
        _file_frame.open();
    });
    $(document).on('click', '.remove_image_button', function (e) {
        $(this).closest('.field-image-select').find('img').attr('src', ovic_megamenu_backend.placeholder);
        $(this).closest('.field-image-select').find('.process_custom_images').val(0);
        $(this).closest('.field-image-select').find('.remove_image_button').hide();
        e.preventDefault();
    });
    /* SELECT IMAGE */
    $(document).on('click', '.ovic-menu-settings', function (e) {
        var $this       = $(this),
            item_id     = $this.data('item_id'),
            depth       = 0,
            title       = $this.data('item_title'),
            curent_item = $this.closest('.menu-item'),
            template    = wp.template('ovic-megamenu-content'),
            popup       = $('#ovic-menu-item-settings-popup-content-' + item_id);

        if ( !curent_item.hasClass('menu-item-depth-0') ) {
            depth = 1;
        }
        if ( popup.length ) {
            popup.css('display', 'block');
            $('.ovic-content-tmp-menu').addClass('active');
            $('.ovic-content-tmp-menu').find('.ovic-menu-item-settings-popup-content').not(popup).css('display', 'none');
        } else {
            $this.addClass('loading');
            $.ajax({
                type: 'POST',
                url: ovic_megamenu_backend.ajaxurl,
                data: {
                    action: 'ovic_get_form_settings',
                    item_id: item_id,
                    item_title: title,
                    depth: depth,
                },
                success: function (response) {
                    if ( response[ 'success' ] == 'yes' ) {
                        $('.ovic-content-tmp-menu').append(template(response[ 'html' ]));
                        $('.ovic-content-tmp-menu').addClass('active');
                    }
                },
                complete: function () {
                    $this.removeClass('loading');
                }
            });
        }
        e.preventDefault();
    });
    $(document).on('click', '.content-menu-close', function () {
        $(this).closest('.ovic-content-tmp-menu').removeClass('active');
    });
    $(document).on('click', '.tabs-settings a', function (e) {
        var container = $(this).closest('.ovic-menu-item-settings-popup-content'),
            id        = $(this).attr('href'),
            selected  = container.find('.fip-icons-container').data('selected');

        $(this).closest('.tabs-settings').find('li').removeClass('active');
        $(this).closest('li').addClass('active');
        container.find('.tab-container .ovic-menu-tab-content').removeClass('active');
        container.find(id).addClass('active');
        if ( id === '.ovic-menu-tab-icons' && !$(this).hasClass('loaded') ) {
            $(this).addClass('loaded');
            if ( selected !== '' ) {
                container.find('.fip-icons-container [data-value="' + selected + '"]').addClass('selected');
            }
        }

        e.preventDefault();
    });
    $(document).on('click', '.fip-icons-container .icon', function () {
        var value = $(this).data('value');
        $(this).closest('.fip-icons-container').find('.icon').removeClass('selected');
        $(this).addClass('selected');

        $(this).closest('.edit_form_line.field-icon-settings').find('.selected-icon').html('<i class="' + value + '"></i>');
        $(this).closest('.edit_form_line.field-icon-settings').find('input.ovic_menu_settings_menu_icon').val(value);
    });
    $(document).on('click', '.selector-button.remove', function () {
        $(this).closest('.edit_form_line.field-icon-settings').find('.icon').removeClass('selected');

        $(this).closest('.edit_form_line.field-icon-settings').find('.selected-icon').html('');
        $(this).closest('.edit_form_line.field-icon-settings').find('input.ovic_menu_settings_menu_icon').val('');
    });
    $(document).on('keyup', '.icons-search-input', function () {

        var v = $(this).val();

        if ( v !== '' ) {
            v = v.toLocaleLowerCase();
            $('.fip-icons-container .icon').addClass('hide');
            $('.fip-icons-container .icon[data-value*="' + v + '"]').removeClass('hide');
        } else {
            $('.fip-icons-container .icon').removeClass('hide');
        }
    });
    $(document).on('click', '.load-content-iframe', function (e) {
        e.preventDefault();
        var _this    = $(this),
            _url     = _this.attr('href'),
            _form    = _this.closest('.ovic-menu-item-settings-popup-content'),
            _content = _this.closest('.ovic-menu-tab-builder');

        _content.addClass('loading');
        _form.find('.post_id_magamenu').val(_this.data('post_id'));
        _content.html('<iframe id="iframe-content" onload="jQuery(\'.ovic-menu-tab-builder\').removeClass(\'loading\');" src="' + _url + '" width="100%" height="100%">Waiting for content ...</iframe>');
    });
    $(document).on('click', '.ovic-menu-save-settings', function (e) {
        e.preventDefault();
        var _this         = $(this),
            _form         = _this.closest('form'),
            _iframe       = _form.find('#iframe-content'),
            _item_id      = _this.data('item_id'),
            _data         = serializeObject(_form),
            _item_current = $('#menu-item-' + _item_id),
            _ajax_call    = {
                type: 'POST',
                url: ovic_megamenu_backend.ajaxurl,
                data: {
                    action: 'ovic_menu_save_all_settings',
                    menu_settings: _data,
                    item_id: _item_id
                },
                success: function (response) {
                    if ( response.status == true ) {
                        var _settings = response.settings;

                        _item_current.reload_content_items();
                    }
                    _this.html('Save All');
                    _form.find('.ovic-menu-tab-builder').removeClass('save-loading');
                    /* RESET BUTTON BUILDER */
                    _form.reload_builder_button(_item_id);
                    /* CLOSE POPUP */
                    $('.content-menu-close').trigger('click');
                },
            };

        _this.html('Saving..');
        _form.find('.ovic-menu-tab-builder').addClass('save-loading');

        if ( _iframe.length ) {
            _iframe.contents().find('input#publish').trigger('click');
            _iframe.on('load', function () {
                $.ajax(_ajax_call);
            });
        } else {
            $.ajax(_ajax_call);
        }
    });
    $(document).on('change', 'input.enable_mega', function () {
        var item_id      = $(this).data('item_id'),
            container    = $('#ovic-menu-item-settings-popup-content-' + item_id),
            item_current = $('#menu-item-' + item_id);

        if ( this.checked ) {
            container.reload_builder_button(item_id);
        } else {
            container.find('.ovic-menu-tab-builder').html('<div style="text-align: center; padding: 50px 20px;">' +
                'Click on "Enable Mega Builder" in  Settings tab before buiding content.</div>');
        }
    });

    $(document).on('change', 'select.menu_icon_type', function () {
        var container = $(this).closest('.ovic-menu-tab-icons'),
            val       = $(this).val();

        if ( val == 'font-icon' ) {
            container.find('.edit_form_line.field-icon-settings').show();
            container.find('.edit_form_line.field-image-settings').hide();
        }
        if ( val == 'image' ) {
            container.find('.edit_form_line.field-icon-settings').hide();
            container.find('.edit_form_line.field-image-settings').show();
        }
    });

})(jQuery); // End of use strict