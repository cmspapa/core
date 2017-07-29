@extends(config('app.admin_theme').'::master')
@section('head_scripts')
{{-- Add css or js to header --}}
    <style type="text/css">
        .structure-builder{
            min-height: 300px;
            border: 1px solid #ccc;
            padding: 20px;
            background: #fff;
        }
        .structure-navbar, .structure-carousel, .structure-jumbotron, .structure-container, .structure-container-fluid, .structure-footer {
            min-height: 100px;
            border: 1px solid #ccc;
            background: #eee;
            padding: 20px;
            margin: 10px 0;
        }
        .structure-container {
            margin: 10px 40px;
        }

        .structure-row {
            min-height: 100px;
            background: #ccc;
            margin: 10px 0;
            padding: 20px;
        }

        .structure-col {
            background: #eee;
            min-height: 200px;
            border: 1px solid #fff;
            padding: 20px;
            display: inline-block;
            overflow: hidden;
        }

        .element-info {
            margin-top: -19px;
            margin-bottom: 20px;
            margin-left: -20px;
        }

        .element-title {
            font-size: 18px;
            font-weight: 500;
            background: #212121;
            padding: 2px 15px;
            border-radius: 0 0 6px;
            color: #fbfbfb;
        }
        .structure-col .element-title {
            font-size: 14px;
            font-weight: 200;
            padding: 2px 10px;
        }
        .structure-row .form-inline {
            margin-bottom: 10px;
        }

    </style>
@endsection
@section('title')
Structure
@endsection
@section('sub_title')
    {{-- <small>Optional subtitle</small> --}}
@endsection
@section('breadcrumb')
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Structure</li>
@endsection
@section('sidebare')
{{-- Add custom blocks to sidebare --}}
@endsection
@section('content')
{{-- Add main page content --}}
    <div class="row">
        <div class="col-md-12">
            <div class="structure-builder">
                <div class="element-info"><span class="element-title"> Body </span></div>
                <div id="level_one" class="level_one form-inline">
                    <div class="form-group">
                        <select id="level_one_select" class="form-control">
                            <option value="navbar">Navbar</option>
                            <option value="carousel">Carousel</option>
                            <option value="jumbotron">Jumbotron</option>
                            <option value="container-fluid">Container fluid</option>
                            <option value="container">Container</option>
                            <option value="footer">Footer</option>
                        </select>
                    </div>
                    <a id="level_one_btn" class="btn btn-primary">Add</a>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('footer_right')
{{-- Anything you want --}} 
@endsection
@section('footer_scripts')
{{-- Add css or js to header --}}
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var structure = {};
var levelOneComponentsCount = 1;

/**
 * Get current theme structure.
 */
function getStructure() {
    $.get('/admin/structure/get-structure', function(data, status){
        if(typeof data == 'object'){
            structure = data;
            var ids = [];
            for (var key in data) {
                if (data.hasOwnProperty(key) && data[key].hasOwnProperty('type')) {
                    // Push id on this component
                    ids.push(getLevelOneComponentIntegerId(key));
                    // Generate component html
                    // Check if region name exists
                    var LevelOneComponentRegionName = '';
                    if (data[key].hasOwnProperty('region_name')){
                        LevelOneComponentRegionName = data[key]['region_name'];
                    }
                    generateLevelOne(key, data[key]['type'], LevelOneComponentRegionName);
                    // Get level two structure
                    if(data[key].hasOwnProperty('level_two')){
                        for (var levelTwocomponentId in data[key]['level_two']) {
                            if(data[key]['level_two'][levelTwocomponentId]['type'] == 'row'){
                                generateLevelTwo(key, data[key]['level_two'][levelTwocomponentId]['type'], data[key]['level_two'][levelTwocomponentId]['columns'])
                            }else{
                                generateLevelTwo(key, data[key]['level_two'][levelTwocomponentId]['type'])
                            }
                            
                        }

                    }

                    //console.log(key + " -> " + data[key]['value']);
                }
            }
            // Generate last count of components
            ids.sort();
            levelOneComponentsCount = ids[ids.length -1] +1;
        }
    });
}
getStructure();

/**
 * Generate level one
 *
 * @parm levelOneComponentId
 */
function getLevelOneComponentIntegerId(levelOneComponentId) {
   return parseInt(levelOneComponentId.replace(/component_/g,''));
}

/**
 * Generate level one
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentType
 */
