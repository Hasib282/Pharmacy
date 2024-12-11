<div id="editModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Payroll Details</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>
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
        <!-- form start -->
        <form id="EditForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="form-input-group">
                <label for="employee">Employee Name</label>
                <input type="text" name="user" class="form-input" id="employee" readonly>
            </div>
            <div class="form-input-group">
                <label for="head">Payroll Category</label>
                <select name="head" id="head">
                    <option value="">Select Payroll Category</option>
                </select>
                <span class="error" id="head_error"></span>
            </div>
            <div class="form-input-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-input" id="amount">
                <span class="error" id="amount_error"></span>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Update">Submit</button>
            </div>
        </form>
    </div>
</div>