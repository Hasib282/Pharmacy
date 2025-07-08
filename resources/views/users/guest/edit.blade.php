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
                        <input type="text" name="phone" class="input-small" id="updatePhone">
                        <span class="error" id="update_phone_error"></span>
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
            
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Update</button>
            </div>
        </form>
    </div>
</div>