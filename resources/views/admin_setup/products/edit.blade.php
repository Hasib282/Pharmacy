<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post">
            @csrf
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- name --}}
            <div class="form-input-group">
                <label for="updateProductName">{{ $name }} Name</label>
                <input type="text" name="productName" class="form-input" id="updateProductName">
                <span class="error" id="update_productName_error"></span>
            </div>
            {{-- groupe --}}
            <div class="form-input-group">
                <label for="updateGroupe">Select Product Groupe</label>
                <select name="groupe" id="updateGroupe">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="update_groupe_error"></span>
            </div>
            {{-- category --}}
            <div class="form-input-group">
                <label for="updateCategory">Category Name</label>
                <input type="text" name="category" class="form-input" id="updateCategory" data-url="{{ Request::segment(1) }}/setup/category/get" autocomplete="off"><hr>
                <div id='update-category'></div>
                <span class="error" id="update_category_error"></span>
            </div>
            {{-- manufacturer --}}
            <div class="form-input-group">
                <label for="updateManufacturer">Manufacture Name</label>
                <input type="text" name="manufacturer" class="form-input" id="updateManufacturer" data-url="{{ Request::segment(1) }}/setup/manufacturer/get" autocomplete="off"><hr>
                <div id='update-manufacturer'></div>
                <span class="error" id="update_manufacturer_error"></span>
            </div>
            {{-- form  --}}
            <div class="form-input-group">
                <label for="updateForm">Item Form Name</label>
                <input type="text" name="form" class="form-input" id="updateForm" data-url="{{ Request::segment(1) }}/setup/form/get" autocomplete="off"><hr>
                <div id='update-form'></div>
                <span class="error" id="update_form_error"></span>
            </div>
            {{-- unit --}}
            <div class="form-input-group">
                <label for="updateUnit">Unit Name</label>
                <input type="text" name="unit" class="form-input" id="updateUnit" data-url="{{ Request::segment(1) }}/setup/unit/get" autocomplete="off"><hr>
                <div id='update-unit'></div>
                <span class="error" id="update_unit_error"></span>
            </div>
            {{-- quantity --}}
            <div class="form-input-group">
                <label for="updateQuantity">Quantity</label>
                <input type="text" name="quantity" class="form-input" id="updateQuantity">
                <span class="error" id="update_quantity_error"></span>
            </div>
            {{-- cp  --}}
            <div class="form-input-group">
                <label for="updateCp">Cost Price</label>
                <input type="text" name="cp" class="form-input" id="updateCp">
                <span class="error" id="update_cp_error"></span>
            </div>
            {{-- mrp --}}
            <div class="form-input-group">
                <label for="updateMrp">MRP</label>
                <input type="text" name="mrp" class="form-input" id="updateMrp">
                <span class="error" id="update_mrp_error"></span>
            </div>
            {{-- expiry --}}
            <div class="form-input-group">
                <label for="updateExpiryDate">Expiry Date</label>
                <input type="date" name="expiryDate" class="form-input" id="updateExpiryDate">
                <span class="error" id="update_expiryDate_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>