function generateLevelOne(levelOneComponentId, levelOneComponentType, levelOneComponentRegionName = '') {
    $('#level_one').before('<div id="'+levelOneComponentId+'" class="structure-'+ levelOneComponentType +'"><div class="element-info"><span class="element-title"> '+ levelOneComponentType +' </span></div>'+levelOneComponentInnerHtml(levelOneComponentId, levelOneComponentType)+'</div>');
    // Add default region name
    $('#region_'+levelOneComponentId).val(levelOneComponentRegionName);
    // Listen to region name change
    ListenTolevelOneRegion(levelOneComponentId);
    // Listen to level two
    ListenTolevelTwo(levelOneComponentId);
    levelOneComponentsCount++;
}

/**
 * Listen to level one
 */
function ListenTolevelOne() {
    $('#level_one_btn').on('click', function () {
        // Add level two depend on selected options
        var levelOneComponentId = 'component_'+levelOneComponentsCount;
        var levelOneComponentType = $('#level_one_select').val();
        // Generate level one
        generateLevelOne(levelOneComponentId, levelOneComponentType);
        // Save level one component
        saveLevelOne(levelOneComponentId, levelOneComponentType);
    });
}
ListenTolevelOne();

/**
 * Listen to level one region change
 * @param levelOneComponentId integer
 */
function ListenTolevelOneRegion(levelOneComponentId){
    $('#region_'+levelOneComponentId).keyup(function(){
        // Save level one component
        saveLevelOneRegionName(levelOneComponentId, $(this).val());
    });
} 

/**
 * level one component inner html
 */
function levelOneComponentInnerHtml(levelOneComponentId, levelOneComponentType) {

    var levelOneComponentInnerHtml = '';
    if(levelOneComponentType == 'container' || levelOneComponentType == 'container-fluid'){
        levelOneComponentInnerHtml += '<div id="'+levelOneComponentId+'_level_two" class="form-inline">';
        levelOneComponentInnerHtml += '<div class="form-group">';
        levelOneComponentInnerHtml += '<select id="'+levelOneComponentId+'_level_two_select" class="form-control">';
            // Options
            levelOneComponentInnerHtml += '<option value="row">Row</option>';
        levelOneComponentInnerHtml += '</select>';
        levelOneComponentInnerHtml += '</div>';
        levelOneComponentInnerHtml += '<a id="'+levelOneComponentId+'_level_two_btn" class="btn btn-primary">Add</a>';
        levelOneComponentInnerHtml += '</div>';
    }else{
        // Add region control
        levelOneComponentInnerHtml += regionControlHtml(levelOneComponentId);
    }
    return levelOneComponentInnerHtml;
}

var numberOflevelOneComponentIdLevelTwoComponents = 0;

/**
 * Generate level Two
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoType
 * @parm levelOneComponentIdLevelTwoTypeOptions
 */
function generateLevelTwo(levelOneComponentId, levelOneComponentIdLevelTwoType, levelOneComponentIdLevelTwoTypeOptions = {}) {
    numberOflevelOneComponentIdLevelTwoComponents = $('#'+levelOneComponentId+' .structure-item').length + 1;
    var levelOneComponentIdLevelTwoId = levelOneComponentId+'_component_'+numberOflevelOneComponentIdLevelTwoComponents;

    // Save level two
    saveLevelTwo(levelOneComponentId, levelOneComponentIdLevelTwoId, levelOneComponentIdLevelTwoType);

    // Add level two depend on selected options
    if(levelOneComponentIdLevelTwoType == 'row'){
        generateLevelTwoOfTypeRow(levelOneComponentId, levelOneComponentIdLevelTwoId, levelOneComponentIdLevelTwoTypeOptions);
    }
}

/**
 * Generate level Two Row
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoId
 */
