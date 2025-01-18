<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <form id="AddForm" method="post">
            @csrf
            <div class="form-input-group">
                <label for="store_name">Store Name <span class="required" title="Required">*</span></label>
                <input type="text" name="store_name" class="form-input" id="store_name">
                <span class="error" id="store_name_error"></span>
            </div>
            <div class="form-input-group">
                <label for="division">Division <span class="required" title="Required">*</span></label>
                <select name="division" id="division">
                    <option value="">Select Division</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Barishal">Barishal</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Mymensingh">Mymensingh</option>
                </select>
                <span class="error" id="division_error"></span>
            </div>
            <div class="form-input-group">
                <label for="location">Location <span class="required" title="Required">*</span></label>
                <input type="text" name="location" id="location" class="form-input" autocomplete="off">
                <div id="location-list">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="location_error"></span>
            </div>
            <div class="form-input-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-input" id="address">
                <span class="error" id="address_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>