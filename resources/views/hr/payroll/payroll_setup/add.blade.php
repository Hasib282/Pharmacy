<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>

        {{-- employee type --}}
        <div class="form-input-group">   
            <label for="type">Employee Type <span class="required" title="Required">*</span></label>
            <select name="type" id="type">
                
            </select>
            <span class="error" id="type_error"></span>
        </div>
        {{-- name --}}
        <div class="form-input-group">
            <label for="user">Employee Name</label>
            <input type="text" name="user" class="form-input" id="user" autocomplete="off"><hr>
            <div id="user-list"></div>
            <span class="error" id="user_error"></span>
        </div>
        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            {{-- category --}}
            <div class="form-input-group">
                <label for="head">Payroll Category</label>
                <select name="head" id="head">
                    {{-- options will be display dynamically --}}
                </select>
                <span class="error" id="head_error"></span>
            </div>
            {{-- amount --}}
            <div class="form-input-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-input" id="amount">
                <span class="error" id="amount_error"></span>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
        {{-- payroll-grid  --}}
        <table class="show-table payroll-grid">
            <thead>
                <tr>
                    <th>Sl:</th>
                    <th>Payroll Category</th>
                    <th>Amount</th>
                    <th>Month</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>