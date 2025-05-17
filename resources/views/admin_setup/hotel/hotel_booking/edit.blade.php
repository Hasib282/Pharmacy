<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 60%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="rows">
                {{-- id  --}}
                <input type="hidden" name="id" id="id">
                <!--  patient id -->
                <div class="c-12">
                    <div class="form-input-group">
                        <label for="updatePatient">Guest Id</label>
                        <input type="text" name="patient" class="form-input" id="updatePatient" autocomplete="off">
                        <div id="update-patient"></div>
                        <span class="error" id="update_patient_error"></span>
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

                <!-- Nid -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatenid">Nid</label>
                        <input type="text" name="nid" class="form-input" id="updateNid">
                        <span class="error" id="update_nid_error"></span>
                    </div>
                </div>


                <!-- Passport -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatepassport">Passport</label>
                        <input type="text" name="passport" class="form-input" id="updatepassport">
                        <span class="error" id="update_passport_error"></span>
                    </div>
                </div>

                <!-- Driving lisence -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatelisence">Driving Lisence</label>
                        <input type="text" name="driving_lisence" class="form-input" id="update_lisence">
                        <span class="error" id=update_lisence_error"></span>
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



                <!-- check in -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateDate_in">check in Date<span class="required">*</span></label>
                        <input type="date" name="date" class="form-input" id="updateDate_in">
                        <span class="error" id="update_date_in_error"></span>
                    </div>
                </div>

                <!-- check out -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateDate_out">check out Date<span class="required">*</span></label>
                        <input type="date" name="date" class="form-input" id="updateDate_out">
                        <span class="error" id="update_date_out_error"></span>
                    </div>
                </div>

                <!-- Adult -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateadult">Adult</label>
                        <input type="text" name="adult" class="form-input" id="updateadult">
                        <span class="error" id="update_adult_error"></span>
                    </div>
                </div>


                <!-- children -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatechildren">Children</label>
                        <input type="text" name="children" class="form-input" id="updatechildren">
                        <span class="error" id="update_children_error"></span>
                    </div>
                </div>


                <!-- status -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updatestatus">Status</label>
                        <select name="status" id="updatestatus" class="form-input">
                            <option value="">Select room status</option>

                            <option value="Booking" checked>Booking</option>
                            <option value="Check in">Check in</option>
                            <option value="Check out">Check out</option>
                            <option value="Maintanience">Maintanience</option>

                        </select>
                        <span class="error" id="update_schedule_error"></span>
                    </div>
                </div>








                <div class="center">
                    <button type="submit" class="btn-blue" id="Update">Submit</button>
                </div>
        </form>
    </div>
</div>
