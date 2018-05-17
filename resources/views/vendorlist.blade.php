<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IAB Vendor List</title>
    </head>
    <body>
        <h1>IAB Vendor List</h1>
        <ul>
            <li>Vendor List Version: {{ $version }}</li>
            <li>Last Updated: {{ $lastupdated }}</li>
            <li>Total Vendor Count: {{ count($vendorlist) }}</li>
        </ul>
        <table style="width: 100%;">
            <tr>
                <th>Vendor ID</th>
                <th>Vendor Name (links to privacy policy)</th>
                <th>Purposes</th>
                <th>Legitimate Interest Purposes</th>
                <th>Features</th>
            </tr>
            @foreach ($vendorlist as $id => $vendor)
                @if ($id % 2 === 0)
                <tr style="background-color: #eee;">
                @else
                <tr>
                @endif
                    <td>{{ $vendor['id'] }}</td>
                    <td><a href="{{ $vendor['privacy'] }}">{{ $vendor['name'] }}</a></td>
                    <td>
                        <ul>
                        @foreach ($vendor['purposes'] as $value)
                            <li>{{ $value }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                        @foreach ($vendor['legintpurposes'] as $value)
                            <li>{{ $value }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                        @foreach ($vendor['features'] as $value)
                            <li>{{ $value }}</li>
                        @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
