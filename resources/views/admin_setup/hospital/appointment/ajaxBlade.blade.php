@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                
              @if(auth()->user()->hasPermission(375))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif
            </div>
            <div class="c-9 search">
                <select name="searchOption" id="searchOption" class="select-small">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Name</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Floor</option>
                  
                </select>
                <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">{{ $name }}</caption>
            <thead>
                <tr>
                    <th>SL:</th> 
                    <th>Registration id</th>
                    <th>Paitent id</th>
                    <th>Bed list</th>
                    <th>Doctor id</th>
                    <th>Sells_representative(SR)</th>                   
                    <th>Addmission by</th>  
                    <th>Addmission date</th>
                     <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"> </div>
    </div> --}}

    
    {{-- Add Button And Search Fields --}}
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                     @if(auth()->user()->hasPermission(375))
                        <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
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

    
    @include('admin_setup.hospital.appointment.add')

    @include('admin_setup.hospital.appointment.edit')
    
    @include('common_modals.delete')

    @include('common_modals.deleteStatus')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hospital/setup/appointment.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>