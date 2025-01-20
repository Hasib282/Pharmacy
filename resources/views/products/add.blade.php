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
            <div class="form-input-group">
                <label for="productName">{{ $name }} Name</label>
                <input type="text" name="productName" class="form-input" id="productName">
                <span class="error" id="productName_error"></span>
            </div>
            <div class="form-input-group">
                <label for="groupe">Select Product Groupe</label>
                <select name="groupe" id="groupe">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="groupe_error"></span>
            </div>
            <div class="form-input-group">
                <label for="category">Category Name</label>
                <input type="text" name="category" class="form-input" id="category"  data-url="{{ env('API_URL') }}/pharmacy/setup/category/get" autocomplete="off">
                <div id='category-list'>
                    <ul>

                    </ul>
                </div>
                <span class="error" id="category_error"></span>
            </div>
            <div class="form-input-group">
                <label for="manufacturer">Manufacture Name</label>
                <input type="text" name="manufacturer" class="form-input" id="manufacturer"  data-url="{{ env('API_URL') }}/pharmacy/setup/manufacturer/get" autocomplete="off">
                <div id='manufacturer-list'>
                    <ul>

                    </ul>
                </div>
                <span class="error" id="manufacturer_error"></span>
            </div>
            <div class="form-input-group">
                <label for="form">Product Form Name</label>
                <input type="text" name="form" class="form-input" id="form"  data-url="{{ env('API_URL') }}/pharmacy/setup/form/get" autocomplete="off">
                <div id='form-list'>
                    <ul>

                    </ul>
                </div>
                <span class="error" id="form_error"></span>
            </div>
            <div class="form-input-group">
                <label for="unit">Product Unit Name</label>
                <input type="text" name="unit" class="form-input" id="unit"  data-url="{{ env('API_URL') }}/pharmacy/setup/unit/get" autocomplete="off">
                <div id='unit-list'>
                    <ul>

                    </ul>
                </div>
                <span class="error" id="unit_error"></span>
            </div>
            @if (auth()->user()->user_role == 1)
                <div class="form-input-group">
                    <label for="company">Company <span class="required" title="Required">*</span></label>
                    <input type="text" name="company" class="form-input" id="company" autocomplete="off">
                    <div id="company-list">
                        <ul>

                        </ul>
                    </div>
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