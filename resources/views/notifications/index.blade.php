@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Your Notifications
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-right">Price @ Analysis</th>
                        <th class="text-right">Historical Price</th>
                        <th>Percent Change</th>
                        <th class="text-right">Price Change</th>
                        <th>Threshold Percent</th>
                        <th class="text-right">Threshold Price</th>
                        <th>Sent</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td class="text-right">${{ number_format($notification->currentPrice->price, 2) }}</td>
                            <td class="text-right">${{ number_format($notification->historicalPrice->price, 2) }}</td>
                            <td>{{ $notification->percent_change }}%</td>
                            <td class="text-right">${{ number_format($notification->price_change, 2) }}</td>
                            <td>{{ $notification->threshold_percent }}%</td>
                            <td class="text-right">${{ number_format($notification->threshold_price, 2) }}</td>
                            <td>{{ $notification->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
