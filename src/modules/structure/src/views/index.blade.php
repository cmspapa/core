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
        .structure-container, .structure-container-fluid {
            min-height: 100px;
            border: 1px solid #ccc;
            background: #eee;
            padding: 20px;
        }
        .structure-container{
            margin: 10px 40px;
        }
        .structure-container-fluid{
            margin: 10px 0;
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
            width: 100%;
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
                            <option value="container-fluid">Container fluid</option>
                            <option value="container">Container</option>
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
var levelOneComponentsCount = 1;

/**
 * Listen to level one
 */
function ListenTolevelOne() {
    $('#level_one_btn').on('click', function () {
        // Add level two depend on selected options
        // levelOneComponentsCount = levelOneComponentId
        $('#level_one').before('<div id="level_one_component_'+levelOneComponentsCount+'" class="structure-'+ $('#level_one_select').val() +'"><div class="element-info"><span class="element-title"> '+ $('#level_one_select').val() +' </span></div>'+levelOneComponentInnerHtml(levelOneComponentsCount)+'</div>');
        ListenTolevelTwo(levelOneComponentsCount);
        levelOneComponentsCount++;
    });
}
ListenTolevelOne();

/**
 * level one component inner html
 */
function levelOneComponentInnerHtml(levelOneComponentId) {
    var levelOneComponentInnerHtml = '<div id="level_one_component_'+levelOneComponentId+'_level_two" class="form-inline">';
    levelOneComponentInnerHtml += '<div class="form-group">';
    levelOneComponentInnerHtml += '<select id="level_one_component_'+levelOneComponentId+'_level_two_select" class="form-control">';
        // Options
        levelOneComponentInnerHtml += '<option value="row">Row</option>';
        //levelOneComponentInnerHtml += '';
    levelOneComponentInnerHtml += '</select>';
    levelOneComponentInnerHtml += '</div>';
    levelOneComponentInnerHtml += '<a id="level_one_component_'+levelOneComponentId+'_level_two_btn" class="btn btn-primary">Add</a>';
    levelOneComponentInnerHtml += '</div>';
    return levelOneComponentInnerHtml;
}

var numberOflevelOneComponentIdLevelTwoComponents = 0;
/**
 * Listen to level two
 */
function ListenTolevelTwo(levelOneComponentId) {
    $('#level_one_component_'+levelOneComponentId+'_level_two_btn').on('click', function () {
        numberOflevelOneComponentIdLevelTwoComponents = $('#level_one_component_'+levelOneComponentId+' .structure-row').length + 1;
        // Add level two depend on selected options
        var rowForm = '<div class="form-inline">';
        rowForm += '<div class="form-group">';
        rowForm += '<select class="columns-options form-control">';
            // Row options
            rowForm += '<option value="1">1-column</option>';
            rowForm += '<option value="2">2-column</option>';
            rowForm += '<option value="3">3-column</option>';
            rowForm += '<option value="4">4-column</option>';
            rowForm += '<option value="5">5-column</option>';
            rowForm += '<option value="6">6-column</option>';
            rowForm += '<option value="7">7-column</option>';
            rowForm += '<option value="8">8-column</option>';
            rowForm += '<option value="9">9-column</option>';
            rowForm += '<option value="10">10-column</option>';
            rowForm += '<option value="11">11-column</option>';
            rowForm += '<option value="12">12-column</option>';
        rowForm += '</select>';
        rowForm += '</div>';
        rowForm += '</div>';
        $('#level_one_component_'+levelOneComponentId+'_level_two').before('<div id="level_one_component_'+levelOneComponentId+'_level_two_component_'+numberOflevelOneComponentIdLevelTwoComponents+'" class="structure-'+ $('#level_one_component_'+levelOneComponentId+'_level_two_select').val() +'"><div class="element-info"><span class="element-title"> '+ $('#level_one_component_'+levelOneComponentId+'_level_two_select').val() +' </span></div>'+rowForm+levelOneComponentLevelTwoInnerHtml()+'</div>');
        // Listen to row columns change event
        ListenToRowColumns('level_one_component_'+levelOneComponentId+'_level_two_component_'+numberOflevelOneComponentIdLevelTwoComponents+'');
    });
}

/**
 * level one component level two inner html
 */
function levelOneComponentLevelTwoInnerHtml() {
    var levelOneComponentLevelTwoInnerHtml = '<div class="structure-col">';
    levelOneComponentLevelTwoInnerHtml += '<div class="element-info"><span class="element-title"> Column </span></div>';
    levelOneComponentLevelTwoInnerHtml += '</div>';
    return levelOneComponentLevelTwoInnerHtml;
}

/**
 * Listen to row columns change event
 */
function ListenToRowColumns(rowId){
    $('#'+rowId+' .columns-options').on('change', function () {
        $('#'+rowId+' .structure-col').remove();
        for (var i = 0; i < $(this).val(); i++) {
            $('#'+rowId).append(levelOneComponentLevelTwoInnerHtml());
            $('#'+rowId+' .structure-col').css('width', 100 / $(this).val()+'%');
        }
    });
}

</script>
@endsection