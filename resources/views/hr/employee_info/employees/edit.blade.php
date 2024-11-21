<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit Employee</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="rows">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="empId" id="empId">
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateName">Name</label>
                        <input type="text" name="name" class="form-input" id="updateName">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateEmail">Email</label>
                        <input type="text" name="email" class="form-input" id="updateEmail">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updatePhone">Phone</label>
                        <input type="text" name="phone" class="form-input" id="updatePhone">
                        <span class="error" id="update_phone_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateGender">Gender</label>
                        <select name="gender" id="updateGender">
                            {{-- options will be display dynamically --}}
                        </select>
                        <span class="error" id="update_gender_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateLocation">Location</label>
                        <input type="text" name="location" class="form-input" id="updateLocation" autocomplete="off">
                        <div id="update-location">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_location_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateType">Type</label>
                        <select name="type" id="updateType">
                            {{-- options will be display dynamically --}}
                        </select>
                        <span class="error" id="update_type_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDepartment">Department</label>
                        <input type="text" name="department" class="form-input" id="updateDepartment"
                            autocomplete="off">
                        <div id="update-department">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_department_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDesignation">Designation</label>
                        <input type="text" name="designation" class="form-input" id="updateDesignation"
                            autocomplete="off">
                        <div id="update-designation">
                            <ul>

                            </ul>
                        </div>
                        <span class="error" id="update_designation_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDob">Date of Birth</label>
                        <input type="date" name="dob" class="form-input" id="updateDob">
                        <span class="error" id="update_dob_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateNid">Nid</label>
                        <input type="text" name="nid" class="form-input" id="updateNid">
                        <span class="error" id="update_nid_error"></span>
                    </div>
                </div>
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateAddress">Address</label>
                        <input type="text" name="address" class="form-input" id="updateAddress">
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
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>