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
                    <div id="groupein" style="display: none"></div>
                    <div class="rows">
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="store">Store</label>
                                <input type="text" name="store" class="form-input" id="store" autocomplete="off">
                                <div id="store-list">
                                    <ul>

                                    </ul>
                                </div>
                                <span class="error" id="store_error"></span>
                            </div>
                        </div>

                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="product">Product Name</label>
                                <input type="text" name="product" id="product" class="form-input" autocomplete="off">

                                <span class="error" id="product_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="quantity" value="1">
                                <span class="error" id="quantity_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="cp">CP</label>
                                <input type="text" name="cp" class="form-input amount" id="cp">
                                <span class="error" id="cp_error"></span>
                            </div>
                        </div>
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="mrp">MRP</label>
                                <input type="text" name="mrp" class="form-input amount" id="mrp" readonly>
                                <span class="error" id="mrp_error"></span>
                            </div>
                        </div>
                        @if (auth()->user()->user_role == 1)
                            <div class="c-4">
                                <div class="form-input-group">
                                    <label for="company">Company <span class="required" title="Required">*</span></label>
                                    <input type="text" name="company" class="form-input" id="company" autocomplete="off">
                                    <div id="company-list">
                                        <ul>

                                        </ul>
                                    </div>
                                    <span class="error" id="company_error"></span>
                                </div>
                            </div>
                        @else
                            <div class="c-4">
                                <input type="text" name="company" class="form-input" id="company" data-id="{{auth()->user()->company_id}}" style="display: none">
                            </div>
                        @endif
                    </div>
                    <div class="center">
                        <button type="submit" id="Insert" class="btn-blue">Submit</button>
                    </div>
                </div>
                <div class="c-6">
                    <div id="product-list">
                        <table class="product-table">
                            <caption class="caption">Product List</caption>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Generic Name</th>
                                    <th>Manufacture</th>
                                    <th>Form</th>
                                    <th>Quantity</th>
                                    <th>CP</th>
                                    <th>MRP</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>