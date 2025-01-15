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
@php
    $groupedTransactions = [];

    foreach ($data as $item) {
        $tranId = $item['tran_id'];
        if (!isset($groupedTransactions[$tranId])) {
            $groupedTransactions[$tranId] = [];
        }
        $groupedTransactions[$tranId][] = $item;
    }
@endphp

<table class="show-table">
    <tbody>
        @foreach($groupedTransactions as $tranId => $transactions)
            <tr>
                <td>
                    <table class="show-table" style="margin-top:30px;">
                        <caption style="text-align:center;">{{ $tranId }}</caption>
                        <thead>
                            <tr>
                                <th>Transaction Id</th>
                                <th>Tran User</th>
                                <th>Bill Amount</th>
                                <th>Discount</th>
                                <th>Net Amount</th>
                                <th>Advance</th>
                                <th>Party Discount</th>
                                <th>Party Payment</th>
                                <th>Net Col</th>
                                <th>Balance / Due</th>
                                <th>Batch ID</th>
                                <th>Transaction Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $item)
                                <tr>
                                    <td>{{ $item['tran_id'] }}</td>
                                    <td>{{ $item['tran_type'] === 4 ? $item['bank']['name'] : $item['user']['user_name'] }}</td>
                                    <td>{{ $item['bill_amount'] ?? 0 }}</td>
                                    <td>{{ $item['main_discount'] ?? 0 }}</td>
                                    <td>{{ $item['net_amount'] ?? 0 }}</td>
                                    <td>
                                        @if($item['tran_method'] === "Receive")
                                            {{ $item['main_receive'] ?? 0 }}
                                        @else
                                            {{ $item['main_payment'] ?? 0 }}
                                        @endif
                                    </td>
                                    <td>{{ $item['due_discount'] ?? 0 }}</td>
                                    <td>
                                        @if($item['tran_method'] === "Receive")
                                            {{ $item['due_receive'] ?? 0 }}
                                        @else
                                            {{ $item['due_payment'] ?? 0 }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item['due_receive'] + $item['due_payment'] + $item['due_discount'] }}
                                    </td>
                                    <td>
                                        {{ $item['bill_amount'] - $item['main_discount'] - $item['main_receive'] - $item['main_payment'] - $item['due_discount'] - $item['due_receive'] - $item['due_payment'] }}
                                    </td>
                                    <td>{{ $item['batch_id'] ?? $item['tran_id'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['tran_date'])->toDateString() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}