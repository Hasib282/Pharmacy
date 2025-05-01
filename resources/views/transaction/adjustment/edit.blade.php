<div id="editModal" class="modal-container">
    <div class="modal-subject" style="width: 80%;">
        <div class="modal-heading banner">
            <div class="center">
                <h3>Edit {{ $name }}</h3>
                <span class="close-modal" data-modal-id="editModal">&times;</span>
            </div>
        </div>

        <!-- form start -->
        <form id="EditForm" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="rows">
                <div class="c-6">
                    {{-- within --}}
                    <div id="updatewithin" style="display: none"> </div>
                    {{-- groupein --}}
                    <div id="updategroupein" style="display: none"></div>
                    {{-- id  --}}
                    <input type="hidden" name="id" id="id">
                    {{-- details id  --}}
                    <input type="hidden" name="dId" id="dId">
                    {{-- transaction id  --}}
                    <input type="hidden" name="tranId" id="updateTranId">
                    <div class="rows">
                        {{-- date  --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateDate">Date</label>
                                <input type="text" name="date" class="form-input" id="updateDate"
                                    value="{{ date('Y-m-d') }}" disabled> <hr>
                            </div>
                        </div>
                        {{-- store --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateStore">Store</label>
                                <select name="store" id="updateStore">

                                </select>
                                <span class="error" id="update_store_error"></span>
                            </div>
                        </div>
                        {{-- product  --}}
                        <div class="c-12">
                            <div class="form-input-group">
                                <label for="updateProduct">Product Name</label>
                                <input type="text" name="product" id="updateProduct" class="form-input"
                                    autocomplete="off"><hr>
                                <span class="error" id="update_product_error"></span>
                            </div>
                        </div>
                        {{-- quantity --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateQuantity">Quantity</label>
                                <input type="text" name="quantity" class="form-input" id="updateQuantity" value="1">
                                <span class="error" id="update_quantity_error"></span>
                            </div>
                        </div>
                        {{-- cp  --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateCp">CP</label>
                                <input type="text" name="cp" class="form-input updateAmount" id="updateCp">
                                <span class="error" id="update_cp_error"></span>
                            </div>
                        </div>
                        {{-- mrp --}}
                        <div class="c-4">
                            <div class="form-input-group">
                                <label for="updateMrp">Mrp</label>
                                <input type="text" name="mrp" class="form-input" id="updateMrp">
                                <span class="error" id="update_mrp_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button type="submit" id="Update" class="btn-blue">Update</button>
                    </div>
                </div>
                {{-- product list  --}}
                <div class="c-6">
                    <div id="update-product">
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
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>