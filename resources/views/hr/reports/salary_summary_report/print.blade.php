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
            <th style="width:10%">Id</th>
            <th style="width:50%">Employee Name</th>
            <th style="width:20%">Salary Amount</th>
            <th style="width:16%">Process Date</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalAmount = 0;
        @endphp

        @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->tran_user }}</td>
                <td>{{ $item->user->user_name }}</td>
                <td style="text-align:right;">{{ number_format($item->bill_amount, 0, '.', ',') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tran_date)->format('Y-m-d') }}</td>
            </tr>
            
            @php
                $totalAmount += $item->bill_amount;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total:</td>
            <td style="text-align:right;">{{ number_format($totalAmount, 0, '.', ',') }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}