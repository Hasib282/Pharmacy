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
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- division --}}
            <div class="form-input-group">
                <label for="updateDivision">Division <span class="required" title="Required">*</span></label>
                <select name="division" id="updateDivision">
                    
                </select>
                <span class="error" id="update_division_error"></span>
            </div>
            {{-- district --}}
            <div class="form-input-group">
                <label for="updateDistrict">District <span class="required" title="Required">*</span></label>
                <input type="text" name="district" class="form-input" id="updateDistrict">
                <span class="error" id="update_district_error"></span>
            </div>
            {{-- upazila --}}
            <div class="form-input-group">
                <label for="updateUpazila">Upazila <span class="required" title="Required">*</span></label>
                <input type="text" name="upazila" class="form-input" id="updateUpazila">
                <span class="error" id="update_upazila_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>