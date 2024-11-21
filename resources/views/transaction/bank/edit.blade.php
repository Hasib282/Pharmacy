<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">
            <div id="updategroupein" style="display: none"></div>
            <div class="form-input-group">
                <label for="updateDate">Date</label>
                <input type="text" name="date" class="form-input" id="updateDate" value="{{ date('Y-m-d') }}" disabled>
                <span class="error" id="update_date_error"></span>
            </div>
            <div class="form-input-group">
                <label for="updateBank">Bank Name</label>
                <input type="text" name="bank" class="form-input" id="updateBank" autocomplete="off">
                <div id="update-bank">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_bank_error"></span>
            </div>
            <div class="form-input-group">
                <label for="updateHead">Transaction Head</label>
                <input type="text" name="head" id="updateHead" class="form-input" autocomplete="off">
                <div id="update-head">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="update_head_error"></span>
            </div>
            <div class="form-input-group">
                <label for="updateAmount">Amount</label>
                <input type="text" name="amount" class="form-input" id="updateAmount">
                <span class="error" id="update_amount_error"></span>
            </div>
            <div class="center">
                <button type="submit" id="Update" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</div>