<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 100%; margin: 0; padding: 0;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="rows">
                <div class="c-6" style="margin-bottom: 10px;">
                    {{-- groupein --}}
                    <div id="groupein" style="display: none"></div>
                    <fieldset>
                        <legend>Guest Details</legend>
                        <div class="rows">
                            {{-- date  --}}
                            <div class="c-3">
                                <div class="form-input-group">
                                    <label for="date">Date</label>
                                    <input type="text" name="date" class="input-small" id="date" value="{{ date('Y-m-d') }}"
                                        readonly>
                                </div>
                            </div>
                            <!--  guest search toggle -->
                            <div class="c-9">
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
                            <!-- Booking Id -->
                            <div class="c-4">
                                <div class="form-input-group">
                                    <label for="hotel-booking">Booking Id</label>
                                    <input type="text" name="hotel_booking" class="input-small" id="hotel-booking" autocomplete="off"><hr>
                                    <div id="hotel-booking-list"></div>
                                    <span class="error" id="hotel_booking_error"></span>
                                </div>
                            </div>
                            <!-- Check In -->
                            <div class="c-4">
                                <div class="form-input-group">
                                    <label for="check_in">Check In</label>
                                    <input type="datetime-local" name="check_in" class="input-small" id="check_in">
                                </div>
                            </div>
                            <!-- Checkout -->
                            <div class="c-4">
                                <div class="form-input-group">
                                    <label for="check_out">Checkout Time</label>
                                    <input type="datetime-local" name="check_out" class="input-small" id="check_out">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="rows">
                            {{-- Services  --}}
                            <div class="c-7">
                                <div class="form-input-group">
                                    <label for="head">Services</label>
                                    <input type="text" name="head" id="head" class="input-small" autocomplete="off"><hr>
                                    <div id="head-list"></div>
                                    <span class="error" id="head_error"></span>
                                </div>
                            </div>
                            {{-- quantity --}}
                            <div class="c-1">
                                <div class="form-input-group">
                                    <label for="quantity">QTY</label>
                                    <input type="text" name="quantity" class="input-small" id="quantity" value="1">
                                    <span class="error" id="quantity_error"></span>
                                </div>
                            </div>
                            {{-- price --}}
                            <div class="c-2">
                                <div class="form-input-group">
                                    <label for="amount">Price</label>
                                    <input type="text" name="amount" class="input-small amount" id="amount">
                                    <span class="error" id="amount_error"></span>
                                </div>
                            </div>
                            {{-- total --}}
                            <div class="c-2">
                                <div class="form-input-group">
                                    <label for="totAmount">Total</label>
                                    <input type="text" name="totAmount" class="input-small" id="totAmount" disabled>
                                    <span class="error" id="totAmount_error"></span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="center">
                        <button type="submit" id="InsertTransaction" class="btn-blue">Add</button>
                    </div>
                </div>
                {{-- transaction grid part start --}}
                <div class="c-6">
                    <div class="cols">
                        <div class="transaction_grid" style="overflow-x:auto;">
                            <table class="show-table">
                                <thead>
                                    <tr>
                                        <th>SL:</th>
                                        <th>Name</th>
                                        <th>QTY</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
    
                                </tbody>
                            </table>
                        </div>
                        {{-- invoice calculation part start --}}
                        <div>
                            <table>
                                <tr>
                                    <td><label for="amountRP">Invoice Amount</label></td>
                                    <td><input type="text" name="amountRP" class="input-small" id="amountRP" value="0" disabled
                                            style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="totalDiscount">Discount</label></td>
                                    <td><input type="text" name="totalDiscount" class="input-small" id="totalDiscount" value="0"
                                            style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="netAmount">Net Amount</label>
                                    <td><input type="text" name="netAmount" class="input-small" id="netAmount" value="0"
                                            disabled style="text-align: right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="advance">Advance</label>
                                    <td><input type="text" name="advance" class="input-small" id="advance" value="0"
                                            style="text-align: right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="balance">Balance</label>
                                    <td><input type="text" name="balance" class="input-small" id="balance" value="0" disabled
                                            style="text-align: right;"></td>
                                </tr>
                            </table>
                            <div class="center" style="margin-top: 10px;">
                                <span class="error" id="discount_error"></span>
                                <span class="error" id="advance_error"></span>
                                <span class="error" id="message_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end of rows --}}
            <div class="center">
                <button id="InsertMain" class="btn-blue" style="margin-top: 10px;">Submit</button>
            </div>
        </form>
    </div>
</div>