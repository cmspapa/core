<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CMS PAPA | @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #673AB7;
                color: #fff;
                
                height: 100vh;
                margin: 0;
            }

            legend {
                color: #ffb74d;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .title {
                font-size: 84px;
                color: #ff9800;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            form {
                padding: 0 80px;
            }
            .nav>li {
                background: #5E35B1;
                margin: 2px 0;
                border: 1px solid #5E35B1;
                border-radius: 0 50px 50px 0;
                width: 95%;
            }
            li.active {
                background: #FFB74D;
                border-color: #FFB74D;
                width: 100%;
            }
            .nav>li>div {
                padding: 20px 15px;
                font-size: 20px;
                font-weight: 300;
                color: #9575CD;
            }
            li.active div {
                font-weight: 400;
                color: rgba(103, 58, 183, 0.76);
            }
            button.btn.btn-primary {
                background: #fc9604;
                border-color: #fc9600;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="title m-b-md flex-center">
                        CMS PAPA
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <ul class="nav nav-sidebar">
                    	<li @if(Request::is('install-verify-requirments')) class="active" @endif>
                            <div>Verify requirments</div>
                        </li>
                    	{{-- <li>
                            <div>Choose language</div>
                        </li> --}}
                        <li @if(Request::is('install-setup-database')) class="active" @endif>
                            <div>Set up database</div>
                        </li>
                        <li @if(Request::is('install-papa-dependencies')) class="active" @endif>
                            <div>Install papa dependencies</div>
                        </li>
                        <li @if(Request::is('install-configure-site')) class="active" @endif>
                            <div>Configure site</div>
                        </li>
                        <li @if(Request::is('install-finished')) class="active" @endif>
                            <div>Finished</div>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-8 col-md-9">
                	@yield('content')
                </div>
            </div>
        </div>
    </body>
    @yield('footer')
</html>
