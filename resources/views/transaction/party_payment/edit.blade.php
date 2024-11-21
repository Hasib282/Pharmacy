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
            <div class="rows">
                <div class="c-6">
                    <input type="text" name="tranId" class="form-input" id="updateTranId" style="display: none">
                    <div class="row">
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateDate">Date</label>
                                <input type="text" name="date" class="form-input" id="updateDate" value="{{ date('Y-m-d') }}"
                                    readonly>
                                <span class="error" id="update_date_error"></span>
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
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateDiscount">Discount</label>
                                <input type="text" name="discount" class="form-input" id="updateDiscount" value="0">
                                <span class="error" id="update_discount_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateAmount">Amount</label>
                                <input type="text" name="amount" class="form-input" id="updateAmount">
                                <span class="error" id="update_amount_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="Update" class="btn-blue">Update</button>
                    </div>
                </div>
                <div class="c-6">
                    <div class="due-grid">
                        <table class="show-table">
                            <thead>
                                <tr>
                                    <th>SL:</th>
                                    <th>Transaction Id</th>
                                    <th>Bill Amount</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>