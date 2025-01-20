@php
    $searchValue = request()->query('search');
    $searchMethod = request()->query('method');
    $searchRole = request()->query('role');
@endphp


<div class="add-search">
    <div class="rows">
        <div class="c-2">
            {{-- @if(Auth::user()->hasPermissionToRoute('insert.tranwith')) --}}
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            {{-- @endif --}}
        </div>

        @if(Request::segment(1) == 'hr')
            <div class="c-9">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        @elseif(Request::segment(1) == 'transaction' || Request::segment(1) == 'inventory' || Request::segment(1) == 'pharmacy')
            <div class="c-2">
                <label for="roles">User Role</label>
                <select name="roles" id="roles">
                    <option value="">All</option>
                    <option value="4" {{ $searchRole == '4' ? 'selected' : '' }}>Client</option>
                    <option value="5"{{ $searchRole == '5' ? 'selected' : '' }}>Supplier</option>
                </select>
            </div>
            <div class="c-2">
                <label for="methods">Method</label>
                <select name="methods" id="methods">
                    <option value="">All</option>
                    <option value="Receive" {{ $searchMethod == 'Receive' ? 'selected' : '' }}>Receive</option>
                    <option value="Payment"{{ $searchMethod == 'Payment' ? 'selected' : '' }}>Payment</option>
                    <option value="Both" {{ $searchMethod == 'Both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
            <div class="c-6">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        @else
            <div class="c-2">
                <label for="roles">User Role</label>
                <select name="roles" id="roles">
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="types">Tran Type</label>
                <select name="types" id="types">
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="methods">Method</label>
                <select name="methods" id="methods">
                    <option value="">All</option>
                    <option value="Receive" {{ $searchMethod == 'Receive' ? 'selected' : '' }}>Receive</option>
                    <option value="Payment"{{ $searchMethod == 'Payment' ? 'selected' : '' }}>Payment</option>
                    <option value="Both" {{ $searchMethod == 'Both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
            <div class="c-4">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        @endif
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">{{ $name }} Details</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Tran With Name</th>
                @if (Request::segment(1) != 'hr')
                    <th>User Type</th>
                    <th>Transaction Method</th>
                @elseif (Request::segment(1) == 'admin')
                    <th>Transaction Type</th>
                @endif
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('admin_setup.tran_with.add')

@include('admin_setup.tran_with.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . (Request::segment(1) == 'hr' ? '/employee_info' : '/users') .'/tran_with.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>