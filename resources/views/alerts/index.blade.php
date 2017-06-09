@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create Alert
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('alerts.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Price</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="price" value="{{ old('price') }}" required autofocus>

                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('direction') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Direction</label>

                        <div class="col-md-6">
                            <select class="form-control" name="direction" required>
                                <option value="above" {{old('direction') === 'above' ? 'selected' : ''}}>Above</option>
                                <option value="below" {{old('direction') === 'below' ? 'selected' : ''}}>Below</option>
                            </select>

                            @if ($errors->has('direction'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('direction') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Your Alerts
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Price</th>
                        <th>Direction</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($alerts as $alert)
                        <tr>
                            <td>${{ number_format($alert->price, 2) }}</td>
                            <td>{{ ucwords($alert->direction) }}</td>
                            <td>{{ $alert->created_at }}</td>
                            <td class="text-right">
                                <form action="{{ route('alerts.destroy', $alert) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <div class="btn-group btn-group-xs text-nowrap">
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
