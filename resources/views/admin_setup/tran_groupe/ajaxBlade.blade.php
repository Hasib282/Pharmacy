@php
    $searchValue = request()->query('search');
    $searchMethod = request()->query('method');
    $searchType = request()->query('type');
@endphp


<div class="add-search">
    <div class="rows">
        <div class="c-3">
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
        </div>

        @if (Request::segment(1) == 'admin')
            <div class="c-2">
                <label for="types">Groupe Type</label>
                <select name="types" id="types">
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="methods">Method</label>
                <select name="methods" id="methods">
                    <option value="">Select Method</option>
                    <option value="Receive" {{ $searchMethod == 'Receive' ? 'selected' : '' }}>Receive</option>
                    <option value="Payment" {{ $searchMethod == 'Payment' ? 'selected' : '' }}>Payment</option>
                    <option value="Both" {{ $searchMethod == 'Both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
            <div class="c-5">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        @elseif (Request::segment(1) == 'transaction')
            <div class="c-2">
                <label for="methods">Method</label>
                <select name="methods" id="methods">
                    <option value="">Select Method</option>
                    <option value="Receive" {{ $searchMethod == 'Receive' ? 'selected' : '' }}>Receive</option>
                    <option value="Payment" {{ $searchMethod == 'Payment' ? 'selected' : '' }}>Payment</option>
                    <option value="Both" {{ $searchMethod == 'Both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
            <div class="c-7">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        @else
            <div class="c-9">
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
                <th style="width:4%;">SL:</th>
                <th>{{ $name }} Name</th>
                @if (Request::segment(1) == 'admin')
                    <th>{{ $name }} Type</th>
                    <th>Transaction Method</th>
                @elseif (Request::segment(1) == 'transaction')
                    <th>Transaction Method</th>
                @endif
                @if (UserRole() == 1)
                    <th style="width:12%;">Company Id</th>
                @endif
                <th style="width:12%;">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('admin_setup.tran_groupe.add')

@include('admin_setup.tran_groupe.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
{{-- <script src="{{ asset('js/ajax/admin_setup/tran_groupe.js') }}"></script> --}}
<script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . '/tran_groupe.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>