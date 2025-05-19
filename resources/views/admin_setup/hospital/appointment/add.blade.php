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
                        <label for="oldPatient">
                            <input type="radio" name="patient_type" value="old" id="oldPatient">  Old Patient
                        </label>
                        <label for="newPatient">
                            <input type="radio" name="patient_type" value="new" id="newPatient" checked>  New Patient
                        </label>
                    </div>
                </div>
                
                <!--  patient id toggle -->
                <div class="c-12">
                    <div class="togglePatientid" style="display: none;">
                        <div class="form-input-group">
                            <label for="patient">Patient Search</label>
                            <input type="text" name="patient" class="form-input" id="patient" autocomplete="off"><hr>
                            <div id="patient-list"></div>
                            <span class="error" id="patient_id_error"></span>
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
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-input" id="address">
                        <span class="error" id="address_error"></span>
                    </div>
                </div>
                
                <!-- Doctor -->
                <div class="c-12">
                    <div class="form-input-group">
                        <label for="doctor">Doctor<span class="required">*</span></label>
                        <input type="text" name="doctor" class="form-input" id="doctor" autocomplete="off"><hr>
                        <div id='doctor-list'></div>
                        <span class="error" id="doctor_error"></span>
                    </div>
                </div>

                <!-- Date -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="date">Date<span class="required">*</span></label>
                        <input type="date" name="date" class="form-input" id="date">
                        <span class="error" id="date_error"></span>
                    </div>
                </div>

                 <!-- schedule -->
                 <div class="c-4">
                    <div class="form-input-group">
                        <label for="schedule">Schedule</label>
                        <select name="schedule" id="schedule" class="form-input">
                            <option value="">Select schedule</option>
                            <option value="Morining" checked>Morining</option>
                            <option value="Evening">Evening</option>
                           
                        </select>
                        <span class="error" id="schedule_error"></span>
                    </div>
                </div>

                
                <!-- Appointment -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="appointment">Appointment Serial</label>
                        <input type="text" name="appointment" class="form-input" id="appointment">
                        <span class="error" id="appointment_error"></span>
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