<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 40%;">
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
            <input type="hidden" id="id" name="id">

            <div class="rows">
                <!--Title-->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateTitle">Title</label>
                        <input type="text" name="title" class="form-input" id="updateTitle">
                        <span class="error" id="update_title_error"></span>
                    </div>
                </div>
                <!-- Name -->
                <div class="c-8">
                    <div class="form-input-group">
                        <label for="updateName">Name</label>
                        <input type="text" name="name" class="form-input" id="updateName">
                        <span class="error" id="update_name_error"></span>
                    </div>
                </div>
                <!-- phone -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updatePhone">Phone</label>
                        <input type="text" name="phone" class="form-input" id="updatePhone">
                        <span class="error" id="update_phone_error"></span>
                    </div>
                </div>
                <!-- email -->
                <div class="c-6">
                    <div class="form-input-group">
                        <label for="updateEmail">Email</label>
                        <input type="text" name="email" class="form-input" id="updateEmail">
                        <span class="error" id="update_email_error"></span>
                    </div>
                </div>
                <!-- Age -->
                <div class="c-12">
                    <div class="form-input-group">
                        <label>Age</label>
                        <div class="age-fields" style="display: flex; gap: 5px;">
                            <input type="number" name="age_years" class="form-input" id="updateAge_years" placeholder="Years"
                                min="1950">
                            <input type="number" name="age_months" class="form-input" id="updateAge_months" placeholder="Months"
                                min="1" max="12">
                            <input type="number" name="age_days" class="form-input" id="updateAge_days" placeholder="Days"
                                min="1" max="31">
                        </div>
                    </div>
                </div>
                <!-- Gender -->
                <div class="c-4">
                    <div class="form-input-group">
                        <label for="updateGender">Gender</label>
                        <select name="gender" id="updateGender" class="form-input">
                            <option value="">-- Select Gender --</option>
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
                        <input type="text" name="religion" class="form-input" id="updateReligion">
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
            </div>
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>