function generateLevelTwoOfTypeRow(levelOneComponentId, levelOneComponentIdLevelTwoId, levelOneComponentIdLevelTwoTypeOptions = {}) {
    var rowForm = '<div class="form-inline">';
    rowForm += '<div class="form-group">';
    rowForm += '<select class="columns-options form-control">';
    // Row options
    for (var i = 1; i < 13; i++) {
        rowForm += '<option value="'+i+'">'+i+'-column</option>';
    }
    rowForm += '</select>';
    rowForm += '</div>';
    rowForm += '</div>';
    
    // Type row
    $('#'+levelOneComponentId+'_level_two').before('<div id="'+levelOneComponentIdLevelTwoId+'" class="row structure-item structure-row"><div class="element-info"><span class="element-title"> row </span></div>'+rowForm+'<div class="messages"></div></div>');

    if(levelOneComponentIdLevelTwoTypeOptions){
        var colOrder;
        var escape = new RegExp(levelOneComponentIdLevelTwoId + "_col_", "g");
        // Remove any old columns
        $('#'+levelOneComponentIdLevelTwoId+' .structure-col').remove();
        // Set number of columns
        var numberOfColumns = 0;
        for (var colId in levelOneComponentIdLevelTwoTypeOptions) {
            colOrder = parseInt(colId.replace(escape,''));
            generateLevelTwoOfTypeRowColumn(levelOneComponentId, levelOneComponentIdLevelTwoId, colOrder, levelOneComponentIdLevelTwoTypeOptions[colId]);
            // Add default column region if exist.
            if(levelOneComponentIdLevelTwoTypeOptions[colId].hasOwnProperty('region_name')){
                $('#region_'+colId).val(levelOneComponentIdLevelTwoTypeOptions[colId]['region_name']);
            }
            numberOfColumns++;
        }
        $('#'+levelOneComponentIdLevelTwoId+' .columns-options').val(numberOfColumns);
    }else{
        // Generate default row col
        generateLevelTwoOfTypeRowColumn(levelOneComponentId, levelOneComponentIdLevelTwoId, 1);
        $('#'+levelOneComponentIdLevelTwoId+' .structure-col').addClass('col-md-12');
        $('#'+levelOneComponentIdLevelTwoId+'_col_1 select.columns-width-options').val(12);
    }

    saveLevelTwoRowColumns(levelOneComponentId, levelOneComponentIdLevelTwoId);
    // Listen to row columns change event
    listenTolevelOneComponentLevelTwoOfTypeRowColumns(levelOneComponentId, levelOneComponentIdLevelTwoId);
}

/**
 * Listen to level two
 */
function ListenTolevelTwo(levelOneComponentId, levelOneComponentIdLevelTwoId) {
    $('#'+levelOneComponentId+'_level_two_btn').on('click', function () {
        var levelOneComponentIdLevelTwoType = $('#'+levelOneComponentId+'_level_two_select').val();
        generateLevelTwo(levelOneComponentId, levelOneComponentIdLevelTwoType);
    });
}

/**
 * level one component level two inner html
 *
 * @parm levelOneComponentIdLevelTwoId
 * @parm columnOrder integer
 */
function levelOneComponentLevelTwoInnerHtmlOfTypeRow(levelOneComponentIdLevelTwoId, columnOrder) {
    var levelOneComponentLevelTwoInnerHtmlOfTypeRow = '<div id="'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder+'" class="structure-col '+levelOneComponentIdLevelTwoId+'-columns">';
    levelOneComponentLevelTwoInnerHtmlOfTypeRow += '<div class="element-info"><span class="element-title"> Column </span></div>';
    levelOneComponentLevelTwoInnerHtmlOfTypeRow += '<div class="form-inline">';
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += '<div class="form-group">';
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += '<label>Col width</label>';
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += '<select class="columns-width-options form-control">';
        // width options
        for (var i = 1; i < 13; i++) {
            levelOneComponentLevelTwoInnerHtmlOfTypeRow += '<option value="'+i+'">'+i+'</option>';
        }
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += '</select>';
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += '</div>';
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += '</div>';
        levelOneComponentLevelTwoInnerHtmlOfTypeRow += regionControlHtml(levelOneComponentIdLevelTwoId+'_col_'+columnOrder);
    levelOneComponentLevelTwoInnerHtmlOfTypeRow += '</div>';
    return levelOneComponentLevelTwoInnerHtmlOfTypeRow;
}

/**
 * level one component level two inner html.
 *
 * @parm levelOneComponentIdLevelTwoId
 * @parm columnOrder integer
 * @return void
 */
function generateLevelTwoOfTypeRowColumn(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder, colOptions = {}) {
    $('#'+levelOneComponentIdLevelTwoId).append(levelOneComponentLevelTwoInnerHtmlOfTypeRow(levelOneComponentIdLevelTwoId, columnOrder));
    if(colOptions && colOptions['width']){
        $('#'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder+' select.columns-width-options').val(colOptions['width']);
        $('#'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder).addClass('col-md-'+colOptions['width']);
    }
    // Listen to column
    listenToLevelTwoRowColumn(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder);
    // Listen to column region
    ListenToColumnRegion(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder);
}

/**
 * Listen to level two row column
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoId
 * @parm columnOrder
 */
function listenToLevelTwoRowColumn(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder){
    $('#'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder+' select.columns-width-options').change(function() {
        $('#'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder).removeClass (function (index, className) {
            return (className.match (/(^|\s)col-md-\S+/g) || []).join(' ');
        });
        $('#'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder).addClass('col-md-'+$(this).val());
        if(validateColumnsWidth(levelOneComponentIdLevelTwoId)){
            // Save row columns
            saveLevelTwoRowColumns(levelOneComponentId, levelOneComponentIdLevelTwoId);
        }
    });
}

