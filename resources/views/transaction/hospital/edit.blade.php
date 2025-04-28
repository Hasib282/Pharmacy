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
            <div class="rows">
                <div class="c-6">
                    {{-- groupein --}}
                    <div id="updategroupein" style="display: none"></div>
                    {{-- id  --}}
                    <input type="hidden" name="id" id="id">
                    {{-- transaction id  --}}
                    <input type="hidden" name="tranId" id="updateTranId">
                    <div class="rows">
                        {{-- date  --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="updateDate">Date</label>
                                <input type="text" name="date" class="form-input" id="updateDate"
                                    value="{{ date('Y-m-d') }}" disabled>
                            </div>
                        </div>
                        {{-- patient Search --}}
                        <div class="c-9">
                            <div class="form-input-group">
                                <label for="updatePatient">Patient Search</label>
                                <input type="text" name="patient" class="form-input" id="updatePatient" autocomplete="off"><hr>
                                <div id="update-patient"></div>
                                <span class="error" id="update_ptn_id_error"></span>
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
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updatePhone">Phone</label>
                                <input type="text" name="phone" class="form-input" id="updatePhone">
                                <span class="error" id="update_phone_error"></span>
                            </div>
                        </div>

                        <!-- email -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateEmail">Email</label>
                                <input type="text" name="email" class="form-input" id="updateEmail">
                                <span class="error" id="update_email_error"></span>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateGender">Gender</label>
                                <select name="gender" id="updateGender" class="form-input">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <span class="error" id="update_gender_error"></span>
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
                                <label for="updateNationality">Nationality</label>
                                <input type="text" name="nationality" class="form-input" id="updateNationality" value="Bangladeshi">
                                <span class="error" id="update_nationality_error"></span>
                            </div>
                        </div>

                        <!-- Religion -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateReligion">Religion</label>
                                <select name="religion" id="updateReligion" class="form-input">
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
                                <input type="text" name="address" class="form-input" id="updateAddress">
                                <span class="error" id="update_address_error"></span>
                            </div>
                        </div>
                        {{-- Services  --}}
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="updateHead">Services</label>
                                <input type="text" name="head" id="updateHead" class="form-input" autocomplete="off"><hr>
                                <div id="update-head"></div>
                                <span class="error" id="update_head_error"></span>
                            </div>
                        </div>
                        {{-- quantity --}}
                        <div class="c-1">
                            <div class="form-input-group">
                                <label for="updateQuantity">Qty</label>
                                <input type="text" name="quantity" class="form-input" id="updateQuantity" value="1">
                                <span class="error" id="update_quantity_error"></span>
                            </div>
                        </div>
                        {{-- price --}}
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="updateAmount">Price</label>
                                <input type="text" name="amount" class="form-input" id="updateAmount">
                                <span class="error" id="update_amount_error"></span>
                            </div>
                        </div>
                        {{-- total --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="updateTotAmount">Total</label>
                                <input type="text" name="totAmount" class="form-input" id="updateTotAmount" disabled>
                                <span class="error" id="update_totAmount_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="UpdateTransaction" class="btn-blue">Add</button>
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
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Action</th>
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
                                    <td><label for="updateAmountRP">Invoice Amount</label></td>
                                    <td><input type="text" name="amountRP" class="input-small" id="updateAmountRP" value="0"
                                            disabled style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="updateTotalDiscount">Discount</label></td>
                                    <td><input type="text" name="totalDiscount" class="input-small" id="updateTotalDiscount"
                                            value="0" style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="updateNetAmount">Net Amount</label>
                                    <td><input type="text" name="netAmount" class="input-small" id="updateNetAmount" value="0"
                                            disabled style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="updateAdvance">Advance</label>
                                    <td><input type="text" name="advance" class="input-small" id="updateAdvance" value="0"
                                            style="text-align: right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="updateBalance">Balance</label>
                                    <td><input type="text" name="balance" class="input-small" id="updateBalance" value="0"
                                            disabled style="text-align: right;"></td>
                                </tr>
                            </table>
                            <div class="center">
                                <span class="error" id="update_discount_error"></span>
                                <span class="error" id="update_advance_error"></span>
                                <span class="error" id="update_message_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c-6">
                    
                </div>
            </div>
            {{--  end of row --}}
            <div class="center">
                <button id="UpdateMain" class="btn-blue" style="margin-top: 10px;">Update</button>
            </div>
        </form>
    </div>
</div>