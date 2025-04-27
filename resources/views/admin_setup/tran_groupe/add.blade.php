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
            {{-- name --}}
            <div class="form-input-group">
                <label for="groupeName">Groupe Name <span class="required" title="Required">*</span></label>
                <input type="text" name="groupeName" class="form-input" id="groupeName">
                <span class="error" id="groupeName_error"></span>
            </div>

            @if (Request::segment(1) == 'admin')
                {{-- type --}}
                <div class="form-input-group">
                    <label for="type">Type <span class="required" title="Required">*</span></label>
                    <select name="type" id="type">
                        {{-- options will be display dynamically --}}
                    </select>
                    <span class="error" id="type_error"></span>
                </div>
                {{-- method  --}}
                <div class="form-input-group">
                    <label for="method">Method <span class="required" title="Required">*</span></label>
                    <select name="method" id="method">
                        <option value="">Select Method</option>
                        <option value="Receive">Receive</option>
                        <option value="Payment">Payment</option>
                        <option value="Both">Both</option>
                    </select>
                    <span class="error" id="method_error"></span>
                </div>
            @elseif (Request::segment(1) == 'transaction')
                {{-- type --}}
                <div class="form-input-group">
                    <label for="method">Method <span class="required" title="Required">*</span></label>
                    <select name="method" id="method">
                        <option value="">Select Method</option>
                        <option value="Receive">Receive</option>
                        <option value="Payment">Payment</option>
                        <option value="Both">Both</option>
                    </select>
                    <span class="error" id="method_error"></span>
                </div>
            @endif
            {{-- company --}}
            @if (auth()->user()->user_role == 1)
                <div class="form-input-group">
                    <label for="company">Company <span class="required" title="Required">*</span></label>
                    <input type="text" name="company" class="form-input" id="company" autocomplete="off"><hr>
                    <div id="company-list"></div>
                    <span class="error" id="company_error"></span>
                </div>
            @else
                <input type="text" name="company" class="form-input" id="company" data-id="{{auth()->user()->company_id}}" style="display: none">
            @endif

            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>