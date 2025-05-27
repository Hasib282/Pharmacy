<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 60%;padding:0;margin:0 auto;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="booking_id" id="bookingId">
            <fieldset>
                <legend>Guest Details</legend>
                <div class="rows">
                    <!--  guest search toggle -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="guest">Guest Search <span class="required">*</span></label>
                            <input type="text" name="guest" class="input-small" id="guest" autocomplete="off"><hr>
                            <div id="guest-list"></div>
                            <span class="error" id="guest_error"></span>
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
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="input-small" id="phone">
                            <span class="error" id="phone_error"></span>
                        </div>
                    </div>

                    <!-- email -->
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="input-small" id="email">
                            <span class="error" id="email_error"></span>
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
                <legend>Transfer Details</legend>
                <div class="rows">
                    <!-- Bed Category -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="bed_category">Room Category<span class="required">*</span></label>
                            <input type="text" name="bed_category" class="input-small" id="bed_category" autocomplete="off"><hr>
                            <div id='bed_category-list'></div>
                            <span class="error" id="bed_category_error"></span>
                        </div>
                    </div>
                    {{-- From Bed --}}
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="from_bed">From Bed <span class="required" title="Required">*</span></label>
                            <input type="text" name="from_bed" class="input-small" id="from_bed" autocomplete="off">
                            <div id="from_bed-list"></div>
                            <span class="error" id="from_bed_error"></span>
                        </div>
                    </div>
                    <!-- To Bed -->
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="bed_list">To Bed <span class="required">*</span></label>
                            <input type="text" name="bed_list" class="input-small" id="bed_list" autocomplete="off"><hr>
                            <div id='bed_list-list'></div>
                            <span class="error" id="bed_list_error"></span>
                        </div>
                    </div>
                    {{-- Transfer Date --}}
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="transfer">Transfer Date<span class="required">*</span></label>
                            <input type="datetime-local" name="transfer" class="input-small" id="transfer">
                            <span class="error" id="transfer_error"></span>
                        </div>
                    </div>
                    {{-- Transfer By --}}
                    <div class="c-6">
                        <div class="form-input-group">
                            <label for="transfer_by">Transfer By <span class="required" title="Required">*</span></label>
                            <input type="text" name="transfer_by" class="input-small" id="transfer_by" autocomplete="off"><hr>
                            <div id="transfer_by-list"></div>
                            <span class="error" id="transfer_by_error"></span>
                        </div>
                    </div>
                    <div class="c-12">
                        <div class="center">
                            <button type="submit" class="btn-blue" id="Insert">Submit</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>