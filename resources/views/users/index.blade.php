@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Add User</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('users.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Users
                <span class="pull-right">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-xs">Add User</a>
                </span>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Threshold</th>
                        <th class="text-center">Slack Webhook</th>
                        <th class="text-center">Notifications</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">{{ $user->threshold }}</td>
                                <td class="text-center">{{ (bool) $user->slack_webhook ? 'Yes' : 'No'  }}</td>
                                <td class="text-center">{{ $user->notifications_enabled ? 'Yes' : 'No' }}</td>
                                <td class="text-right">
                                    @if($user->id !== auth()->user()->id)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <div class="btn-group btn-group-xs text-nowrap">
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </div>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
