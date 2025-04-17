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
                    {{-- details id  --}}
                    <input type="hidden" name="dId" id="dId">
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
                                <label for="updateStore">Store</label>
                                <input type="text" name="store" class="form-input" id="updateStore" autocomplete="off"><hr>
                                <div id="update-store"></div>
                                <span class="error" id="update_store_error"></span>
                            </div>
                        </div>
                        {{-- user --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateUser">User Name</label>
                                <input type="text" name="user" class="form-input" id="updateUser" autocomplete="off"><hr>
                                <div id="update-user"></div>
                                <span class="error" id="update_user_error"></span>
                            </div>
                        </div>
                        {{-- batch id  --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateBatch">Batch Id.</label>
                                <input type="text" name="batch" class="form-input" id="updateBatch" autocomplete="off"><hr>
                                <div id="batch-list"></div>
                                <span class="error" id="update_batch_error"></span>
                            </div>
                        </div>
                        {{-- product  --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateHead">Product Name</label>
                                <input type="text" name="head" id="updateHead" class="form-input">
                                <div id="update-head">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="update_head_error"></span>
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
                        {{-- price --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updatePrice">Price</label>
                                <input type="text" name="price" class="form-input amount" id="updatePrice" disabled>
                                <span class="error" id="update_price_error"></span>
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
                        <div class="center">
                            <button type="submit" id="Update" class="btn-blue">Add</button>
                        </div>
                    </div>
                </div>
                {{-- batch details table  --}}
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
                {{-- transaction grid part start --}}
                <div class="c-6">
                    <div class="update_transaction_grid" style="overflow-x:auto; margin-top: 10px">
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
                    {{-- invoice calculation --}}
                    <div class="rows">
                        <div class="c-6"></div>
                        <div class="c-6">
                            <table style="width: 100%">
                                <tr>
                                    <td><label for="updateAmountRP">Invoice Amount</label></td>
                                    <td><input type="text" name="amountRP" class="input-small" id="updateAmountRP"
                                            value="0" readonly style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="updateTotalDiscount">Discount</label></td>
                                    <td><input type="text" name="totalDiscount" class="input-small"
                                            id="updateTotalDiscount" value="0" style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="updateNetAmount">Net Amount</label>
                                    <td><input type="text" name="netAmount" class="input-small" id="updateNetAmount"
                                            value="0" readonly style="text-align: right;"></td>
                                </tr>
                                <tr>
                                    <td><label for="updateAdvance">Advance</label>
                                    <td><input type="text" name="advance" class="input-small" id="updateAdvance"
                                            value="0" style="text-align: right;">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="updateBalance">Balance</label>
                                    <td><input type="text" name="balance" class="input-small" id="updateBalance"
                                            value="0" readonly style="text-align: right;"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="center">
                            <span class="error" id="update_discount_error"></span>
                            <span class="error" id="update_advance_error"></span>
                            <span class="error" id="update_message_error"></span>
                        </div>
                        <div class="center">
                            <button id="UpdateMain" class="btn-blue">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>