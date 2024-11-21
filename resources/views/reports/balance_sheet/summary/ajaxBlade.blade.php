@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $searchMethodValue = request()->query('method');
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
            <label for="methodOption">Transaction method</label>
            <select name="methodOption" id="methodOption">
                <option value="">Select method</option>
                <option value="Receive" {{ $searchMethodValue=='Receive' ? 'selected' : '' }}>Receive</option>
                <option value="Payment" {{ $searchMethodValue=='Payment' ? 'selected' : '' }}>Payment</option>
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
    <div class="opening" style="display: flex; gap: 5px; align-items: center; margin-bottom: 5px; justify-content: center;">
        <label for="opening">Opening Balance</label>
        <input type="text" name="opening" id="opening" disabled>
    </div>
    <table class="show-table">
        <thead>
            <caption class="caption">Summary Balance Sheet</caption>
            <tr>
                <th>SL:</th>
                <th>Id</th>
                <th>User Name</th>
                <th>Receive</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div>

<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/report/summary_balance_sheet.js') }}"></script>