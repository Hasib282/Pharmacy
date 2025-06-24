@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


{{-- <div class="add-search">
    <div class="rows">
        <div class="c-3">
               @if(auth()->user()->hasPermission(109))
                    <button id="PayrollProcess" data-modal-id="confirmModal"><i class="fa-solid fa-rotate"></i> Process Payroll</button>
                @endif
        </div>
        <div class="c-1">
            <label for="month">Month</label>
            <input type="text" name="month" class="form-input" id="month" data-id="{{ date('m') }}"
                value="{{ date('F') }}" readonly>
        </div>
        <div class="c-1">
            <label for="year">Year</label>
            <input type="text" name="year" class="form-input" id="year" value="{{ date('Y') }}" readonly>
        </div>
        <div class="c-6">
            <label for="search">Search</label>
            <input type="text" name="search" id="search" class="form-input" placeholder="Search Employee here..."
                value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;margin: 0;">
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Payroll / Salary Payment</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Employee Id</th>
                <th>Employee Name</th>
                <th>Total Salary</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
</div> --}}

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            
                @if(auth()->user()->hasPermission(109))
                    <button id="PayrollProcess" data-modal-id="confirmModal"><i class="fa-solid fa-rotate"></i> Process Payroll</button>
                @endif
         
        </div>
        <div class="c-6">

        </div>
        <div class="c-3" style="padding: 0;">
            <input type="text" id="globalSearch" placeholder="Search..." />
        </div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption>{{ $name }} Details</caption>
        <thead></thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div id="paginate"></div>
</div>


@include('hr.payroll.payroll_installment.editPayroll')

@include('hr.payroll.payroll_installment.process')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/hr/payroll/payroll.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>