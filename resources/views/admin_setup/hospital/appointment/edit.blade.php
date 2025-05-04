<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 60%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
       
         <!-- form start -->
         <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            
            <div class="rows">
                <!--  patient id toggle -->
                <div class="c-12">
                    <div class="form-input-group">
                        <label for="updatePtn_Id">Patient Id</label>
                        <input type="text" name="ptn_id" class="form-input" id="updatePtn_Id">
                        <div id="ptn-list"></div>
                        <span class="error" id="update_ptn_id_error"></span>
                    </div>
                </div>

                <!--Title-->
                <div class="c-2">
                    <div class="form-input-group">
                        <label for="updateTitle">Title</label>
                        <select name="title" id="updateTitle">
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                        </select>
                        <span class="error" id="update_title_error"></span>
                    </div>
                </div>
                
                <!-- Name -->
                <div class="c-10">
                    <div class="form-input-group">
                        <label for="updateName">Name</label>
                        <input type="text" name="name" class="form-input" id="updateName">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                
                <!-- phone -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatePhone">Phone</label>
                        <input type="text" name="ptn_phone" class="form-input" id="updatePhone">
                        <span class="error" id="update_ptn_phone_error"></span>
                    </div>
                </div>

                <!-- email -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateEmail">Email</label>
                        <input type="text" name="email" class="form-input" id="updateEmail">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                <!-- Gender -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateGender">Gender</label>
                        <select name="gender" id="updateGender" class="form-input">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="error" id="update_gender_error"></span>
                    </div>
                </div>

                <!-- Age -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label>Age (Y/M/D)</label>
                        <div class="age-fields" style="display: flex; gap: 5px;">
                            <input type="text" name="age_years" class="form-input" id="age_years" placeholder="Years" value="0">
                            <input type="text" name="age_months" class="form-input" id="age_months" placeholder="Months"
                                min="0" max="12" value="0">
                            <input type="text" name="age_days" class="form-input" id="age_days" placeholder="Days"
                                min="0" max="31" value="0">
                        </div>
                    </div>
                </div>
                

                <!-- Nationality -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateNationality">Nationality</label>
                        <input type="text" name="nationality" class="form-input" id="updateNationality">
                        <span class="error" id="update_nationality_error"></span>
                    </div>
                </div>

                <!-- Religion -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateReligion">Religion</label>
                        <select name="religion" id="updateReligion" class="form-input">
                            <option value="">Select Religion</option>
                            <option value="Islam" checked>Islam</option>
                            <option value="Hinduism">Hinduism</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Jainists">Jainists</option>
                            <option value="Folk religions">Folk religions</option>
                            <option value="Others">Others</option>
                        </select>
                        <span class="error" id="update_religion_error"></span>
                    </div>
                </div>
                
                <!-- Address -->
                <div class="c-12">
                    <div class="form-input-group">
                        <label for="updateAddress">Address</label>
                        <input type="text" name="address" class="form-input" id="updateAddress">
                        <span class="error" id="update_address_error"></span>
                    </div>
                </div>

                <!-- Bed Category -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateBed_Category">Bed Category<span class="required">*</span></label>
                        <input type="text" name="bed_category" class="form-input" id="updateBed_Category"><hr>
                        <div id='update-bed_category'></div>
                        <span class="error" id="update_bed_category_error"></span>
                    </div>
                </div>

                <!-- Bed list -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateBed_List">Bed List<span class="required">*</span></label>
                        <input type="text" name="bed_list" class="form-input" id="updateBed_List"><hr>
                        <div id='update-bed_list'></div>
                        <span class="error" id="update_bed_list_error"></span>
                    </div>
                </div>

                <!-- Doctor -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateDoctor">Doctor<span class="required">*</span></label>
                        <input type="text" name="doctor" class="form-input" id="updateDoctor"><hr>
                        <div id='update-doctor'></div>
                        <span class="error" id="update_doctor_error"></span>
                    </div>
                </div>

                <!-- Sells Representative (SR) ID -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateSr">Sells Representative (SR)<span class="required">*</span></label>
                        <input type="text" name="sr" class="form-input" id="updateSr"><hr>
                        <div id='update-sr'></div>
                        <span class="error" id="update_sr_error"></span>
                    </div>
                </div>
            </div>
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>