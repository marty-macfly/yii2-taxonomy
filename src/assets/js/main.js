$(document).ready(function() {
    var $app = $('body'),$window = $( window );
    //chosen list tags
    //$app.find(".tags-select").chosen({width: "100%"});

    //table responsive
    var $table_item = $app.find('#list-term');
    $table_item = $table_item.DataTable({
      responsive: true
    }).columns.adjust()
    .responsive.recalc();
    $window.resize(function() {
      $table_item.columns.adjust();
    });
    $table_item.on( 'order.dt search.dt', function () {
        $table_item.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    var $table_taxonomy = $app.find('#list-taxonomy');
    $table_taxonomy = $table_taxonomy.DataTable({
      responsive: true
    }).columns.adjust()
    .responsive.recalc();
    $window.resize(function() {
      $table_taxonomy.columns.adjust();
    });
    $table_taxonomy.on( 'order.dt search.dt', function () {
        $table_taxonomy.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

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
