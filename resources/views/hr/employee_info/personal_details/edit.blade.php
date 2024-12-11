<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Employee Personal Detail</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
        
        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <!-- Personal Details Section -->
            <div class="rows">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="employee_id" id="employee_id">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_name">Name</label>
                        <input type="text" name="name" id="update_name" class="form-input">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_fathers_name">Father's Name</label>
                        <input type="text" name="fathers_name" id="update_fathers_name" class="form-input">
                        <span class="error" id="update_fathers_name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_mothers_name">Mother's Name</label>
                        <input type="text" name="mothers_name" id="update_mothers_name" class="form-input">
                        <span class="error" id="update_mothers_name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_date_of_birth">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="update_date_of_birth" class="form-input">
                        <span class="error" id="update_date_of_birth_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_gender">Gender</label>
                        <select name="gender" id="update_gender">

                        </select>
                        <span class="error" id="update_gender_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_religion">Religion</label>
                        <select name="religion" id="update_religion">

                        </select>
                        <span class="error" id="update_religion_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_marital_status">Marital Status</label>
                        <select name="marital_status" id="update_marital_status">

                        </select>
                        <span class="error" id="update_marital_status_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_nationality">Nationality</label>
                        <input type="text" name="nationality" id="update_nationality" class="form-input">
                        <span class="error" id="update_nationality_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_nid_no">Nid No.</label>
                        <input type="text" name="nid_no" id="update_nid_no" class="form-input">
                        <span class="error" id="update_nid_no_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_phn_no">Phone No.</label>
                        <input type="text" name="phn_no" id="update_phn_no" class="form-input">
                        <span class="error" id="update_phn_no_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_blood_group">Blood Group</label>
                        <select name="blood_group" id="update_blood_group">

                        </select>
                        <span class="error" id="update_blood_group_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_email">Email</label>
                        <input type="email" name="email" id="update_email" class="form-input">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateLocation">Location</label>
                        <input type="text" name="location" id="updateLocation" class="form-input">
                        <div id="update-location">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_location_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_type">Employee Type</label>
                        <select name="type" id="update_type">
                            {{-- <option value="">Select Employee Type</option>
                            @foreach ($tranwith as $with)
                            <option value="{{$with->id}}">{{$with->tran_with_name}}</option>
                            @endforeach --}}
                        </select>
                        <span class="error" id="update_type_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_address">Address</label>
                        <input type="text" name="address" id="update_address" class="form-input">
                        <span class="error" id="update_address_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateImage">Image</label>
                        <input type="file" name="image" class="form-input" id="updateImage">
                        <span class="error" id="update_image_error"></span>
                        <img src="#" alt="Selected Image" id="updatePreviewImage"
                            style="display: none; width:200px; height:200px;">
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for = "update_password">Password<span class="red">*</span></label>
                        <input type="password" name="password" id="update_password" class="form-input">
                        <span class="error" id="update_password_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Save</button>
            </div>
        </form>
    </div>
</div>