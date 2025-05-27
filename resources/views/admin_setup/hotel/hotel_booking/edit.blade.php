<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;padding:0;">
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

            {{-- id  --}}
            <input type="hidden" name="id" id="id">

            <fieldset>
                <legend>Booking Details</legend>
                <div class="rows">
                    <!-- check in -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateCheck_in">Check In<span class="required">*</span></label>
                            <input type="datetime-local" name="check_in" class="input-small" id="updateCheck_in">
                            <span class="error" id="update_check_in_error"></span>
                        </div>
                    </div>

                    <!-- check out -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateCheck_out">Check Out<span class="required">*</span></label>
                            <input type="datetime-local" name="check_out" class="input-small" id="updateCheck_out">
                            <span class="error" id="update_check_out_error"></span>
                        </div>
                    </div>
                    <!-- Booking Reference (SR) ID -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateSR">Booking Reference (SR)</label>
                            <input type="text" name="sr" class="input-small" id="updateSR"><hr>
                            <div id='update-sr'></div>
                            <span class="error" id="update_sr_error"></span>
                        </div>
                    </div>
                    <!-- status -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateStatus">Status</label>
                            <select name="status" id="updateStatus" class="input-small">
                                <option value="">Select room status</option>
                                <option value="2">Booking</option>
                                <option value="1">Check in</option>
                                <option value="0">Check out</option>
                                <option value="3">Maintanience</option>
                            </select>
                            <span class="error" id="update_status_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Room Details</legend>
                <div class="rows">
                    <!-- Bed Category -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateBed_Category">Room Category<span class="required">*</span></label>
                            <input type="text" name="bed_category" class="input-small" id="updateBed_Category"><hr>
                            <div id='update-bed_category'></div>
                            <span class="error" id="update_bed_category_error"></span>
                        </div>
                    </div>
                    <!-- Bed list -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateBed_List">Bed List<span class="required">*</span></label>
                            <input type="text" name="bed_list" class="input-small" id="updateBed_List"><hr>
                            <div id='update-bed_list'></div>
                            <span class="error" id="update_bed_list_error"></span>
                        </div>
                    </div>
                    <!-- Bed Charge -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateTotal">Bed Charge</label>
                            <input type="number" name="total" class="input-small" id="updateTotal" readonly value="0">
                            <span class="error" id="update_total_error"></span>
                        </div>
                    </div>
                    <!-- Adult -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateAdult">Adult <span class="required">*</span></label>
                            <input type="text" name="adult" class="input-small" id="updateAdult">
                            <span class="error" id="update_adult_error"></span>
                        </div>
                    </div>
                    <!-- children -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateChildren">Children <span class="required">*</span></label>
                            <input type="text" name="children" class="input-small" id="updateChildren">
                            <span class="error" id="update_children_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Guest Details</legend>
                <div class="rows">
                    <!--  guest search -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="updateGuest-all">Guest Search <span class="required">*</span></label>
                            <input type="text" name="guest" class="input-small" id="updateGuest-all" autocomplete="off">
                            <div id="update-guest-all"></div>
                            <span class="error" id="update_guest_error"></span>
                        </div>
                    </div>
    
                    <!--Title-->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateTitle">Title</label>
                            <select name="title" id="updateTitle" class="input-small">
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
                            <input type="text" name="name" class="input-small" id="updateName">
                            <span class="error" id="update_name_error"></span>
                        </div>
                    </div>
    
                    <!-- phone -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updatePhone">Phone</label>
                            <input type="text" name="ptn_phone" class="input-small" id="updatePhone">
                            <span class="error" id="update_ptn_phone_error"></span>
                        </div>
                    </div>
    
                    <!-- email -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateEmail">Email</label>
                            <input type="text" name="email" class="input-small" id="updateEmail">
                            <span class="error" id="update_email_error"></span>
                        </div>
                    </div>
    
                    <!-- Nid -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateNid">Nid</label>
                            <input type="text" name="nid" class="input-small" id="updateNid">
                            <span class="error" id="update_nid_error"></span>
                        </div>
                    </div>
    
    
                    <!-- Passport -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updatePassport">Passport</label>
                            <input type="text" name="passport" class="input-small" id="updatePassport">
                            <span class="error" id="update_passport_error"></span>
                        </div>
                    </div>
    
                    <!-- Driving lisence -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateDriving_lisence">Driving Lisence</label>
                            <input type="text" name="driving_lisence" class="input-small" id="updateDriving_lisence">
                            <span class="error" id="update_driving_lisence_error"></span>
                        </div>
                    </div>
    
                    <!-- Gender -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateGender">Gender</label>
                            <select name="gender" id="updateGender" class="input-small">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="error" id="update_gender_error"></span>
                        </div>
                    </div>
    
                    <!-- Nationality -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateNationality">Nationality</label>
                            <input type="text" name="nationality" class="input-small" id="updateNationality">
                            <span class="error" id="update_nationality_error"></span>
                        </div>
                    </div>
    
                    <!-- Religion -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateReligion">Religion</label>
                            <select name="religion" id="updateReligion" class="input-small">
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
                            <input type="text" name="address" class="input-small" id="updateAddress">
                            <span class="error" id="update_address_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Payment Part</legend>
                <div class="rows">
                    <!-- Advance -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateAdvance">Advance</label>
                            <input type="number" name="advance" class="input-small" id="updateAdvance" value="0">
                            <span class="error" id="update_advance_error"></span>
                        </div>
                    </div>
                    <!-- Payment Method -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updatePayment_method">Payment Method</label>
                            <select name="payment_method" id="updatePayment_method" class="input-small">
    
                            </select>
                            <span class="error" id="update_payment_method_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Submit</button>
            </div>
        </form>
    </div>
</div>