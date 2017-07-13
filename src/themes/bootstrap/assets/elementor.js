$('body').after('<div id="elementor">');

var row = '<div class="draggable">';
row += '<span class="label label-default"><i class="glyphicon glyphicon-move"></i> drag</span>';
row += '<div class="row">';
row += '<div class="col-md-3 column">';
row += '</div>';
row += '<div class="col-md-3 column">';
row += '</div>';
row += '<div class="col-md-3 column">';
row += '</div>';
row += '<div class="col-md-3 column">';
row += '</div>';
row += '</div>';
row += '</div>';

var removeButton = '<a href="#close" class="label label-danger"><i class="glyphicon-remove glyphicon"></i> remove</a>';
var rowElementInfo = '<div class="element-info"><span class="element-title"> Row </span></div>';

// Add row to elementor 
$('#elementor').append(row);

$('.draggable').draggable({
    revert: "invalid",
    helper: 'clone',
    cursor: 'move',
    connectToSortable: "#page-builder"
});

$("#page-builder").sortable({
        revert: true,
        placeholder: 'ui-sortable-placeholder'
}).droppable({ 
	// Listen to drop event.
	drop: function (event, ui) {
		// Append remove button
		$(this).children('.draggable').children('.label').after(removeButton);
		// Append row element info
		$(this).children('.draggable').children('.label-danger').after(rowElementInfo);
		// Then remove dragable feature
    	$(this).children('.draggable').removeClass('draggable ui-draggable ui-draggable-handle').addClass('page-builder-row').css("width", "").css("height", "");
    }
});

$("#page-builder").disableSelection();
