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
                    {{-- within --}}
                    <div id="within" style="display: none"> </div>
                    {{-- groupein --}}
                    <div id="groupein" style="display: none"></div>
                    <div class="rows">
                        {{-- date  --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    readonly>
                            </div>
                        </div>
                        {{-- patient Search --}}
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
                        {{-- Services  --}}
                        <div class="c-7">
                            <div class="form-input-group">
                                <label for="head">Services</label>
                                <input type="text" name="head" id="head" class="form-input" autocomplete="off"><hr>
                                <div id="head-list"></div>
                                <span class="error" id="head_error"></span>
                            </div>
                        </div>
                        {{-- quantity --}}
                        <div class="c-1">
                            <div class="form-input-group">
                                <label for="quantity">QTY</label>
                                <input type="text" name="quantity" class="form-input" id="quantity" value="1">
                                <span class="error" id="quantity_error"></span>
                            </div>
                        </div>
                        {{-- price --}}
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="amount">Price</label>
                                <input type="text" name="amount" class="form-input" id="amount">
                                <span class="error" id="amount_error"></span>
                            </div>
                        </div>
                        {{-- total --}}
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="totAmount">Total</label>
                                <input type="text" name="totAmount" class="form-input" id="totAmount" disabled>
                                <span class="error" id="totAmount_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="InsertTransaction" class="btn-blue">Add</button>
                    </div>
                </div>
                {{-- product list part start --}}
                <div class="c-6">
                    <div id="product-list">
                        <table class="product-table">
                            <caption class="caption">Product List</caption>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Generic Name</th>
                                    <th>Manufacture</th>
                                    <th>Form</th>
                                    <th>Quantity</th>
                                    <th>CP</th>
                                    <th>MRP</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- transaction grid part start --}}
                <div class="c-6">
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
                </div>
                {{-- invoice calculation part start --}}
                <div class="c-6">
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
            {{-- end of rows --}}
            <div class="center">
                <button id="InsertMain" class="btn-blue" style="margin-top: 10px;">Submit</button>
            </div>
        </form>
    </div>
</div>