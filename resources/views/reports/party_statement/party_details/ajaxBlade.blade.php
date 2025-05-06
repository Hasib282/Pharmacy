@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $searchMethodValue = request()->query('method');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp



{{-- <div class="add-search">
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
            <label for="methodOption">Method</label>
            <select name="methodOption" id="methodOption">
                <option value="">Select Method</option>
                <option value="Receive" {{ $searchMethodValue=='Receive' ? 'selected' : '' }}>Receive</option>
                <option value="Payment" {{ $searchMethodValue=='Payment' ? 'selected' : '' }}>Payment</option>
                <option value="Purchase" {{ $searchMethodValue=='Purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="Issue" {{ $searchMethodValue=='Issue' ? 'selected' : '' }}>Issue</option>
                <option value="Client Return" {{ $searchMethodValue=='Client Return' ? 'selected' : '' }}>Client Return</option>
                <option value="Supplier Return" {{ $searchMethodValue=='Supplier Return' ? 'selected' : '' }}>Supplier Return</option>
            </select>
        </div>
        <div class="c-2">
            <label for="searchOption">Search Option</label>
            <select name="searchOption" id="searchOption">
                <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Transaction User</option>
                <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Transaction Id</option>
            </select>
        </div>
        <div class="c-3">
            <label for="search">Search Here</label>
            <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
        </div>
        <div class="c-1">
            <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Party Details Report</caption>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div> --}}


{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows" style="align-items:center;">
        <div class="c-3"></div>
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
            <label for="methodOption">Method</label>
            <select name="methodOption" id="methodOption">
                <option value="">Select Method</option>
                <option value="Receive" {{ $searchMethodValue=='Receive' ? 'selected' : '' }}>Receive</option>
                <option value="Payment" {{ $searchMethodValue=='Payment' ? 'selected' : '' }}>Payment</option>
                <option value="Purchase" {{ $searchMethodValue=='Purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="Issue" {{ $searchMethodValue=='Issue' ? 'selected' : '' }}>Issue</option>
                <option value="Client Return" {{ $searchMethodValue=='Client Return' ? 'selected' : '' }}>Client Return</option>
                <option value="Supplier Return" {{ $searchMethodValue=='Supplier Return' ? 'selected' : '' }}>Supplier Return</option>
            </select>
        </div>
        <div class="c-1"></div>
        <div class="c-1">
            <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
        </div>
        <div class="c-1"></div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption>Party Details Report</caption>
        <thead></thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div id="paginate"></div>
</div>


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/report/party_statement/party_details_report.js') }}"></script>