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
                    {{-- within --}}
                    <div id="updatewithin" style="display: none"> </div>
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
                        {{-- store --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="updateStore">Store <span class="required" title="Required">*</span></label>
                                <select name="store" id="updateStore">

                                </select>
                                <span class="error" id="update_store_error"></span>
                            </div>
                        </div>
                        {{-- client --}}
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="updateUser">Client Name</label>
                                <input type="text" name="user" class="form-input" id="updateUser" autocomplete="off"><hr>
                                <div id="update-user"></div>
                                <span class="error" id="update_user_error"></span>
                            </div>
                        </div>
                        {{-- name --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateName">Name</label>
                                <input type="text" name="name" class="form-input" id="updateName">
                                <span class="error" id="update_name_error"></span>
                            </div>
                        </div>
                        {{-- phone  --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updatePhone">Phone</label>
                                <input type="text" name="phone" class="form-input" id="updatePhone">
                                <span class="error" id="update_phone_error"></span>
                            </div>
                        </div>
                        {{-- address  --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateAddress">Address</label>
                                <input type="text" name="address" class="form-input" id="updateAddress">
                                <span class="error" id="update_address_error"></span>
                            </div>
                        </div>
                        {{-- product  --}}
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="updateProduct">Product Name</label>
                                <input type="text" name="product" id="updateProduct" class="form-input"
                                    autocomplete="off"><hr>
                                <span class="error" id="update_product_error"></span>
                            </div>
                        </div>
                        {{-- batch --}}
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="updatePbatch">Batch</label>
                                <input type="text" name="pbatch" class="form-input" id="updatePbatch" autocomplete="off"><hr>
                                <div id="update-pbatch"></div>
                                <span class="error" id="update_pbatch_error"></span>
                            </div>
                        </div>
                        {{-- quantity --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateQuantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="updateQuantity" value="1">
                                <span class="error" id="update_quantity_error"></span>
                            </div>
                        </div>
                        {{-- mrp --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateMrp">Mrp</label>
                                <input type="text" name="mrp" class="form-input updateAmount" id="updateMrp">
                                <span class="error" id="update_mrp_error"></span>
                            </div>
                        </div>
                        {{-- total --}}
                        <div class="c-4">
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
                {{-- product list part start --}}
                <div class="c-6">
                    <div id="update-product">
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
                </div>
                {{-- invoice calculation part start --}}
                <div class="c-6">
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
            {{--  end of row --}}
            <div class="center">
                <button id="UpdateMain" class="btn-blue" style="margin-top: 10px;">Update</button>
            </div>
        </form>
    </div>
</div>