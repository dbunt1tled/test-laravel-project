/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/*
$('.region-selector').each(function () {
   var block = $(this);
   var selected = block.data('selected');
   var url = block.data('source');
   var buildSelect = function (parent,items) {
       var current = items[0];
       var select = $('<select class="form-control">');
       var group = $('<div class="form-group">');
       select.append($('<option value=""></option>'));
       group.append(select);
       block.append(group);
       axios.get(url, {params: {parent:parent}})
               .then(function (response) {
                   response.data.forEach(function (region) {
                       select.append(
                               $("<option>")
                                       .attr('name', 'regions[]')
                                       .attr('value',region.id)
                                       .attr('selected',region.id === current)
                                       .text(region.name)
                       );
                   });
                   if(current){
                       buildSelect(current,items.slice(1));
                   }
               })
               .catch(function (error) {
                  console.log(error);
               });
   };
   buildSelect(null,selected);
});
/**/
$(document).on('click', '.phone-button', function () {
    var button = $(this);
    axios.post(button.data('source')).then(function (response) {
        button.find('.number').html(response.data);
    }).catch(function (reason) {
        console.log(reason);
    });
});

$('.banner').each(function () {
    var block = $(this);
    var url = block.attr('data-url');
    var format = block.attr('data-format');
    var category = block.attr('data-category');
    var region = block.attr('data-region');
    axios.get(url, {params: {
                    format: format,
                    category: category,
                    region: region
                }})
            .then(function (response) {
                block.html(response.data);
            })
            .catch(function (error) {
                console.error(error);
            });
});
