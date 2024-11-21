$(document).ready(function () {
    // Get Last Transaction With By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        let type = '5';
        let method = 'Payment';
        getTransactionWith(type, method, '#within');
        $('#product').focus();
        localStorage.removeItem('addData');
        $('.transaction_grid tbody').html('');
    });


    // Show Transaction Print Details 
    $(document).on('click','#details', function(e){
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let status = $('#status').val();
        $.ajax({
            url: urls.print,
            method: 'GET',
            data: { id, status },
            success: function (res) {
                $('.print-details').html(res.data);

                var modal = document.getElementById(modalId);
                modal.style.display = 'block';
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    // Print Transaction Details 
    $(document).on('click','#print', function(){
        var printContent = document.getElementById("print-part").innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    });



    // Calculate Total Product Price
    $(document).on('keyup', '#quantity, #cp', function (e) {
        let quantity = $('#quantity').val();
        let cp = $('#cp').val();
        let totalAmount = quantity * cp;
        $('#totAmount').val(totalAmount);
    });
    
    

    // Calculate Total Product Price
    $(document).on('keyup', '#updateQuantity, #updateCp', function (e) {
        let quantity = $('#updateQuantity').val();
        let cp = $('#updateCp').val();
        let totalAmount = quantity * cp;
        $('#updateTotAmount').val(totalAmount);
    });



    // Calculate Bills
    $(document).on('keyup', '#totalDiscount, #advance', function (e) {
        let amountRP = parseInt($('#amountRP').val());
        let totalDiscount = parseInt($('#totalDiscount').val());
        let advance = parseInt($('#advance').val());

        let netAmount = amountRP - totalDiscount;
        let balance = netAmount - advance;

        $('#netAmount').val(netAmount);
        $('#balance').val(balance);
    });



    // Calculate Bills 
    $(document).on('keyup', '#updateTotalDiscount, #updateAdvance', function (e) {
        let amountRP = parseInt($('#updateAmountRP').val());
        let totalDiscount = parseInt($('#updateTotalDiscount').val());
        let advance = parseInt($('#updateAdvance').val());

        let netAmount = amountRP - totalDiscount;
        let balance = netAmount - advance;

        $('#updateNetAmount').val(netAmount);
        $('#updateBalance').val(balance);
    });



    /////////////// ------------------ Add and Delete Purchase Product Details Into Local Storage Ajax Part Start ---------------- /////////////////////////////
    // Function to validate form data
    function validateAddFormData() {
        let isValid = true;
        let errors = {};

        let product = $('#product').attr('data-id');
        let quantity = $('#quantity').val();
        let unit = $('#unit').attr('data-id');
        let mrp = $('#mrp').val();
        let cp = $('#cp').val();
        let totAmount = $('#totAmount').val();

        // Validate Product
        if (!product) {
            isValid = false;
            errors.product = "Product name is required.";
        }
        else if (isProductDuplicate(product)) {
            isValid = false;
            errors.product = "This product has already been added.";
        }

        
        // Validate Quantity
        if (!quantity || isNaN(quantity) || quantity <= 0) {
            isValid = false;
            errors.quantity = "Quantity must be a positive number.";
        }

        // Validate Cost Price
        if (!cp || isNaN(cp) || cp <= 0) {
            isValid = false;
            errors.cp = "CP must be a positive number.";
        }

        // Validate MRP
        if (!mrp || isNaN(mrp) || mrp <= 0) {
            isValid = false;
            errors.mrp = "MRP must be a positive number.";
        }

        // Validate Total Amount
        if (!totAmount || isNaN(totAmount) || totAmount <= 0) {
            isValid = false;
            errors.totAmount = "Total amount must be a positive number.";
        }

        // Validate Unit
        if (!unit) {
            isValid = false;
            errors.unit = "Unit is required.";
        }

        displayErrors(errors);
        return isValid;
    }


    // Function to check for duplicate products
    function isProductDuplicate(product) {
        let productGrids = JSON.parse(localStorage.getItem('addData')) || [];
        return productGrids.some(products => products.product === product);
    }

    // Function to display error messages
    function displayErrors(errors) {
        $('#product_error').html(errors.product || '');
        $('#quantity_error').html(errors.quantity || '');
        $('#unit_error').html(errors.unit || '');
        $('#mrp_error').html(errors.mrp || '');
        $('#cp_error').html(errors.cp || '');
        $('#totAmount_error').html(errors.totAmount || '');
        $('#expiry_error').html(errors.expiry || '');
    }
    
    
    
    // Insert Product Into Local Storage
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        // Validate form data
        if (!validateAddFormData()) {
            return;
        }

        let product = Number($('#product').attr('data-id'));
        let name = $('#product').val();
        let groupe = $('#product').attr('data-groupe');
        let quantity = $('#quantity').val();
        let unit = $('#unit').attr('data-id');
        let mrp = $('#mrp').val();
        let cp = $('#cp').val();
        let totAmount = $('#totAmount').val();
        let expiry = $('#expiry').val();


        let productGrid = {
            product,
            name,
            groupe,
            quantity,
            unit,
            cp,
            mrp,
            totAmount, 
            expiry
        };

        // Retrieve existing productGrids from local storage
        let productGrids = JSON.parse(localStorage.getItem('addData')) || [];

        // Add the new productGrids to the list
        productGrids.push(productGrid);

        // Save updated productGrids back to local storage
        localStorage.setItem('addData', JSON.stringify(productGrids));

        DisplayTransactionGrid();


        $('#product').val('');
        $('#product').removeAttr('data-id');
        $('#product').removeAttr('data-groupe');
        $('#unit').val('');
        $('#unit').removeAttr('data-id');
        $('#quantity').val('1');
        $('#cp').val('');
        $('#mrp').val('');
        let currentDate = new Date().toISOString().split('T')[0];
        $('#expiry').val(currentDate);
        $('#totAmount').val('');
        $("#product").focus();

    });



    // Remove Product from Local Storage
    $(document).on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productGrids = JSON.parse(localStorage.getItem('addData')) || [];

        productGrids.splice(index, 1);
        localStorage.setItem('addData', JSON.stringify(productGrids));
        DisplayTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayTransactionGrid() {
        let productGrids = JSON.parse(localStorage.getItem('addData')) || [];
        $('.transaction_grid tbody').html("");

        let total = 0;
        productGrids.forEach((products, index) => {
            $('.transaction_grid tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${products.name}</td>
                    <td>${products.quantity}</td>
                    <td>${products.cp}</td>
                    <td>${products.totAmount}</td>
                    <td><div class="center"><button class="remove" data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
                </tr>`
            );

            total = total + Number(products.totAmount);
        });

        // Calculate the Bill
        $("#amountRP").val(total);
        let discount = $("#totalDiscount").val();
        let netAmount = total - discount;
        $("#netAmount").val(netAmount);
        let advance = Number($("#advance").val());
        let balance = netAmount - advance;
        $("#balance").val(balance);
    }

    DisplayTransactionGrid();

    /////////////// ------------------ Add and Delete Purchase Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////
    
    
    
    
    
    /////////////// ------------------ Edit and Delete Purchase Product Details Into Local Storage Ajax Part Start ---------------- /////////////////////////////
    // Function to validate form data
    function validateEditFormData() {
        let isValid = true;
        let errors = {};

        let product = Number($('#updateProduct').attr('data-id'));
        let quantity = $('#updateQuantity').val();
        let unit = $('#updateUnit').attr('data-id');
        let mrp = $('#updateMrp').val();
        let cp = $('#updateCp').val();
        let totAmount = $('#updateTotAmount').val();

        // Validate Product
        if (!product) {
            isValid = false;
            errors.product = "Product name is required.";
        }
        else if (isEditProductDuplicate(product)) {
            isValid = false;
            errors.product = "This product has already been added.";
        }

        
        // Validate Quantity
        if (!quantity || isNaN(quantity) || quantity <= 0) {
            isValid = false;
            errors.quantity = "Quantity must be a positive number.";
        }

        // Validate Cost Price
        if (!cp || isNaN(cp) || cp <= 0) {
            isValid = false;
            errors.cp = "CP must be a positive number.";
        }

        // Validate MRP
        if (!mrp || isNaN(mrp) || mrp <= 0) {
            isValid = false;
            errors.mrp = "MRP must be a positive number.";
        }

        // Validate Total Amount
        if (!totAmount || isNaN(totAmount) || totAmount <= 0) {
            isValid = false;
            errors.totAmount = "Total amount must be a positive number.";
        }

        // Validate Unit
        if (!unit) {
            isValid = false;
            errors.unit = "Unit is required.";
        }

        displayEditErrors(errors);
        return isValid;
    }


    // Function to check for duplicate products
    function isEditProductDuplicate(product) {
        let productGrids = JSON.parse(localStorage.getItem('editData')) || [];
        return productGrids.some(products => products.product === product);
    }

    // Function to display error messages
    function displayEditErrors(errors) {
        $('#update_product_error').html(errors.product || '');
        $('#update_quantity_error').html(errors.quantity || '');
        $('#update_unit_error').html(errors.unit || '');
        $('#update_mrp_error').html(errors.mrp || '');
        $('#update_cp_error').html(errors.cp || '');
        $('#update_totAmount_error').html(errors.totAmount || '');
    }
    
    
    
    // Insert Edit Product Into Local Storage
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        // Validate form data
        if (!validateEditFormData()) {
            return;
        }

        let product = $('#updateProduct').attr('data-id');
        let name = $('#updateProduct').val();
        let groupe = $('#updateProduct').attr('data-groupe');
        let quantity = $('#updateQuantity').val();
        let unit = $('#updateUnit').attr('data-id');
        let mrp = $('#updateMrp').val();
        let cp = $('#updateCp').val();
        let totAmount = $('#updateTotAmount').val();
        let expiry = $('#updateExpiry').val();


        let productGrid = {
            product,
            name,
            groupe,
            quantity,
            unit,
            cp,
            mrp,
            totAmount, 
            expiry
        };

        // Retrieve existing productGrids from local storage
        let productGrids = JSON.parse(localStorage.getItem('editData')) || [];

        // Add the new productGrids to the list
        productGrids.push(productGrid);

        // Save updated productGrids back to local storage
        localStorage.setItem('editData', JSON.stringify(productGrids));

        DisplayEditTransactionGrid();


        $('#updateProduct').val('');
        $('#updateProduct').removeAttr('data-id');
        $('#updateProduct').removeAttr('data-groupe');
        $('#updateUnit').val('');
        $('#updateUnit').removeAttr('data-id');
        $('#updateQuantity').val('1');
        $('#updateCp').val('');
        $('#updateMrp').val('');
        let currentDate = new Date().toISOString().split('T')[0];
        $('#updateExpiry').val(currentDate);
        $('#updateTotAmount').val('');
        $("#updateProduct").focus();

    });



    // Remove Product from Local Storage
    $(document).on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productGrids = JSON.parse(localStorage.getItem('editData')) || [];

        productGrids.splice(index, 1);
        localStorage.setItem('editData', JSON.stringify(productGrids));
        DisplayEditTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayEditTransactionGrid() {
        let productGrids = JSON.parse(localStorage.getItem('editData')) || [];
        $('.update_transaction_grid tbody').html("");

        let total = 0;
        productGrids.forEach((products, index) => {
            $('.update_transaction_grid tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${products.name}</td>
                    <td>${products.quantity}</td>
                    <td>${products.cp}</td>
                    <td>${products.totAmount}</td>
                    <td><div class="center"><button class="remove" data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
                </tr>`
            );

            total = total + Number(products.totAmount);
        });

        // Calculate the Bill
        $("#updateAmountRP").val(total);
        let discount = $("#updateTotalDiscount").val();
        let netAmount = total - discount;
        $("#updateNetAmount").val(netAmount);
        let advance = Number($("#updateAdvance").val());
        let balance = netAmount - advance;
        $("#updateBalance").val(balance);
    }

    /////////////// ------------------ Add and Delete Purchase Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////
    




    /////////////// ------------------ Add Inventory Purchase Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#InsertMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('addData');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let method = 'Purchase';
        let type = '5';
        let withs = $('#user').attr('data-with');
        let user = $('#user').attr('data-id');
        let store = $('#store').attr('data-id');
        let amountRP = $('#amountRP').val();
        let discount = $('#totalDiscount').val();
        let netAmount = $('#netAmount').val();
        let advance = $('#advance').val();
        let balance = $('#balance').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { products:JSON.stringify(products), type, method, withs, user, store, amountRP, discount, netAmount, advance, balance },
            beforeSend: function () {
                $(document).find('span.error').text('');
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#location').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('#user').removeAttr('data-with');
                    $('#store').removeAttr('data-id');
                    $('#status').val('1');
                    $('.transaction_grid tbody').html('');
                    $('.load-data').load(location.href + ' .load-data');
                    localStorage.removeItem('addData');
                    toastr.success('Inventory Purchase Added To Main TableSuccessfully', 'Added!');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
        });
    });



    ///////////// ------------------ Edit Inventory Purchase ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let type = '5';
        let method = 'Payment';
        let status = $('#status').val();
        $('#updateProduct').val('');
        $('#updateProduct').removeAttr('data-id');
        $('#updateProduct').removeAttr('data-groupe');
        $('#updateUnit').val('');
        $('#updateUnit').removeAttr('data-id');
        $('#updateQuantity').val('1');
        $('#updateCp').val('');
        $('#updateMrp').val('');
        let currentDate = new Date().toISOString().split('T')[0];
        $('#updateExpiry').val(currentDate);
        $('#updateTotAmount').val('');
        $('#dId').val('');
        getTransactionWith(type, method, '#updatewithin');
        localStorage.removeItem('editData');
        $('.update_transaction_grid tbody').html('');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id, status },
            success: function (res) {
                getTransactionGrid(res.inventory.tran_id);

                $('#id').val(res.inventory.id);
                
                $('#updateTranId').val(res.inventory.tran_id);

                var timestamps = new Date(res.inventory.tran_date);
                var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
                $('#updateDate').val(formattedDate);

                $('#updateStore').val(res.inventory.store.store_name);
                $('#updateStore').attr('data-id', res.inventory.store_id);
                
                $('#updateUser').attr('data-id',res.inventory.tran_user);
                $('#updateUser').attr('data-with',res.inventory.tran_type_with);
                $('#updateUser').val(res.inventory.user.user_name);

                $('#updateTotalDiscount').val(res.inventory.discount);

                $('#updateAdvance').val(res.inventory.payment);

                
                $("#updateProduct").focus();
                
                var modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'block';
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });




    /////////////// ------------------ Update Inventory Purchase ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#UpdateMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('editData');
        if (!products) {
            $('#update_message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let tranid = $('#updateTranId').val();
        let id = $('#id').val();
        let method = 'Purchase';
        let amountRP = $('#updateAmountRP').val();
        let totalDiscount = $('#updateTotalDiscount').val();
        let netAmount = $('#updateNetAmount').val();
        let advance = $('#updateAdvance').val();
        let balance = $('#updateBalance').val();
        let status = $('#status').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { products:JSON.stringify(products), status, id, tranid, method, amountRP, totalDiscount, netAmount, advance, balance },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('.load-data').load(location.href + ' .load-data');
                    $('#editModal').hide();
                    $('#status').val('1');
                    localStorage.removeItem('editData');
                    toastr.success('Inventory Purchase Main Updated Successfully', 'Updated!');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (key, value) {
                    $('#update_' + key + "_error").text(value);
                })
            }
        });
    });



    /////////////// ------------------ Delete Inventory Purchase Main Ajax Part Start ---------------- /////////////////////////////
    // Delete Button Functionality
    $(document).on('click', '#delete', function (e) {
        e.preventDefault();
        $('#deleteModal').show();
        let id = $(this).attr('data-id');
        $('#confirm').attr('data-id',"");
        $('#confirm').attr('data-id',id);
        $('#cancel').focus();
    });

    // Cancel Button Functionality
    $(document).on('click', '#cancel', function (e) {
        e.preventDefault();
        $('#deleteModal').hide();
    });

    // Confirm Button Functionality
    $(document).on('click', '#confirm', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let status = $('#status').val();
        $.ajax({
            url: urls.delete,
            method: 'DELETE',
            data: { id, status },
            success: function (res) {
                if (res.status == "success") {
                    $('.load-data').load(location.href + ' .load-data');
                    $('#search').val('');
                    $('#status').val('1');
                    $('#deleteModal').hide();
                    toastr.success('Transaction Main Data Deleted Successfully', 'Deleted!');
                }
            }
        });
    });
    
    /////////////// ------------------ Delete Inventory Purchase Main Ajax Part End ---------------- /////////////////////////////



    /////////////// ------------------ Verify Inventory Purchase Ajax Part Start ---------------- /////////////////////////////
    // Verify Button Functionality
    $(document).on('click', '#verify', function (e) {
        e.preventDefault();
        $('#verifyModal').show();
        let id = $(this).attr('data-id');
        $('#yes').attr('data-id',"");
        $('#yes').attr('data-id',id);
        $('#no').focus();
    });

    // Cancel Button Functionality
    $(document).on('click', '#no', function (e) {
        e.preventDefault();
        $('#verifyModal').hide();
    });

    // Confirm Button Functionality
    $(document).on('click', '#yes', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: urls.verify,
            method: 'DELETE',
            data: { id },
            success: function (res) {
                if (res.status == "success") {
                    $('.load-data').load(location.href + ' .load-data');
                    $('#search').val('');
                    $('#status').val('1');
                    $('#verifyModal').hide();
                    toastr.success('Transaction Main Data Deleted Successfully', 'Deleted!');
                }
            }
        });
    });
    
    /////////////// ------------------ Verify Inventory Purchase Ajax Part End ---------------- /////////////////////////////


    // DeleteAjax('Party Payment Deleted', ' .party-receive');

    PaginationAjax({ type: 5, method: 'Purchase', status: $('#status').val() });

    SearchAjax({ type: 5, method: 'Purchase', status: $('#status').val() });
    
    SearchByDateAjax({ type: 5, method: 'Purchase', status: $('#status').val() });

    SearchPaginationAjax({ type: 5, method: 'Purchase', status: $('#status').val() });

    
    /////////////// ------------------ Search Ajax Part Start ---------------- /////////////////////////////
    // Search by Date Range
    $(document).on('change', '#status', function(e){
        e.preventDefault();
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        let search = $('#search').val();
        let status = $('#status').val();
        let type = '5';
        let method = 'Purchase';
        let searchOption = $("#searchOption").val();
        LoadData(urls.search, {search, status, startDate, endDate, method, type, searchOption}, '.load-data');
    });


    //get last transaction with by transaction type function
    function getTransactionWith(type, method, targetElement) {
        $.ajax({
            url: urls.with,
            method: 'GET',
            data: { type, method },
            success: function (res) {
                if (res.status === 'success') {
                    let id = [];
                    $(targetElement).html('');
                    $.each(res.tranwith, function (key, withs) {
                        id.push(withs.id)
                        $(targetElement).append(`<input type="checkbox" id="with[]" class="with-checkbox" name="with" value="${withs.id}" checked>`);
                    });
                }
            }
        });
    }


    // Get Inserted Transacetion Grid By Transaction Id Function
    function getTransactionGrid(tranId) {
        let status = $('#status').val();
        $.ajax({
            url: urls.grid,
            method: 'GET',
            data: { tranId, status },
            // async: false,
            success: function (res) {
                if(res.status === 'success'){
                    let inventories = res.inventory;

                    // Retrieve existing productGrids from local storage
                    let productGrids = JSON.parse(localStorage.getItem('editData')) || [];

                    inventories.forEach(inventory => {
                        let productGrid = {
                            product: inventory.tran_head_id,
                            name: inventory.head.tran_head_name,
                            groupe: inventory.tran_groupe_id,
                            quantity: inventory.total_quantity,
                            unit: inventory.unit_id,
                            cp: inventory.cp,
                            mrp: inventory.mrp,
                            totAmount: inventory.total_amount,
                            expiry: inventory.expiry_date
                        };
                        
                        // Add the new productGrids to the list
                        productGrids.push(productGrid);
                    });
                    // Save updated productGrids back to local storage
                    localStorage.setItem('editData', JSON.stringify(productGrids));

                    DisplayEditTransactionGrid();
                }
                else{
                    $(grid).html('');
                }
                
            }
        });
    };
});