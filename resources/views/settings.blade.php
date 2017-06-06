@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Settings</div>

                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('settings.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-3 control-label">Name</label>

                                <div class="col-md-9">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('threshold') ? ' has-error' : '' }}">
                                <label for="threshold" class="col-md-3 control-label">Threshold</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <div class="input-group-addon">%</div>
                                        <input id="threshold" type="text" class="form-control" name="threshold" value="{{ old('threshold', Auth::user()->threshold) }}" required>
                                    </div>

                                    @if ($errors->has('threshold'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('threshold') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('slack_webhook') ? ' has-error' : '' }}">
                                <label for="slack_webhook" class="col-md-3 control-label">Slack Webhook</label>

                                <div class="col-md-9">
                                    <input id="slack_webhook" type="text" class="form-control" name="slack_webhook" value="{{ old('slack_webhook', Auth::user()->slack_webhook) }}">

                                    @if ($errors->has('slack_webhook'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('slack_webhook') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="notifications_enabled" {{ old('notifications_enabled', Auth::user()->notifications_enabled) ? 'checked' : '' }}> Enable Slack & Email Notifications
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
        </div>
    </div>
@endsection
