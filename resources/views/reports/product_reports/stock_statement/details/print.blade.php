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
            <th>Batch Id</th>
            <th>Product Name</th>
            <th>Category Name</th>
            <th>Manufacturer</th>
            <th>Item Form</th>
            <th>QTY</th>
            <th>Unit</th>
            <th>CP</th>
            <th>MRP</th>
            <th>Expiry</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->tran_id }}</td>
                <td>{{ $item->head->tran_head_name }}</td>
                <td>{{ $item->head->category_id ? $item->head->category->category_name : '' }}</td>
                <td>{{ $item->head->manufecturer_id ? $item->head->manufecturer->manufacturer_name : '' }}</td>
                <td>{{ $item->head->form_id ? $item->head->form->form_name : '' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->unit_id == null ? '' : $item->unit->unit_name }}</td>
                <td>{{ $item->cp }}</td>
                <td>{{ $item->mrp }}</td>
                <td>{{ \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{----------------------------------------------------- Dynamic Part Of The Report Ends At Here ----------------------------------------}}