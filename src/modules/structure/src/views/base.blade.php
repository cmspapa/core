<div id="app">
  @foreach($papaStructure as $levelOneKey => $levelOneComponent)
    @if($levelOneComponent['type'] == 'empty-section')
      @if($levelOneComponent['is_region'] == true)
        @yield($levelOneKey) 
      @endif
    @elseif($levelOneComponent['type'] == 'navbar')
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          @if($levelOneComponent['is_region'] == true)
            @yield($levelOneKey) 
          @endif
        </div>
      </nav>
    @elseif($levelOneComponent['type'] == 'jumbotron')
      <div class="jumbotron">
        <div class="container">
          @if($levelOneComponent['is_region'] == true)
            @yield($levelOneKey) 
          @endif
        </div>
      </div>
    @elseif($levelOneComponent['type'] == 'container-fluid' || $levelOneComponent['type'] == 'container')
      <div class="{{ $levelOneComponent['type'] }}">
        @foreach($levelOneComponent['level_two'] as $levelTwoComponent)
          @if($levelTwoComponent['type'] == 'row')
            <div class="row">
              @foreach($levelTwoComponent['columns'] as $columnKey => $column)
              {{-- needs work--}}
                <div class="col-md-{{$column['width']}}">
                  @if($column['is_region'] == true)
                    @yield($columnKey) 
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        @endforeach
      </div>
    @elseif($levelOneComponent['type'] == 'footer')
      <footer class="container-fluid text-center">
        @if($levelOneComponent['is_region'] == true)
          @yield($levelOneKey) 
        @endif
      </footer>
    @endif
  @endforeach
</div>