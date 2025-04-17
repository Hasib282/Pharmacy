<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 70%; margin:0 auto;">
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
                {{-- <div class="c-6"> --}}
                    <div id="within" style="display: none"> </div>
                    <div id="groupein" style="display: none"></div>
                    <div class="rows">
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    readonly>
                            </div>
                        </div>
                        <!--  patient id toggle -->
                        <div class="c-9">
                            <div class="form-input-group">
                                <label for="patient">Patient Search</label>
                                <input type="text" name="patient" class="form-input" id="patient" autocomplete="off"><hr>
                                <div id="patient-list"></div>
                                <span class="error" id="patient_id_error"></span>
                            </div>
                        </div>

                        <!--Title-->
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="title">Title</label>
                                <select name="title" id="title">
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
                                <input type="text" name="name" class="form-input" id="name">
                                <span class="error" id="name_error"></span>
                            </div>
                        </div>
                        
                        <!-- phone -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-input" id="phone">
                                <span class="error" id="phone_error"></span>
                            </div>
                        </div>

                        <!-- email -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-input" id="email">
                                <span class="error" id="email_error"></span>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-input">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <span class="error" id="gender_error"></span>
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
                                <label for="nationality">Nationality</label>
                                <input type="text" name="nationality" class="form-input" id="nationality" value="Bangladeshi">
                                <span class="error" id="nationality_error"></span>
                            </div>
                        </div>

                        <!-- Religion -->
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="religion">Religion</label>
                                <select name="religion" id="religion">
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
                        
                        <!-- Address -->
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-input" id="address">
                                <span class="error" id="address_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="head">Transaction Head</label>
                                <input type="text" name="head" id="head" class="form-input" autocomplete="off">
                                <div id="head-list"></div>
                                <span class="error" id="head_error"></span>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="quantity" value="1">
                                <span class="error" id="quantity_error"></span>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" class="form-input amount" id="amount">
                                <span class="error" id="amount_error"></span>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="discount">Discount</label>
                                <input type="text" name="discount" class="form-input discount" id="discount">
                                <span class="error" id="discount_error"></span>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="totAmount">Total</label>
                                <input type="text" name="totAmount" class="form-input" id="totAmount" readonly>
                                <span class="error" id="totAmount_error"></span>
                            </div>
                        </div>
                    </div>
                    
                {{-- </div> --}}

                {{-- <div class="c-6">
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
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                    <div class="rows">
                        <div class="c-6"></div>
                        <div class="c-6">
                            <table style="width: 100%">
                                <tr>
                                    <td><label for="amountRP">Invoice Amount</label></td>
                                    <td><input type="text" name="amountRP" class="input-small" id="amountRP" value="0"
                                            readonly style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="totalDiscount">Discount</label></td>
                                    <td><input type="text" name="totalDiscount" class="input-small" id="totalDiscount"
                                            value="0" style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="netAmount">Net Amount</label>
                                    <td><input type="text" name="netAmount" class="input-small" id="netAmount" value="0"
                                            readonly style="text-align: right;">
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
                                    <td><input type="text" name="balance" class="input-small" id="balance" value="0"
                                            readonly style="text-align: right;"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="center">
                            <span class="error" id="discount_error"></span>
                            <span class="error" id="advance_error"></span>
                            <span class="error" id="message_error"></span>
                        </div>
                    </div>
                    <div class="center">
                        <button id="InsertMain" class="btn-blue">Submit</button>
                    </div>
                </div> --}}
            </div>
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>