/**
 * Listen to level two row column region.
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoId
 * @parm columnOrder
 */
function ListenToColumnRegion(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder){
    $('#region_'+levelOneComponentIdLevelTwoId+'_col_'+columnOrder).keyup(function() {
        // Save row column region
        saveLevelTwoRowColumnRegion(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder, $(this).val());
    });
}

/**
 * Validate columns width
 *
 * @parm levelOneComponentIdLevelTwoId
 * @return boolean
 */
function validateColumnsWidth(levelOneComponentIdLevelTwoId) {
    // Remove error messages
    $('#'+levelOneComponentIdLevelTwoId+' .columns-width-error').remove();
    // Remove error to col width field
    $('.'+levelOneComponentIdLevelTwoId+'-columns .form-group').each(function() {
        $(this).removeClass('has-error');
    });

    var columnsWidth = 0;
    $('.'+levelOneComponentIdLevelTwoId+'-columns select.columns-width-options').each(function() {
        columnsWidth = columnsWidth + parseInt($(this).val());
    });
    if(columnsWidth == 12){
        return true;
    }
    var message = '';
    // Add error message
    $('#'+levelOneComponentIdLevelTwoId+' .messages').append('<div class="alert alert-danger columns-width-error">Update not saved, current columns width is <b>'+columnsWidth+'</b> but it must be <b><em>12</em></b> You can change number of columns or change any of col width.</div>');
    // Add error to col width field
    $('.'+levelOneComponentIdLevelTwoId+'-columns .form-group').each(function() {
        $(this).addClass('has-error');
    });
    
    return false;
}

/**
 * Listen to row columns change event
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoId
 */
function listenTolevelOneComponentLevelTwoOfTypeRowColumns(levelOneComponentId, levelOneComponentIdLevelTwoId){
    $('#'+levelOneComponentIdLevelTwoId+' .columns-options').on('change', function () {
        $('#'+levelOneComponentIdLevelTwoId+' .structure-col').remove();
        for (var numberOfColumns = 0; numberOfColumns < $(this).val(); numberOfColumns++) {
            // Generate row column
            generateLevelTwoOfTypeRowColumn(levelOneComponentId, levelOneComponentIdLevelTwoId, numberOfColumns+1);
        }

        var colWidth = 1;
        if(numberOfColumns == 1){
            colWidth = 12;
        }else if(numberOfColumns == 2){
            colWidth = 6;
        }else if(numberOfColumns == 3){
            colWidth = 4;
        }else if(numberOfColumns == 4){
            colWidth = 3;
        }else if(numberOfColumns == 6){
            colWidth = 2;
        }

        // Add default select option
        if(numberOfColumns == 5){
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function(i) {
                var colId = i + 1;
                if(colId < 5){
                    colWidth = 2;
                    $(this).val(colWidth);                    
                }else{
                    colWidth = 4;
                    $(this).val(colWidth);
                }
                $('#'+levelOneComponentIdLevelTwoId+'_col_'+colId).addClass('col-md-'+colWidth);
            });
        }else if(numberOfColumns == 7){
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function(i) {
                var colId = i + 1;
                if(colId < 6){
                    colWidth = 2;
                    $(this).val(colWidth);                    
                }else{
                    colWidth = 1;
                    $(this).val(colWidth);
                }
                $('#'+levelOneComponentIdLevelTwoId+'_col_'+colId).addClass('col-md-'+colWidth);
            });
        }else if(numberOfColumns == 8){
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function(i) {
                var colId = i + 1;
                if(colId < 5){
                    colWidth = 2;
                    $(this).val(colWidth);                    
                }else{
                    colWidth = 1;
                    $(this).val(colWidth);
                }
                $('#'+levelOneComponentIdLevelTwoId+'_col_'+colId).addClass('col-md-'+colWidth);
            });
        }else if(numberOfColumns == 9){
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function(i) {
                var colId = i + 1;
                if(colId < 7){
                    colWidth = 1;
                    $(this).val(colWidth);                    
                }else{
                    colWidth = 2;
                    $(this).val(colWidth);
                }
                $('#'+levelOneComponentIdLevelTwoId+'_col_'+colId).addClass('col-md-'+colWidth);
            });
        }else if(numberOfColumns == 10){
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function(i) {
                var colId = i + 1;
                if(colId < 9){
                    colWidth = 1;
                    $(this).val(colWidth);                    
                }else{
                    colWidth = 2;
                    $(this).val(colWidth);
                }
                $('#'+levelOneComponentIdLevelTwoId+'_col_'+colId).addClass('col-md-'+colWidth);
            });
        }else if(numberOfColumns == 11){
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function(i) {
                var colId = i + 1;
                if(colId < 11){
                    colWidth = 1;
                    $(this).val(colWidth);                    
                }else{
                    colWidth = 2;
                    $(this).val(colWidth);
                }
                $('#'+levelOneComponentIdLevelTwoId+'_col_'+colId).addClass('col-md-'+colWidth);
            });
        }else{
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col select.columns-width-options').each(function() {
                $(this).val(colWidth);
            });
            $('#'+levelOneComponentIdLevelTwoId+' .structure-col').addClass('col-md-'+colWidth);
        }

        if(validateColumnsWidth(levelOneComponentIdLevelTwoId)){
            // Save row columns
            saveLevelTwoRowColumns(levelOneComponentId, levelOneComponentIdLevelTwoId);
        }
    });
}

