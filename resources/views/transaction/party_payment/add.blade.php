<div id="addModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
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
                    <div class="rows">
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    readonly>
                                <span class="error" id="date_error"></span>
                            </div>
                        </div>
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="user">Transaction User</label>
                                <input type="text" name="user" class="form-input" id="user" autocomplete="off">
                                <div id="user-list">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="user_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="discount">Discount</label>
                                <input type="text" name="discount" class="form-input" id="discount" value="0">
                                <span class="error" id="discount_error"></span>
                            </div>
                        </div>
                        <div class="c-6">
                            <div class="form-input-group">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" class="form-input" id="amount">
                                <span class="error" id="amount_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="Insert" class="btn-blue">Submit</button>
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