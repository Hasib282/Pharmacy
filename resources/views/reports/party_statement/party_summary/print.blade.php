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
            <th>User Type</th>
            <th>User Name</th>
            <th>Bill Amount</th>
            <th>Discount</th>
            <th>Net Amount</th>
            <th>Receive</th>
            <th>Payment</th>
            <th>Due Col</th>
            <th>Due discount</th>
            <th>Balance / Due</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalBillAmount = 0;
            $totalDiscount = 0;
            $totalNetAmount = 0;
            $totalReceive = 0;
            $totalPayment = 0;
            $totalDueCol = 0;
            $totalDueDiscount = 0;
            $totalDue = 0;
        @endphp

        @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item['tran_type'] == 4 ? '' : $item['withs']['tran_with_name'] }}</td>
                <td>{{ $item['tran_type'] == 4 ? $item['bank']['name'] : $item['user']['user_name'] }}</td>
                <td style="text-align: right;">{{ number_format($item['total_bill_amount'], 0) }}</td>
                <td style="text-align: right;">{{ number_format($item['total_discount'], 0) }}</td>
                <td style="text-align: right;">{{ number_format($item['total_net_amount'], 0) }}</td>
                <td style="text-align: right;">{{ $item['total_receive'] ? number_format($item['total_receive'], 0) : 0 }}</td>
                <td style="text-align: right;">{{ $item['total_payment'] ? number_format($item['total_payment'], 0) : 0 }}</td>
                <td style="text-align: right;">{{ number_format($item['total_due_col'], 0) }}</td>
                <td style="text-align: right;">{{ number_format($item['total_due_disc'], 0) }}</td>
                <td style="text-align: right;">{{ number_format($item['total_due'], 0) }}</td>
            </tr>

            @php
                $totalBillAmount += $item['total_bill_amount'];
                $totalDiscount += $item['total_discount'];
                $totalNetAmount += $item['total_net_amount'];
                $totalReceive += $item['total_receive'];
                $totalPayment += $item['total_payment'];
                $totalDueCol += $item['total_due_col'];
                $totalDueDiscount += $item['total_due_disc'];
                $totalDue += $item['total_due'];
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total:</td>
            <td style="text-align: right;">{{ number_format($totalBillAmount, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalDiscount, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalNetAmount, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalReceive, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalPayment, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalDueCol, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalDueDiscount, 0) }}</td>
            <td style="text-align: right;">{{ number_format($totalDue, 0) }}</td>
        </tr>
    </tfoot>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}