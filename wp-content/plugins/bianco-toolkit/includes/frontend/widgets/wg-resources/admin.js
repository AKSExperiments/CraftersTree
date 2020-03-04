"use strict";
$(document).on('click','.prices-filters .button.btn_save', function(e){
    e.preventDefault();
    var _this = $(this),
        _min = 0,
        _max = 0,
        min_input_value = _this.siblings('input[type=number][name=int_from]'),
        max_input_value = _this.siblings('input[type=number][name=int_to]'),
        store_id = '#'+_this.siblings('input.input_content').attr('id');

    if(typeof min_input_value !== undefined && parseInt(min_input_value.val(),10) > 0 ){
        _min = min_input_value.val();
    }
    if(typeof max_input_value !== undefined && parseInt(max_input_value.val(),10) > 0 ){
        _max = max_input_value.val();
    }

    var html = `<li class="list-item" data-value = "${_min}-${_max}"><span class="min-value">${_min}</span><span class="break-line">-</span><span class="max-value">${_max}</span></li>`;
    _this.parents().siblings('.results').append(html);
    min_input_value.trigger('change');
    take_result_data(store_id);
});

$(document).on('click','.prices-filters .button.btn_clear', function(e){
    e.preventDefault();
    $(this).parents().siblings('.results').find('li.list-item').remove();
    $(this).siblings('input.input_content').val('0').trigger('change');
});

function take_result_data(id){
    var _store_data =  $(id),
        _list_data = _store_data.parents().siblings('.results').find('li.list-item'),
        _data = '';
    if(_list_data.length){
        _list_data.each(function(index, el) {
            var _value = $(this).attr('data-value');
            if(typeof _value !== undefined){
                _data +='/'+_value;
            }
        });
    }
    _store_data.val(_data);
}