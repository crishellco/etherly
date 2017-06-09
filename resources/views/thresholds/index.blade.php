@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create Threshold
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('thresholds.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('minutes') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Minutes</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="minutes" value="{{ old('minutes') }}" required autofocus>

                            @if ($errors->has('minutes'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('minutes') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('percent') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Percent</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="percent" value="{{ old('percent') }}">

                            @if ($errors->has('percent'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('percent') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Price</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="price" value="{{ old('price') }}">

                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
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
                Your Thresholds
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-right">Minutes</th>
                        <th class="text-right">Percent</th>
                        <th class="text-right">Price</th>
                        <th>Created</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($thresholds as $threshold)
                        <tr>
                            <td class="text-right">{{ $threshold->minutes }}</td>
                            <td class="text-right">{{ $threshold->percent ? number_format($threshold->percent, 2) . '%' : 'n/a' }}</td>
                            <td class="text-right">{{ $threshold->price ? '$' . number_format($threshold->price, 2) : 'n/a' }}</td>
                            <td>{{ $threshold->created_at }}</td>
                            <td class="text-right">
                                <form action="{{ route('thresholds.destroy', $threshold) }}" method="POST">
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
