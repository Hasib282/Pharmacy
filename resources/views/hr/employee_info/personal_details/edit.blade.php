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
                {{-- id  --}}
                <input type="hidden" name="id" id="id">
                {{-- employee id  --}}
                <input type="hidden" name="employee_id" id="employee_id">
                {{-- type --}}
                <div class="c-6">  
                    <div class="form-input-group">   
                        <label for="updateType">Employee Type <span class="required" title="Required">*</span></label>
                        <select name="type" id="updateType">
                            
                        </select>
                        <span class="error" id="update_type_error"></span>
                    </div>
                </div>
                {{-- name --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateName">Name <span class="required" title="Required">*</span></label>
                        <input type="text" name="name" id="updateName" class="form-input">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                {{-- fathers name --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_fathers_name">Father's Name</label>
                        <input type="text" name="fathers_name" id="update_fathers_name" class="form-input">
                        <span class="error" id="update_fathers_name_error"></span>
                    </div>
                </div>
                {{-- mothers name --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_mothers_name">Mother's Name</label>
                        <input type="text" name="mothers_name" id="update_mothers_name" class="form-input">
                        <span class="error" id="update_mothers_name_error"></span>
                    </div>
                </div>
                {{-- Date of Birth --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_dob">Date of Birth</label>
                        <input type="date" name="dob" id="update_dob" class="form-input">
                        <span class="error" id="update_dob_error"></span>
                    </div>
                </div>
                {{-- Grnder --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_gender">Gender <span class="required" title="Required">*</span></label>
                        <select name="gender" id="update_gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                        <span class="error" id="update_gender_error"></span>
                    </div>
                </div>
                {{-- religion --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_religion">Religion <span class="required" title="Required">*</span></label>
                        <select name="religion" id="update_religion">
                            <option value="Islam">Islam</option>
                            <option value="Hinduism">Hinduism</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Judaism ">Judaism</option>
                        </select>
                        <span class="error" id="update_religion_error"></span>
                    </div>
                </div>
                {{-- marital status --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_marital_status">Marital Status <span class="required" title="Required">*</span></label>
                        <select name="marital_status" id="update_marital_status">
                            <option value="Unmarried">Unmarried</option>
                            <option value="Married">Married</option>
                        </select>
                        <span class="error" id="update_marital_status_error"></span>
                    </div>
                </div>
                {{-- nationality --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_nationality">Nationality</label>
                        <input type="text" name="nationality" id="update_nationality" class="form-input">
                        <span class="error" id="update_nationality_error"></span>
                    </div>
                </div>
                {{-- nid no --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_nid_no">Nid No</label>
                        <input type="text" name="nid_no" id="update_nid_no" class="form-input">
                        <span class="error" id="update_nid_no_error"></span>
                    </div>
                </div>
                {{-- phone no  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_phn_no">Phone No <span class="required" title="Required">*</span></label>
                        <input type="text" name="phn_no" id="update_phn_no" class="form-input">
                        <span class="error" id="update_phn_no_error"></span>
                    </div>
                </div>
                {{-- email  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_email">Email <span class="required" title="Required">*</span></label>
                        <input type="email" name="email" id="update_email" class="form-input">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                {{-- division --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDivision">Division <span class="required" title="Required">*</span></label>
                        <select name="division" id="updateDivision">
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
                        <span class="error" id="update_division_error"></span>
                    </div>
                </div>
                {{-- location --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateLocation">Location <span class="required" title="Required">*</span></label>
                        <input type="text" name="location" id="updateLocation" class="form-input" autocomplete="off"><hr>
                        <div id="update-location"></div>
                        <span class="error" id="update_location_error"></span>
                    </div>
                </div>
                {{-- address  --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_address">Address</label>
                        <input type="text" name="address" id="update_address" class="form-input">
                        <span class="error" id="update_address_error"></span>
                    </div>
                </div>
                {{-- blood groupe --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="update_blood_group">Blood Group</label>
                        <select name="blood_group" id="update_blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                        <span class="error" id="update_blood_group_error"></span>
                    </div>
                </div>
                {{-- image --}}
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateImage">Image</label>
                        <input type="file" name="image" class="form-input" id="updateImage">
                        <span class="error" id="update_image_error"></span>
                        <img src="#" alt="Selected Image" id="updatePreviewImage"
                            style="display: none; width:200px; height:200px;">
                    </div>
                </div>
                {{-- <div class="c-6">
                    <div class="form-input-group">
                        <label for = "update_password">Password<span class="red">*</span></label>
                        <input type="password" name="password" id="update_password" class="form-input">
                        <span class="error" id="update_password_error"></span>
                    </div>
                </div> --}}
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Save</button>
            </div>
        </form>
    </div>
</div>