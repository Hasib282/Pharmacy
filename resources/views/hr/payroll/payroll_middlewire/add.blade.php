<div id="addModal" class="modal-container">
    <div class="modal-subject">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Add {{ $name }}</h3>
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
            {{-- payroll category --}}
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

            <div class = "rows">
                {{-- month  --}}
                <div class = "c-4">
                    <div class="form-input-group">
                        <label for="month">Month</label>
                        <select name="month" id="month">
                            <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>January</option>
                            <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>February</option>
                            <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>March</option>
                            <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>May</option>
                            <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>June</option>
                            <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>July</option>
                            <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>August</option>
                            <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>October</option>
                            <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>December</option>
                        </select>
                        <span class="error" id="month_error"></span>
                    </div>
                </div>
                {{-- year --}}
                <div class = "c-4">
                    <div class="form-input-group">
                        <label for="year">Year</label>
                        <select name="year" id="year">
                            @for ($year = date('Y')+10; $year >= 2000; $year--)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        <span class="error" id="year_error"></span>
                    </div>
                </div>
            </div>

            <div class="center">
                <button type="submit" class="btn-blue" id="Insert">Submit</button>
            </div>
        </form>

        {{-- payroll grid --}}
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