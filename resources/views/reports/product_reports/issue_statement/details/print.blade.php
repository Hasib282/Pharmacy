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
            <th>Id</th>
            <th>User</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>CP</th>
            <th>MRP</th>
            <th>Total CP</th>
            <th>Total MRP</th>
            <th>Discount</th>
            <th>Profit</th>
            <th>Batch Id</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalQuantity = 0;
            $totalCP = 0;
            $totalMrp = 0;
            $totalCostPrice = 0;
            $totalMaximumRetailPrice = 0;
            $totalDiscount = 0;
            $totalProfit = 0;
        @endphp

        @foreach($data as $key => $item)
            @php
                $quantityTotal = $item->quantity + $item->quantity_return;
                $costPriceTotal = $quantityTotal * $item->cp;
                $mrpTotal = $quantityTotal * $item->mrp;
                $profit = $mrpTotal - $costPriceTotal - $item->discount;

                $totalQuantity += $quantityTotal;
                $totalCP += $item->cp;
                $totalMrp += $item->mrp;
                $totalCostPrice += $costPriceTotal;
                $totalMaximumRetailPrice += $mrpTotal;
                $totalDiscount += $item->discount;
                $totalProfit += $profit;
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->tran_id }}</td>
                <td>{{ $item->user->user_name }}</td>
                <td>{{ $item->head->tran_head_name }}</td>
                <td style="text-align: right;">{{ number_format($quantityTotal, 0, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($item->cp, 0, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($item->mrp, 0, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($costPriceTotal, 0, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($mrpTotal, 0, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($item->discount, 0, '.', ',') }}</td>
                <td style="text-align: right;">{{ number_format($profit, 0, '.', ',') }}</td>
                <td>{{ $item->batch_id }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tran_date)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Total:</td>
            <td style="text-align: right;">{{ number_format($totalQuantity, 0, '.', ',') }}</td>
            <td style="text-align: right;">{{ number_format($totalCP, 0, '.', ',') }}</td>
            <td style="text-align: right;">{{ number_format($totalMrp, 0, '.', ',') }}</td>
            <td style="text-align: right;">{{ number_format($totalCostPrice, 0, '.', ',') }}</td>
            <td style="text-align: right;">{{ number_format($totalMaximumRetailPrice, 0, '.', ',') }}</td>
            <td style="text-align: right;">{{ number_format($totalDiscount, 0, '.', ',') }}</td>
            <td style="text-align: right;">{{ number_format($totalProfit, 0, '.', ',') }}</td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}