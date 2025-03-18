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
                    <div class="form-input-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-input" id="phone">
                        <span class="error" id="phone_error"></span>
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
                            <input type="number" name="age_years" class="form-input" id="age_years" placeholder="Years"
                                min="1950">
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
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>