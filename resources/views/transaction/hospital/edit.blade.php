<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
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
                    <div id="updategroupein" style="display: none"></div>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="dId" id="dId">
                    <input type="hidden" name="tranId" id="updateTranId">
                    <div class="rows">
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateDate">Date</label>
                                <input type="text" name="date" class="form-input" id="updateDate"
                                    value="{{ date('Y-m-d') }}" readonly>
                            </div>
                        </div>
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateUser">Transaction User</label>
                                <input type="text" name="user" class="form-input" id="updateUser" autocomplete="off">
                                <div id="update-user">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="update_user_error"></span>
                            </div>
                        </div>
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateHead">Transaction Head</label>
                                <input type="text" name="head" id="updateHead" class="form-input" autocomplete="off">
                                <div id="update-head">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="update_head_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateQuantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="updateQuantity" value="1">
                                <span class="error" id="update_quantity_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateAmount">Amount</label>
                                <input type="text" name="amount" class="form-input updateAmount" id="updateAmount">
                                <span class="error" id="update_amount_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateTotAmount">Total</label>
                                <input type="text" name="totAmount" class="form-input" id="updateTotAmount" readonly>
                                <span class="error" id="update_totAmount_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="UpdateTransaction" class="btn-blue">Add</button>
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
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
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
                    </div>
                    <div class="center">
                        <button id="UpdateMain" class="btn-blue">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>