@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                    <br>
                    url : {{ $url }}
                </div>
                <div class="panel-body">
                    user name :  {{ $user->name }}
                    <hr>
                    user password : {{ $user->password }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
