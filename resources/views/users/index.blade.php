@extends('layouts.app')

@section('content')
    <div class="container">
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
