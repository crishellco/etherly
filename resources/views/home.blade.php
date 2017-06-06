@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <eth-chart :data="{{ json_encode($data) }}"></eth-chart>
        </div>
    </div>
</div>
@endsection
