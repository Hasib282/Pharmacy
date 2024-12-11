<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3 class="card-title">Add {{ $name }}</h3>
                <span class="close-modal" data-modal-id="addModal">&times;</span>
            </div>
        </div>
        <!-- form start -->
        <form id="AddForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-input-group">
                <label for="with">Employee Type</label>
                <select name="with" id="with">
                    {{-- <option value="">Select employee Type</option>
                    @foreach ($tranwith as $with)
                    <option value="{{$with->id}}">{{$with->tran_with_name}}</option>
                    @endforeach --}}
                </select>
                <span class="error" id="with_error"></span>
            </div>
            <div class="form-input-group">
                <label for="user">Employee Name</label>
                <input type="text" name="user" class="form-input" id="user" autocomplete="off">
                <div id="user-list">
                    <ul>

                    </ul>
                </div>
                <span class="error" id="user_error"></span>
            </div>
            <div class="form-input-group">
                <label for="head">Payroll Category</label>
                <select name="head" id="head">
                    {{-- <option value="">Select Payroll Category</option>
                    @foreach ($heads as $head)
                    <option value="{{$head->id}}">{{$head->tran_head_name}}</option>
                    @endforeach --}}
                </select>
                <span class="error" id="head_error"></span>
            </div>
            <div class="form-input-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-input" id="amount">
                <span class="error" id="amount_error"></span>
            </div>
            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>
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