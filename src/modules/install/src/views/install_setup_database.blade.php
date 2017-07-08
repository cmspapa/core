@extends('install::master')
@section('title')
Install database
@endsection
@section('content')
    <form action="/install-setup-database" method="POST" role="form">
        <legend>Install Database</legend>
    
        <div class="form-group">
            <label for="db_connection">DB connection</label>
            <input id="db_connection" name="db_connection" type="text" class="form-control" value="mysql" placeholder="mysql">
        </div>

        <div class="form-group">
            <label for="db_host">DB host</label>
            <input id="db_host" name="db_host" type="text" class="form-control" value="127.0.0.1" placeholder="127.0.0.1">
        </div>

        <div class="form-group">
            <label for="db_port">DB port</label>
            <input id="db_port" name="db_port" type="text" class="form-control" value="3306" placeholder="3306">
        </div>

        <div class="form-group">
            <label for="db_name">DB name</label>
            <input id="db_name" name="db_name" type="text" class="form-control" value="homestead" placeholder="homestead">
        </div>

        <div class="form-group">
            <label for="db_username">DB username</label>
            <input id="db_username" name="db_username" type="text" class="form-control" value="homestead" placeholder="homestead">
        </div>

        <div class="form-group">
            <label for="db_password">DB password</label>
            <input id="db_password" name="db_password" type="text" class="form-control" value="homestead" placeholder="homestead">
        </div>
    
        <button type="submit" class="btn btn-primary">Save & next</button>
    </form>
@endsection