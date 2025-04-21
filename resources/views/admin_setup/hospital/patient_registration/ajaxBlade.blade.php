@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
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


    
    @include('admin_setup.hospital.patient_registration.add')

    @include('admin_setup.hospital.patient_registration.edit')
    
    @include('common_modals.delete')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hospital/setup/patient_registration.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>