/**
 * 
 *
 * @parm componentId integer
 */
function regionControlHtml(componentId){
    var regionControlHtml = '<div>';
    regionControlHtml += '<div class="form-inline">';
    regionControlHtml += '<div class="form-group">';
    regionControlHtml += '<label for="">Region name</label>';
    regionControlHtml += '<input type="text" class="form-control" id="region_'+componentId+'" placeholder="Unique region name">';
    regionControlHtml += '<p class="help-text text-muted"><em>Region id:</em> '+componentId+'</p>';
    regionControlHtml += '';
    regionControlHtml += '</div>';
    regionControlHtml += '</div>';
    regionControlHtml += '</div>';

    return regionControlHtml;
}

/**
 * Save level one components to structure.
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentType
 */
function saveLevelOne(levelOneComponentId, levelOneComponentType) {
    structure[levelOneComponentId] = {};
    structure[levelOneComponentId].type = levelOneComponentType;
    // Check if type is region or no
    if(levelOneComponentType != 'container' && levelOneComponentType != 'container-fluid') {
        structure[levelOneComponentId].is_region = true;
    }
    // Save level one component
    saveStructure();
}

/**
 * Save level one component region name.
 *
 * @parm levelOneComponentId integer
 * @parm levelOneComponentRegionName string
 */
function saveLevelOneRegionName(levelOneComponentId, levelOneComponentRegionName) {
    structure[levelOneComponentId].region_name = levelOneComponentRegionName;
    // Save level one component
    saveStructure();
}

/**
 * Save level Two components to structure.
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoId
 * @parm levelOneComponentIdLevelTwoType
 */
function saveLevelTwo(levelOneComponentId, levelOneComponentIdLevelTwoId, levelOneComponentIdLevelTwoType) {
    if (typeof structure[levelOneComponentId].level_two == 'undefined'){
        // Init level two
        structure[levelOneComponentId].level_two = {};
    }
    structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId] = {};
    structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].type = levelOneComponentIdLevelTwoType;
    // Save level two component
    saveStructure();
}

/**
 * Save level Two components to structure.
 *
 * @parm levelOneComponentId
 * @parm levelOneComponentIdLevelTwoId
 */
function saveLevelTwoRowColumns(levelOneComponentId, levelOneComponentIdLevelTwoId) {
    if (typeof structure[levelOneComponentId].level_two == 'undefined'){
        // Init
        structure[levelOneComponentId].level_two = {};
        if (typeof structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId] == 'undefined'){
            // Init
            structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId] = {};
        }
    }
    structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].columns = {};
    $('#'+levelOneComponentIdLevelTwoId+' .structure-col').each(function() {
        structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].columns[$(this).attr('id')] = {};
        structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].columns[$(this).attr('id')].width = $(this).find('.columns-width-options').val();
        structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].columns[$(this).attr('id')].is_region = true;
        structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].columns[$(this).attr('id')].region_name = $('#region_'+$(this).attr('id')).val();
    });
    saveStructure();
}


/**
 * Save level two component row column region name.
 *
 * @parm levelOneComponentId integer
 * @parm levelOneComponentIdLevelTwoId integer
 * @parm columnOrder integer
 * @parm columnRegionName string
 */
function saveLevelTwoRowColumnRegion(levelOneComponentId, levelOneComponentIdLevelTwoId, columnOrder, columnRegionName) {
    structure[levelOneComponentId].level_two[levelOneComponentIdLevelTwoId].columns[levelOneComponentIdLevelTwoId+'_col_'+columnOrder].region_name = columnRegionName;
    // Save Structure
    saveStructure();
}

/**
 * Save structure to database.
 */
function saveStructure() {
    $.post('/admin/structure/save', {structure: structure}, function(data, status){
        console.log("Data: " + data + "\nStatus: " + status);
    });
}

</script>
@endsection