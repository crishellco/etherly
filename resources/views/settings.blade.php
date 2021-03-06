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
                                    <input type="checkbox" name="via_email" {{ old('via_email', auth()->user()->via_email) ? 'checked' : '' }}> Enable Email Notifications
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="via_slack" {{ old('via_slack', auth()->user()->via_slack) ? 'checked' : '' }}> Enable Slack Notifications
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
