<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <form id="EditForm" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            {{-- id --}}
            <input type="hidden" name="id" id="id">
            {{-- name --}}
            <div class="form-input-group">
                <label for="update_store_name">Store Name <span class="required" title="Required">*</span></label>
                <input type="text" name="store_name" class="form-input" id="update_store_name">
                <span class="error" id="update_store_name_error"></span>
            </div>
            {{-- division --}}
            <div class="form-input-group">
                <label for="updateDivision">Division <span class="required" title="Required">*</span></label>
                <select name="division" id="updateDivision">

                </select>
                <span class="error" id="update_division_error"></span>
            </div>
            {{-- location --}}
            <div class="form-input-group">
                <label for="updateLocation">Location <span class="required" title="Required">*</span></label>
                <input type="text" name="location" id="updateLocation" class="form-input" autocomplete="off">
                <div id="update-location">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_location_error"></span>
            </div>
            {{-- address --}}
            <div class="form-input-group">
                <label for="updateAddress">Address</label>
                <input type="text" name="address" class="form-input" id="updateAddress">
                <span class="error" id="address_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>