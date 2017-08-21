$(document).ready(function() {
    var $app = $('body'),$window = $( window );

    //terms assignment
    $app.find('#terms-select').multiSelect({
      cssClass:"terms-select",
      selectableHeader: "<div class='list-group-item active text-center'>Select Terms</div>",
      selectionHeader: "<div class='list-group-item active text-center'>Selected</div>",
    });

    //taxonomy selection
    $app.find('.select-taxonomy-type').scombobox({
        placeholder:'Input new or select existing type..',
        invalidAsValue:true,
        forbidInvalid:false,
        removeDuplicates:true,
    });
    $app.find('.select-taxonomy-name').scombobox({
        placeholder:'Input new or select existing name..',
        invalidAsValue:true,
        forbidInvalid:false,
        removeDuplicates:true,
    });
    $app.find('.scombobox-value:first').attr('name','Taxonomy_type');
    $app.find('.scombobox-value:last').attr('name','Taxonomy_name');
});
