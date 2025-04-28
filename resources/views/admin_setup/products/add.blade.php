<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="post">
            @csrf
            <input type="hidden" name="type" id="type" value="{{ Request::segment(1) }}">
            {{-- name --}}
            <div class="form-input-group">
                <label for="productName">{{ $name }} Name</label>
                <input type="text" name="productName" class="form-input" id="productName">
                <span class="error" id="productName_error"></span>
            </div>
            {{-- groupe --}}
            <div class="form-input-group">
                <label for="groupe">Select Product Groupe</label>
                <select name="groupe" id="groupe">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="groupe_error"></span>
            </div>
            {{-- category --}}
            <div class="form-input-group">
                <label for="category">Category Name</label>
                <input type="text" name="category" class="form-input" id="category" autocomplete="off"><hr>
                <div id='category-list'></div>
                <span class="error" id="category_error"></span>
            </div>
            {{-- manufacturer --}}
            <div class="form-input-group">
                <label for="manufacturer">Manufacture Name</label>
                <input type="text" name="manufacturer" class="form-input" id="manufacturer" autocomplete="off"><hr>
                <div id='manufacturer-list'></div>
                <span class="error" id="manufacturer_error"></span>
            </div>
            {{-- form  --}}
            <div class="form-input-group">
                <label for="form">Product Form Name</label>
                <input type="text" name="form" class="form-input" id="form" autocomplete="off"><hr>
                <div id='form-list'></div>
                <span class="error" id="form_error"></span>
            </div>
            {{-- unit --}}
            <div class="form-input-group">
                <label for="unit">Product Unit Name</label>
                <input type="text" name="unit" class="form-input" id="unit" autocomplete="off"><hr>
                <div id='unit-list'></div>
                <span class="error" id="unit_error"></span>
            </div>
            {{-- company --}}
            @if (auth()->user()->user_role == 1)
                <div class="form-input-group">
                    <label for="company">Company <span class="required" title="Required">*</span></label>
                    <input type="text" name="company" class="form-input" id="company" autocomplete="off"><hr>
                    <div id="company-list"></div>
                    <span class="error" id="company_error"></span>
                </div>
            @else
                <input type="text" name="company" class="form-input" id="company" data-id="{{auth()->user()->company_id}}" style="display: none">
            @endif
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>