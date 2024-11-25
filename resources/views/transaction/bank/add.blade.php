<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="AddForm" method="post">
            @csrf
            <div id="groupein" style="display: none"></div>
            <div class="form-input-group">
                <label for="date">Date</label>
                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}" disabled>
                <span class="error" id="date_error"></span>
            </div>
            <div class="form-input-group">
                <label for="bank">Bank Name</label>
                <input type="text" name="bank" class="form-input" id="bank" autocomplete="off">
                <div id="bank-list">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="bank_error"></span>
            </div>
            <div class="form-input-group">
                <label for="head">Transaction Head</label>
                <input type="text" name="head" id="head" class="form-input" autocomplete="off">
                <div id="head-list">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="head_error"></span>
            </div>
            <div class="form-input-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-input" id="amount">
                <span class="error" id="amount_error"></span>
            </div>
            @if (auth()->user()->user_role == 1)
                <div class="form-input-group">
                    <label for="company">Company <span class="required" title="Required">*</span></label>
                    <input type="text" name="company" class="form-input" id="company" autocomplete="off">
                    <div id="company-list">
                        <ul>

                        </ul>
                    </div>
                    <span class="error" id="company_error"></span>
                </div>
            @else
                <div class="form-input-group">
                    <input type="text" name="company" class="form-input" id="company" data-id="{{auth()->user()->company_id}}" style="display: none">
                </div>
            @endif
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>