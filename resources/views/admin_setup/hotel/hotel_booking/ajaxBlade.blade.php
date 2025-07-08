@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows" style="align-items:center;">
        <div class="c-3">
            @if(auth()->user()->hasPermission(316))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif
        </div>

        <div class="c-3">
            <label for="startDate">Start Date</label>
            <input type="date" name="startDate" id="startDate" class="form-input" value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
        </div>
        <div class="c-3" >
            <label for="endDate">End Date</label>
            <input type="date" name="endDate" id="endDate" class="form-input" value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
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


@include('admin_setup.hotel.hotel_booking.add')

@include('admin_setup.hotel.hotel_booking.edit')

@include('common_modals.delete')

@include('common_modals.deleteStatus')

<!-- ajax part start from here -->
<script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>