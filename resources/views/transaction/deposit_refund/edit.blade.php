<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 100%; margin: 0; padding: 0;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- groupein --}}
            <div id="updategroupein" style="display: none"></div>
            {{-- id  --}}
            <input type="hidden" name="id" id="id">
            {{-- transaction id  --}}
            <input type="hidden" name="tranId" id="updateTranId">
            <fieldset>
                <legend>Guest Details</legend>
                <div class="rows">
                    {{-- date  --}}
                    <div class="c-3">
                        <div class="form-input-group">
                            <label for="updateDate">Date</label>
                            <input type="text" name="date" class="form-input" id="updateDate"
                                value="{{ date('Y-m-d') }}" disabled>
                        </div>
                    </div>
                    {{-- Guest Search --}}
                    <div class="c-9">
                        <div class="form-input-group">
                            <label for="updateGuest">Guest Search <span class="required">*</span></label>
                            <input type="text" name="guest" class="input-small" id="updateGuest" autocomplete="off">
                            <div id="update-guest"></div>
                            <span class="error" id="update_guest_id_error"></span>
                        </div>
                    </div>
                    <!--Title-->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateTitle">Title</label>
                            <select name="title" id="updateTitle">
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
                    <!-- Address -->
                    <div class="c-12">
                        <div class="form-input-group">
                            <label for="updateAddress">Address</label>
                            <input type="text" name="address" class="form-input" id="updateAddress">
                            <span class="error" id="update_address_error"></span>
                        </div>
                    </div>
                    <!-- Booking Id -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateHotel-booking">Booking Id</label>
                            <input type="text" name="hotel_booking" class="input-small" id="updateHotel-booking" autocomplete="off"><hr>
                            <div id="update-hotel-booking"></div>
                            <span class="error" id="update_booking_id_error"></span>
                        </div>
                    </div>
                    <!-- Check In -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateCheck_in">Check In</label>
                            <input type="datetime-local" name="check_in" class="input-small" id="updateCheck_in">
                        </div>
                    </div>
                    <!-- Checkout -->
                    <div class="c-4">
                        <div class="form-input-group">
                            <label for="updateCheck_out">Checkout Time</label>
                            <input type="datetime-local" name="check_out" class="input-small" id="updateCheck_out">
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="rows">
                    {{-- Services  --}}
                    <div class="c-5">
                        <div class="form-input-group">
                            <label for="updateHead">Services</label>
                            @if (Request::segment(3) == 'deposits')
                                <input type="text" name="head" id="updateHead" class="input-small" autocomplete="off" data-id="9" data-groupe="9" value="Deposit" disabled>
                            @elseif(Request::segment(3) == 'refunds')
                                <input type="text" name="head" id="updateHead" class="input-small" autocomplete="off" data-id="10" data-groupe="9" value="Deposit Refund" disabled>
                            @endif
                            <div id="update-head"></div>
                            <span class="error" id="update_head_error"></span>
                        </div>
                    </div>
                    {{-- quantity --}}
                    <div class="c-1">
                        <div class="form-input-group">
                            <label for="updateQuantity">Qty</label>
                            <input type="text" name="quantity" class="form-input" id="updateQuantity" value="1" disabled>
                            <span class="error" id="update_quantity_error"></span>
                        </div>
                    </div>
                    {{-- price --}}
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateAmount">Price</label>
                            <input type="text" name="amount" class="form-input updateAmount" id="updateAmount">
                            <span class="error" id="update_amount_error"></span>
                        </div>
                    </div>
                    {{-- total --}}
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updateTotAmount">Total</label>
                            <input type="text" name="totAmount" class="form-input" id="updateTotAmount" disabled>
                            <span class="error" id="update_totAmount_error"></span>
                        </div>
                    </div>
                    <!-- Payment Method -->
                    <div class="c-2">
                        <div class="form-input-group">
                            <label for="updatePayment_method">Payment Method</label>
                            <select name="payment_method" id="updatePayment_method" class="input-small">
    
                            </select>
                            <span class="error" id="update_payment_method_error"></span>
                        </div>
                    </div>
                </div>
                <div class="center">
                    <button type="submit" id="Update" class="btn-blue">Submit</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>