<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 100%;margin:0;padding:0;">
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

            <!-- Patient Type Selection -->
            <div style="display: flex; gap: 10px; padding: 10px 0;">
                <label for="oldGuest">
                    <input type="radio" name="guest_type" value="old" id="oldGuest"> Old Guest
                </label>
                <label for="newGuest">
                    <input type="radio" name="guest_type" value="new" id="newGuest" checked> New Guest
                </label>
                <label for="corporateGuest">
                    <input type="radio" name="guest_type" value="corporate" id="corporateGuest"> Corporate Guest
                </label>
            </div>

            <fieldset>
                <legend>Booking Details</legend>
                <div class="rows">
                    <!-- check in -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="check_in">Check In<span class="required">*</span></label>
                            <input type="datetime-local" name="check_in" class="input-small" id="check_in">
                            <span class="error" id="check_in_error"></span>
                        </div>
                    </div>

                    <!-- check out -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="check_out">Check Out</label>
                            <input type="datetime-local" name="check_out" class="input-small" id="check_out">
                            <span class="error" id="check_out_error"></span>
                        </div>
                    </div>
                    <!-- Booking Reference (SR) ID -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="sr">Booking Reference (SR)</label>
                            <input type="text" name="sr" class="input-small" id="sr" autocomplete="off"><hr>
                            <div id='sr-list'></div>
                            <span class="error" id="sr_error"></span>
                        </div>
                    </div>
                    <!-- status -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="status">Status <span class="required">*</span></label>
                            <select name="status" id="status" class="input-small">
                                <option value="">Select room status</option>
                                <option value="2" selected>Booking</option>
                                <option value="1">Check in</option>
                                <option value="0">Check out</option>
                                <option value="3">Maintanience</option>
                            </select>
                            <span class="error" id="status_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Room Details</legend>
                <div class="rows">
                    <!-- Bed Category -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="bed_category">Room Category<span class="required">*</span></label>
                            <input type="text" name="bed_category" class="input-small" id="bed_category" autocomplete="off"><hr>
                            <div id='bed_category-list'></div>
                            <span class="error" id="bed_category_error"></span>
                        </div>
                    </div>
    
                    <!-- Bed list -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="bed_list">Room No<span class="required">*</span></label>
                            <input type="text" name="bed_list" class="input-small" id="bed_list" autocomplete="off"><hr>
                            <div id='bed_list-list'></div>
                            <span class="error" id="bed_list_error"></span>
                        </div>
                    </div>
                    <!-- Adult -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="adult">Adult <span class="required">*</span></label>
                            <input type="number" name="adult" class="input-small" id="adult" value="0">
                            <span class="error" id="adult_error"></span>
                        </div>
                    </div>
                    <!-- children -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="children">Children <span class="required">*</span></label>
                            <input type="number" name="children" class="input-small" id="children" value="0">
                            <span class="error" id="children_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Guest Details</legend>
                <div class="rows">
                    <!--  guest search toggle -->
                    <div class="c-12">
                        <div class="toggleGuestid" style="display: none;">
                            <div class="form-input-group">
                                <label for="guest">Guest Search <span class="required">*</span></label>
                                <input type="text" name="guest" class="input-small" id="guest" autocomplete="off"><hr>
                                <div id="guest-list"></div>
                                <span class="error" id="guest_error"></span>
                            </div>
                        </div>
                    </div>

                    <!--Title-->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="title">Title</label>
                            <select name="title" id="title" class="input-small">
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
                            <input type="text" name="name" class="input-small" id="name">
                            <span class="error" id="name_error"></span>
                        </div>
                    </div>

                    <!-- phone -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="input-small" id="phone">
                            <span class="error" id="phone_error"></span>
                        </div>
                    </div>

                    <!-- email -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="input-small" id="email">
                            <span class="error" id="email_error"></span>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="input-small">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="error" id="gender_error"></span>
                        </div>
                    </div>

                    <!-- Religion -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="religion">Religion</label>
                            <select name="religion" id="religion" class="input-small">
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

                    <!-- Nationality -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="nationality">Nationality</label>
                            <input type="text" name="nationality" class="input-small" id="nationality" value="Bangladeshi">
                            <span class="error" id="nationality_error"></span>
                        </div>
                    </div>

                    <!-- Nid -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="nid">Nid</label>
                            <input type="text" name="nid" class="input-small" id="nid">
                            <span class="error" id="nid_error"></span>
                        </div>
                    </div>

                    <!-- Passport -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="passport">Passport</label>
                            <input type="text" name="passport" class="input-small" id="passport">
                            <span class="error" id="passport_error"></span>
                        </div>
                    </div>

                    <!-- Driving lisence -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="driving_lisence">Driving Lisence</label>
                            <input type="text" name="driving_lisence" class="input-small" id="driving_lisence">
                            <span class="error" id="driving_lisence_error"></span>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="input-small" id="address">
                            <span class="error" id="address_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Payment Part</legend>
                <div class="rows">
                    <!-- Service Name -->
                    {{-- <div class="c-3">
                        <div class="form-input-group">
                            <label for="service_name">Service Name</label>
                            <input type="text" name="service_name" class="input-small" id="service_name" readonly>
                            <span class="error" id="service_name_error"></span>
                        </div>
                    </div> --}}
                    <!-- Total Amount -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="total">Bed Charge</label>
                            <input type="number" name="total" class="input-small" id="total" readonly value="0">
                            <span class="error" id="total_error"></span>
                        </div>
                    </div>
                    <!-- Discount -->
                    <div class="c-1">
                        <div class="form-input-group">
                            <label for="discount">Discount</label>
                            <input type="number" name="discount" class="input-small" id="discount" min="0" max="100" value="0">
                            <span class="error" id="discount_error"></span>
                        </div>
                    </div>
                    <!-- Advance -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="advance">Advance</label>
                            <input type="number" name="advance" class="input-small" id="advance" value="0">
                            <span class="error" id="advance_error"></span>
                        </div>
                    </div>
                    <!-- Balance -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="balance">Balance</label>
                            <input type="number" name="balance" class="input-small" id="balance" readonly value="0">
                            <span class="error" id="balance_error"></span>
                        </div>
                    </div>
                    <!-- Payment Method -->
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="input-small">
    
                            </select>
                            <span class="error" id="payment_method_error"></span>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
    </div>
</div>