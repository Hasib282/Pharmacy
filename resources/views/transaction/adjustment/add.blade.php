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
                    {{-- within --}}
                    <div id="within" style="display: none"> </div>
                    {{-- groupein --}}
                    <div id="groupein" style="display: none"></div>
                    <div class="rows">
                        {{-- date  --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="date">Date</label>
                                <input type="text" name="date" class="form-input" id="date" value="{{ date('Y-m-d') }}"
                                    disabled>
                            </div>
                        </div>
                        {{-- store --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="store">Store</label>
                                <input type="text" name="store" class="form-input" id="store" autocomplete="off"><hr>
                                <div id="store-list"></div>
                                <span class="error" id="store_error"></span>
                            </div>
                        </div>
                        {{-- product  --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="product">Product Name</label>
                                <input type="text" name="product" id="product" class="form-input" autocomplete="off"><hr>
                                <span class="error" id="product_error"></span>
                            </div>
                        </div>
                        {{-- quantity --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="quantity" value="1">
                                <span class="error" id="quantity_error"></span>
                            </div>
                        </div>
                        {{-- cp  --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="cp">CP</label>
                                <input type="text" name="cp" class="form-input amount" id="cp">
                                <span class="error" id="cp_error"></span>
                            </div>
                        </div>
                        {{-- mrp --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="mrp">MRP</label>
                                <input type="text" name="mrp" class="form-input amount" id="mrp" readonly>
                                <span class="error" id="mrp_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="Insert" class="btn-blue">Submit</button>
                    </div>
                </div>
                {{-- product list  --}}
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