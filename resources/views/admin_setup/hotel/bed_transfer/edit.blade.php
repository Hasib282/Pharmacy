<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 60%;padding:0;margin:0 auto;">
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
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="booking_id" id="updateBookingId">
            <fieldset>
                <legend>Guest Details</legend>
                <div class="rows">
                    <!--  guest search -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="updateGuest">Guest Search <span class="required">*</span></label>
                            <input type="text" name="guest" class="input-small" id="updateGuest" autocomplete="off">
                            <div id="update-guest"></div>
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
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="updatePhone">Phone</label>
                            <input type="text" name="ptn_phone" class="input-small" id="updatePhone">
                            <span class="error" id="update_ptn_phone_error"></span>
                        </div>
                    </div>
    
                    <!-- email -->
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="updateEmail">Email</label>
                            <input type="text" name="email" class="input-small" id="updateEmail">
                            <span class="error" id="update_email_error"></span>
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
                <legend>Transfer Details</legend>
                <div class="rows">
                    <!-- Bed Category -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="updateBed_Category">Bed Category<span class="required">*</span></label>
                            <input type="text" name="bed_category" class="input-small" id="updateBed_Category"><hr>
                            <div id='update-bed_category'></div>
                            <span class="error" id="update_bed_category_error"></span>
                        </div>
                    </div>
                    {{-- From Bed --}}
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="updateFrom_bed">From Bed <span class="required" title="Required">*</span></label>
                            <input type="text" name="from_bed" class="form-input" id="updateFrom_bed" autocomplete="off"><hr>
                            <span class="error" id="update_from_bed_error"></span>
                        </div>
                    </div>
                    <!-- To Bed -->
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="updateBed_List">To Bed<span class="required">*</span></label>
                            <input type="text" name="bed_list" class="input-small" id="updateBed_List"><hr>
                            <div id='update-bed_list'></div>
                            <span class="error" id="update_bed_list_error"></span>
                        </div>
                    </div>
                    {{-- Transfer Date --}}
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="updateTransfer">Check In<span class="required">*</span></label>
                            <input type="datetime-local" name="transfer" class="input-small" id="updateTransfer">
                            <span class="error" id="update_transfer_error"></span>
                        </div>
                    </div>
                    {{-- Transfer By --}}
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="updateTransfer_by">Transfer By <span class="required" title="Required">*</span></label>
                            <input type="text" name="transfer_by" class="form-input" id="updateTransfer_by" autocomplete="off"><hr>
                            <div id="update-transfer_by"></div>
                            <span class="error" id="update_transfer_by_error"></span>
                        </div>
                    </div>
                    <div class="c-12">
                        <div class="center">
                            <button type="submit" class="btn-blue" id="Update">Update</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>