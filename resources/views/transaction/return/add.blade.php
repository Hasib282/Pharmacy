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
                    {{-- within --}}
                    <div id="within" style="display: none"> </div>
                    {{-- within --}}
                    <div id="groupein" style="display: none"></div>
                    {{-- groupein --}}
                    <input type="hidden" name="type" class="form-input" id="type">
                    {{-- method  --}}
                    <input type="hidden" name="method" class="form-input" id="method">
                    <div class="rows">
                        {{-- date  --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    disabled>
                            </div>
                        </div>
                        {{-- store --}}
                        <div class="c-3">
                            <div class="form-input-group">
                                <label for="store">Store</label>
                                <select name="store" id="store">

                                </select>
                                <span class="error" id="store_error"></span>
                            </div>
                        </div>
                        {{-- user --}}
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="user">User Name</label>
                                <input type="text" name="user" class="form-input" id="user" autocomplete="off"><hr>
                                <div id="user-list"></div>
                                <span class="error" id="user_error"></span>
                            </div>
                        </div>
                        {{-- batch id  --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="batch">Batch Id.</label>
                                <input type="text" name="batch" class="form-input" id="batch" autocomplete="off"><hr>
                                <div id="batch-list"></div>
                                <span class="error" id="batch_error"></span>
                            </div>
                        </div>
                        {{-- product name --}}
                        <div class="c-8">
                            <div class="form-input-group">
                                <label for="product">Product Name</label>
                                <input type="text" name="product" id="product" class="form-input" autocomplete="off" disabled>
                                <span class="error" id="product_error"></span>
                            </div>
                        </div>
                        {{-- quantity --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="quantity" value="1">
                                <span class="error" id="quantity_error"></span>
                            </div>
                        </div>
                        {{-- price --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-input amount" id="price" disabled>
                                <span class="error" id="price_error"></span>
                            </div>
                        </div>
                        {{-- total --}}
                        <div class="c-4">
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
                {{-- batch details --}}
                <div class="c-6">
                    <div id="batch-details-list" style="max-height: 100%; position: initial; overflow-x: auto; font-size: 10px;">
                        <table class="batch-table">
                            <caption class="caption">Batch Details</caption>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Batch Id</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- transaction grid --}}
                <div class="c-6">
                    <div class="transaction_grid" style="overflow-x:auto; margin-top: 10px">
                        <table class="show-table">
                            <thead>
                                <tr>
                                    <th>SL:</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Batch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- invoice calculation part --}}
                <div class="c-6">
                    <table style="width: 100%">
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
                <button id="InsertMain" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>