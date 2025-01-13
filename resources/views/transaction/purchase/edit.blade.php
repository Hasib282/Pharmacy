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
                    <div id="updatewithin" style="display: none"> </div>
                    <div id="updategroupein" style="display: none"></div>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="tranId" id="updateTranId">
                    <div class="rows">
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="updateDate">Date</label>
                                <input type="text" name="date" class="form-input" id="updateDate"
                                    value="{{ date('Y-m-d') }}" disabled>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="updateStore">Store</label>
                                <input type="text" name="store" class="form-input" id="updateStore" autocomplete="off">
                                <div id="update-store">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="update_store_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="updateUser">Supplier Name</label>
                                <input type="text" name="user" class="form-input" id="updateUser" autocomplete="off">
                                <div id="update-user">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="update_user_error"></span>
                            </div>
                        </div>

                        <div class="c-8">
                            <div class="form-input-group">
                                <label for="updateProduct">Product Name</label>
                                <input type="text" name="product" id="updateProduct" class="form-input"
                                    autocomplete="off">
                                <span class="error" id="update_product_error"></span>
                            </div>
                        </div>
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="updateQuantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="updateQuantity" value="1">
                                <span class="error" id="update_quantity_error"></span>
                            </div>
                        </div>
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="updateUnit">Unit</label>
                                <input type="text" name="unit" class="form-input" id="updateUnit" autocomplete="off"
                                    disabled>
                                <span class="error" id="update_unit_error"></span>
                            </div>
                        </div>
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="updateCp">Cost Price</label>
                                <input type="text" name="cp" class="form-input updateAmount" id="updateCp">
                                <span class="error" id="update_cp_error"></span>
                            </div>
                        </div>
                        <div class="c-2">
                            <div class="form-input-group">
                                <label for="updateMrp">Mrp</label>
                                <input type="text" name="mrp" class="form-input" id="updateMrp">
                                <span class="error" id="update_mrp_error"></span>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="updateTotAmount">Total</label>
                                <input type="text" name="totAmount" class="form-input" id="updateTotAmount" disabled>
                                <span class="error" id="update_totAmount_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateExpiry">Expiry Date</label>
                                <input type="date" name="expiry" class="form-input" id="updateExpiry"
                                    value="{{date('Y-m-d')}}">
                                <span class="error" id="update_expiry_error"></span>
                            </div>
                        </div>

                    </div>
                    <div class="center">
                        <button type="submit" id="UpdateTransaction" class="btn-blue">Add</button>
                    </div>
                </div>
                {{-- Product list part start --}}
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
                            <tbody></tbody>
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