@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


    <div class="add-search">
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
                    <th>Title</th>                  
                    <th>Name</th>
                    <th>Degree</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Chamber</th>
                   
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"> </div>
    </div>


    
    @include('admin_setup.hospital.doctor_information.add')

    @include('admin_setup.hospital.doctor_information.edit')
    
    @include('common_modals.delete')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hospital/setup/doctor_information.js') }}"></script>


