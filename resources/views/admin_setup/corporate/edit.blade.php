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
            @method('PUT')
            {{-- id --}}
            <input type="hidden" name="id" id="id">
           
            {{-- name --}}
            <div class="form-input-group">
                <label for="updateName">Corporate Name<span class="required" title="Required">*</span></label>
                <input type="text" name="name" class="form-input" id="updateName">
                <span class="error" id="update_name_error"></span>
            </div>
            {{-- price --}}
            <div class="form-input-group">
                <label for="updatePrice">Discount Rate</label>
                <input type="text" name="price" class="form-input" id="updatePrice" value="0">
                <span class="error" id="update_price_error"></span>
            </div>

            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>