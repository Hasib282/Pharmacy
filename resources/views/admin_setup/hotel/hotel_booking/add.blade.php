<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 60%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- Form Start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            
            <div class="rows">
                <!-- Patient Type Selection -->
                <div class="c-12">
                    <div style="display: flex; gap: 10px; padding: 10px 0;">
                        <label for="oldGuest">
                            <input type="radio" name="guest_type" value="old" id="oldGuest">  Old Guest
                        </label>
                        <label for="newGuest">
                            <input type="radio" name="guest_type" value="new" id="newGuest" checked>  New Guest
                        </label>
                    </div>
                </div>
                
                <!--  patient id toggle -->
                <div class="c-12">
                    <div class="togglePatientid" style="display: none;">
                        <div class="form-input-group">
                            <label for="guest">Guest Search</label>
                            <input type="text" name="guest" class="form-input" id="guest" autocomplete="off"><hr>
                            <div id="guest-list"></div>
                            <span class="error" id="guest_id_error"></span>
                        </div>
                    </div>
                </div>

                <!--Title-->
                <div class="c-2">
                    <div class="form-input-group">
                        <label for="title">Title</label>
                        <select name="title" id="title">
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                        </select>
                        <span class="error" id="title_error"></span>
                    </div>
                </div>
                
                <!-- Name -->
                <div class="c-10">
                    <div class="form-input-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-input" id="name">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                
                <!-- phone -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-input" id="phone">
                        <span class="error" id="phone_error"></span>
                    </div>
                </div>

                <!-- email -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-input" id="email">
                        <span class="error" id="email_error"></span>
                    </div>
                </div>


                 <!-- Nid -->
                 <div class="c-4">
                    <div class="form-input-group">
                        <label for="nid">Nid</label>
                        <input type="text" name="nid" class="form-input" id="nid">
                        <span class="error" id="nid_error"></span>
                    </div>
                </div>


                 <!-- Passport -->
                 <div class="c-4">
                    <div class="form-input-group">
                        <label for="passport">Passport</label>
                        <input type="text" name="passport" class="form-input" id="passport">
                        <span class="error" id="passport_error"></span>
                    </div>
                </div>

                     <!-- Driving lisence -->
                <div class="c-4">
                        <div class="form-input-group">
                            <label for="driving_lisence">Driving Lisence</label>
                            <input type="text" name="driving_lisence" class="form-input" id="driving_lisence">
                            <span class="error" id=driving_lisence_error"></span>
                        </div>
                </div>
    

            

                <!-- Gender -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-input">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="error" id="gender_error"></span>
                    </div>
                </div>

         
                <!-- Nationality -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="nationality">Nationality</label>
                        <input type="text" name="nationality" class="form-input" id="nationality" value="Bangladeshi">
                        <span class="error" id="nationality_error"></span>
                    </div>
                </div>

                <!-- Religion -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="religion">Religion</label>
                        <select name="religion" id="religion" class="form-input">
                            <option value="">Select Religion</option>
                            <option value="Islam" checked>Islam</option>
                            <option value="Hinduism">Hinduism</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Jainists">Jainists</option>
                            <option value="Folk religions">Folk religions</option>
                            <option value="Others">Others</option>
                        </select>
                        <span class="error" id="religion_error"></span>
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
                        <label for="Check_in">check in Date<span class="required">*</span></label>
                        <input type="date" name="Check_in" class="form-input" id="Check_in">
                        <span class="error" id="Check_in_error"></span>
                    </div>
                </div>

                <!-- check out -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="Check_out">check out Date<span class="required">*</span></label>
                        <input type="date" name="Check_out" class="form-input" id="Check_out">
                        <span class="error" id="Check_out_error"></span>
                    </div>
                </div>


                <!-- Adult -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="adult">Adult</label>
                        <input type="text" name="adult" class="form-input" id="adult">
                        <span class="error" id="adult_error"></span>
                    </div>
                </div>


                <!-- children -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="children">Children</label>
                        <input type="text" name="children" class="form-input" id="children">
                        <span class="error" id="children_error"></span>
                    </div>
                </div>




                <!-- status -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="status">Status</label>
                        <label for="status"></label>
                        <select name="status" id="status" class="form-input">
                            <option value="">Select room status</option>
                            <option value="Booking" checked>Booking</option>
                            <option value="Check in">Check in</option>
                            <option value="Check out">Check out</option>
                            <option value="Maintanience">Maintanience</option>
                           
                        </select>
                        <span class="error" id="status_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to Toggle Fields -->
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const newPatientRadio = document.getElementById("newPatient");
        const oldPatientRadio = document.getElementById("oldPatient");
        const newPatientFields = document.getElementById("newPatientFields");
        const oldPatientFields = document.getElementById("oldPatientFields");

        function toggleFields() {
            if (newPatientRadio.checked) {
                newPatientFields.style.display = "block";
                oldPatientFields.style.display = "none";
            } else {
                newPatientFields.style.display = "none";
                oldPatientFields.style.display = "block";
            }
        }

        // Run toggleFields on page load to set correct visibility
        toggleFields();

        newPatientRadio.addEventListener("change", toggleFields);
        oldPatientRadio.addEventListener("change", toggleFields);
    });
</script> --}}