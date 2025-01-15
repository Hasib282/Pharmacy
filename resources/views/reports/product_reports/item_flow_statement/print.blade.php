{{----------------------------------------------------- Common Part Of The Report Starts From Here -------------------------------------}}
<style>
    .show-table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    .show-table td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 2px 4px;
    }
</style>

<div style="text-align: center; width: 100%; margin: 0 auto;">
    <p style="margin-bottom: 10px;font-size:25px;">
        <strong>{{ auth()->user()->company ? auth()->user()->company->company_name : 'Team-Solutions-Bangladesh' }}</strong>
    </p>
    <p style="margin: 0 auto; max-width: 35%;">
        {{ auth()->user()->company ? auth()->user()->company->address : '12th floor, 28 Kazi Nazrul Islam Ave, Banglamotor, Dhaka 1000' }} <br>
        Phone no: {{ auth()->user()->company ? auth()->user()->company->company_phone : '01314353560' }}
    </p>
    <p style="margin-top: 10px;">
        <strong style="font-size: 25px;">{{ $report_name }}</strong> <br>
    </p>
    <p>
        <strong>As on:</strong>
        @if($start_date == $end_date)
             {{ $start_date }}
        @else
            {{ $start_date }} - {{ $end_date }}
        @endif
    </p>
</div>

{{----------------------------------------------------- Common Part Of The Report Ends At Here -----------------------------------------}}



{{----------------------------------------------------- Dynamic Part Of The Report Starts From Here ------------------------------------}}
<table class="show-table">
    <thead>
        <tr>
            <th style="width:4%">SL:</th>
            <th style="width:20%">Status</th>
            <th style="width:10%">Receive</th>
            <th style="width:10%">Issue</th>
            <th style="width:10%">Supplier Return</th>
            <th style="width:10%">Client Return</th>
            <th style="width:10%">Balance</th>
            <th style="width:14%">Tran Id</th>
            <th style="width:12%">Date</th>
        </tr>
    </thead>
    <tbody>
        @php
            $balance = $openingBalance;
        @endphp

        <tr>
            <td></td>
            <td>Opening Balance</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right">{{ number_format($openingBalance, 0, '.', ',') }}</td>
            <td></td>
            <td></td>
        </tr>

        @foreach($data as $key => $item)
            @php
                if ($item->tran_method == "Purchase") {
                    $balance += $item->quantity_actual;
                } elseif ($item->tran_method == "Issue") {
                    $balance -= $item->quantity_actual;
                } elseif ($item->tran_method == "Supplier Return") {
                    $balance -= $item->quantity_actual;
                } elseif ($item->tran_method == "Client Return") {
                    $balance += $item->quantity_actual;
                } elseif ($item->tran_method == "Positive") {
                    $balance += $item->quantity_actual;
                } elseif ($item->tran_method == "Negative") {
                    $balance -= $item->quantity_actual;
                }
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->tran_method }}</td>
                <td style="text-align: right;">{{ in_array($item->tran_method, ['Purchase', 'Positive']) ? number_format($item->quantity_actual, 0, '.', ',') : 0 }}</td>
                <td style="text-align: right;">{{ in_array($item->tran_method, ['Issue', 'Negative']) ? number_format($item->quantity_actual, 0, '.', ',') : 0 }}</td>
                <td style="text-align: right;">{{ $item->tran_method == "Supplier Return" ? number_format($item->quantity_actual, 0, '.', ',') : 0 }}</td>
                <td style="text-align: right;">{{ $item->tran_method == "Client Return" ? number_format($item->quantity_actual, 0, '.', ',') : 0 }}</td>
                <td style="text-align: right;">{{ number_format($balance, 0, '.', ',') }}</td>
                <td>{{ $item->tran_id }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tran_date)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}