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
                <div class="c-6">
                    <div id="within" style="display: none"> </div>
                    <div id="groupein" style="display: none"></div>
                    <div class="rows">
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="store">Store</label>
                                <input type="text" name="store" class="form-input" id="store" autocomplete="off">
                                <div id="store-list">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="store_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="user">Client Name</label>
                                <input type="text" name="user" class="form-input" id="user" autocomplete="off">
                                <div id="user-list">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="user_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-input" id="name">
                                <span class="error" id="name_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" class="form-input" id="phone">
                                <span class="error" id="phone_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-input" id="address">
                                <span class="error" id="address_error"></span>
                            </div>
                        </div>
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="product">Product Name</label>
                                <input type="text" name="product" id="product" class="form-input" autocomplete="off">
                                <span class="error" id="product_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="quantity" value="1">
                                <span class="error" id="quantity_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="mrp">MRP</label>
                                <input type="text" name="mrp" class="form-input amount" id="mrp" readonly>
                                <span class="error" id="mrp_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="totAmount">Total</label>
                                <input type="text" name="totAmount" class="form-input" id="totAmount" disabled>
                                <span class="error" id="totAmount_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="Insert" class="btn-blue">Add</button>
                    </div>
                </div>
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
                    <div class="center">
                        <span class="error" id="discount_error"></span>
                        <span class="error" id="advance_error"></span>
                        <span class="error" id="message_error"></span>
                    </div>
                </div>
            </div>
            <div class="center">
                <button id="InsertMain" class="btn-blue" style="margin-top: 10px;">Submit</button>
            </div>
        </form>
    </div>
</div>