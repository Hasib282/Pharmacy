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
                <label for="division">Division <span class="required" title="Required">*</span></label>
                <select name="division" id="division">
                    <option value="">Select Division</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Barishal">Barisal</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Mymensingh">Mymensingh</option>
                </select>
                <span class="error" id="division_error"></span>
            </div>
            <div class="form-input-group">
                <label for="district">District <span class="required" title="Required">*</span></label>
                <input type="text" name="district" class="form-input" id="district">
                <span class="error" id="district_error"></span>
            </div>
            <div class="form-input-group">
                <label for="upazila">Upazila <span class="required" title="Required">*</span></label>
                <input type="text" name="upazila" class="form-input" id="upazila">
                <span class="error" id="upazila_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>