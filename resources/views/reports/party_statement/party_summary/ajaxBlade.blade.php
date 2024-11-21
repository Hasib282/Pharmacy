@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $searchTypeValue = request()->query('type');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp



<div class="add-search">
    <div class="rows">
        <div class="c-2">
            <label for="startDate">Start Date</label>
            <input type="date" name="startDate" id="startDate" class="form-input"
                value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
        </div>
        <div class="c-2">
            <label for="endDate">End Date</label>
            <input type="date" name="endDate" id="endDate" class="form-input"
                value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
        </div>
        <div class="c-2">
            <label for="typeOption">Transaction Type</label>
            <select name="typeOption" id="typeOption">
                <option value="">Select type</option>
                <option value="Receive" {{ $searchTypeValue=='Receive' ? 'selected' : '' }}>Receive</option>
                <option value="Payment" {{ $searchTypeValue=='Payment' ? 'selected' : '' }}>Payment</option>
            </select>
        </div>
        <div class="c-2">
            <label for="searchOption">Search Option</label>
            <select name="searchOption" id="searchOption">
                <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Transaction User</option>
                <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Transaction With</option>
            </select>
        </div>
        <div class="c-3">
            <label for="search">Search Here</label>
            <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
        </div>
        <div class="c-1">
            <div class="print-button">
                <button class="btn btn-primary waves-effect waves-light" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Party Summary Report</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Tran With</th>
                <th>Tran User</th>
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
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/report/party_statement/party_summary_report.js') }}"></script>