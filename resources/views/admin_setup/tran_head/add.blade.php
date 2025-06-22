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
            {{-- groupe --}}
            @if (Request::segment(1) != 'hr')
                <div class="form-input-group">
                    <label for="groupe">Groupe Name<span class="required" title="Required">*</span></label>
                    <select name="groupe" id="groupe">
                        {{-- options will be display dynamically --}}
                    </select>
                    <span class="error" id="groupe_error"></span>
                </div>
            @endif
            {{-- name --}}
            <div class="form-input-group">
                <label for="headName">Service/Product Name <span class="required" title="Required">*</span></label>
                <input type="text" name="headName" class="form-input" id="headName">
                <span class="error" id="headName_error"></span>
            </div>
            {{-- price --}}
            @if (Request::segment(1) != 'hr' && Request::segment(1) != 'transaction')
                <div class="form-input-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="form-input" id="price" value="0">
                    <span class="error" id="price_error"></span>
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

            @if (Request::segment(1) != 'hr' && Request::segment(1) != 'transaction')
                <input type="checkbox" name="editable" id="editable"> <label for="editable">Editable</label>
            @endif
            
            <div class="center">
                <button type="submit" id="Insert" class="btn-blue">Submit</button>
            </div>
        </form>
    </div>
</div>