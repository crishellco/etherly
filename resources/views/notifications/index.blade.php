@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Your Notifications
            </div>
            <div class="panel-body">
                <notifications-table></notifications-table>
            </div>
        </div>
    </div>
@endsection
