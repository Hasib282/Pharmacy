@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


{{-- <div class="add-search">
    <div class="rows">
        <div class="c-3">
            @if(Auth::user()->hasPermissionToRoute('insert.payrollMiddlewire'))
            <button class="open-modal add" data-modal-id="addModal">Add Payroll Middlewire</button>
            @endif
        </div>
        <div class="c-2">
            <label for="optionMonth">Month</label>
            <select name="month" id="optionMonth">
                <option value="01" {{ date('m')=='01' ? 'selected' : '' }}>January</option>
                <option value="02" {{ date('m')=='02' ? 'selected' : '' }}>February</option>
                <option value="03" {{ date('m')=='03' ? 'selected' : '' }}>March</option>
                <option value="04" {{ date('m')=='04' ? 'selected' : '' }}>April</option>
                <option value="05" {{ date('m')=='05' ? 'selected' : '' }}>May</option>
                <option value="06" {{ date('m')=='06' ? 'selected' : '' }}>June</option>
                <option value="07" {{ date('m')=='07' ? 'selected' : '' }}>July</option>
                <option value="08" {{ date('m')=='08' ? 'selected' : '' }}>August</option>
                <option value="09" {{ date('m')=='09' ? 'selected' : '' }}>September</option>
                <option value="10" {{ date('m')=='10' ? 'selected' : '' }}>October</option>
                <option value="11" {{ date('m')=='11' ? 'selected' : '' }}>November</option>
                <option value="12" {{ date('m')=='12' ? 'selected' : '' }}>December</option>
            </select>
        </div>
        <div class="c-1">
            <label for="optionYear">Year</label>
            <select name="year" id="optionYear">
                @for ($year = date('Y')+10; $year >= 2000; $year--)
                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="c-2">
            <div class="form-group">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption" style="width: 100%;margin: 0;">
                    <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>User Name</option>
                    <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Head</option>
                </select>
            </div>
        </div>
        <div class="c-4">
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;margin: 0;">
            </div>
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Additional Payroll Middlewire</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Employee Id</th>
                <th>Employee Name</th>
                <th>Payroll Category</th>
                <th>Amount</th>
                <th>Month</th>
                <th>Year</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div> --}}


{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
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


@include('hr.payroll.payroll_middlewire.add')

@include('hr.payroll.payroll_middlewire.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/hr/payroll/payroll_middlewire.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>