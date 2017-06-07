@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Settings</div>

            <div class="panel-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ route('settings.store') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('threshold_percent') || $errors->has('threshold_price') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Thresholds</label>

                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-addon">%</div>
                                <input type="text" class="form-control" name="threshold_percent" value="{{ old('threshold_percent', auth()->user()->threshold_percent) }}">
                            </div>

                            @if ($errors->has('threshold_percent'))
                            <span class="help-block">
                                <strong>{{ $errors->first('threshold_percent') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input type="text" class="form-control" name="threshold_price" value="{{ old('threshold_price', auth()->user()->threshold_price) }}">
                            </div>

                            @if ($errors->has('threshold_price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('threshold_price') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('slack_webhook') ? ' has-error' : '' }}">
                        <label for="slack_webhook" class="col-md-4 control-label">Slack Webhook</label>

                        <div class="col-md-8">
                            <input id="slack_webhook" type="text" class="form-control" name="slack_webhook" value="{{ old('slack_webhook', auth()->user()->slack_webhook) }}">

                            @if ($errors->has('slack_webhook'))
                                <span class="help-block">
                                <strong>{{ $errors->first('slack_webhook') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="notifications_enabled" {{ old('notifications_enabled', auth()->user()->notifications_enabled) ? 'checked' : '' }}> Enable Slack & Email Notifications
                                </label>
                            </div>
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
    </div>
@endsection
