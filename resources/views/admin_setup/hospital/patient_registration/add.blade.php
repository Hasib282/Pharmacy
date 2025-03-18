<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
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
                            <label for="ptn_id">Patient Id</label>
                            <input type="text" name="ptn_id" class="form-input" id="ptn_id">
                            <span class="error" id="ptn_id_error"></span>
                        </div>
                    </div>
                </div>

                <!--Title-->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-input" id="title">
                        <span class="error" id="title_error"></span>
                    </div>
                </div>
                
                <!-- Name -->
                <div class="c-8">
                    <div class="form-input-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-input" id="name">
                        <span class="error" id="name_error"></span>
                    </div>
                </div>
                
                <!-- phone -->
                <div class="c-6">
                    <div class="togglePatientid" style="display: none;">
                        <div class="form-input-group">
                            <label for="ptn_phone">Phone</label>
                            <input type="text" name="ptn_phone" class="form-input" id="ptn_phone">
                            <span class="error" id="ptn_phone_error"></span>
                        </div>
                    </div>
                    <div id="togglePhone">
                        <div class="form-input-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-input" id="phone">
                            <span class="error" id="phone_error"></span>
                        </div>
                    </div>
                </div>

                <!-- email -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-input" id="email">
                        <span class="error" id="email_error"></span>
                    </div>
                </div>

                <!-- Age -->
                <div class="c-12">
                    <div class="form-input-group">
                        <label>Age</label>
                        <div class="age-fields" style="display: flex; gap: 5px;">
                            <input type="number" name="age_years" class="form-input" id="age_years" placeholder="Years">
                            <input type="number" name="age_months" class="form-input" id="age_months" placeholder="Months"
                                min="1" max="12">
                            <input type="number" name="age_days" class="form-input" id="age_days" placeholder="Days"
                                min="1" max="31">
                        </div>
                    </div>
                </div>
                
                <!-- Gender -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-input">
                            <option value="">-- Select Gender --</option>
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
                        <input type="text" name="nationality" class="form-input" id="nationality">
                        <span class="error" id="nationality_error"></span>
                    </div>
                </div>

                <!-- Religion -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="religion">Religion</label>
                        <input type="text" name="religion" class="form-input" id="religion">
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

                <!-- Bed Category -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="bed_category">Bed Category<span class="required">*</span></label>
                        <input type="text" name="bed_category" class="form-input" id="bed_category">
                        <div id='bed_category-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="bed_category_error"></span>
                    </div>
                </div>

                <!-- Bed list -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="bed_list">Bed List<span class="required">*</span></label>
                        <input type="text" name="bed_list" class="form-input" id="bed_list">
                        <div id='bed_list-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="bed_list_error"></span>
                    </div>
                </div>

                <!-- Doctor -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="doctor">Doctor<span class="required">*</span></label>
                        <input type="text" name="doctor" class="form-input" id="doctor">
                        <div id='doctor-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="doctor_error"></span>
                    </div>
                </div>

                <!-- Sells Representative (SR) ID -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="sr">Sells Representative (SR)<span class="required">*</span></label>
                        <input type="text" name="sr" class="form-input" id="sr">
                        <div id='sr-list'>
                            <ul>
        
                            </ul>
                        </div>
                        <span class="error" id="sr_error"></span>
                    </div>
                </div>

                <!-- Admission By -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="addmission_by">Admission By</label>
                        <input type="text" name="addmission_by" class="form-input" id="addmission_by">
                        <span class="error" id="admission_error"></span>
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