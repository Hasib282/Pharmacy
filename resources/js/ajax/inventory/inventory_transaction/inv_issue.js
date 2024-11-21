$(document).ready(function () {
    // Get Last Transaction Id By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        let type = '5';
        let method = 'Receive';
        getTransactionWith(type, method, '#within');
        $('#product').focus();
        localStorage.removeItem('addData');
        $('.transaction_grid tbody').html('');
    });


    // Show Transaction Print Details 
    $(document).on('click','#details', function(e){
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let status = 1;
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


    $(document).on('keyup', '#quantity, #mrp', function (e) {
        let quantity = $('#quantity').val();
        let mrp = $('#mrp').val();
        let totalAmount = quantity * mrp;
        $('#totAmount').val(totalAmount);
    });



    $(document).on('keyup', '#updateQuantity, #updateAmount', function (e) {
        let quantity = $('#updateQuantity').val();
        let mrp = $('#updateMrp').val();
        let totalAmount = quantity * mrp;
        $('#updateTotAmount').val(totalAmount);
    });


    $(document).on('keyup', '#totalDiscount, #advance', function (e) {
        // Calculate total discount
        let amountRP = parseInt($('#amountRP').val());
        let totalDiscount = parseInt($('#totalDiscount').val());
        let advance = parseInt($('#advance').val());

        let netAmount = amountRP - totalDiscount;
        let balance = netAmount - advance;

        $('#netAmount').val(netAmount);
        $('#balance').val(balance);
    });


    $(document).on('keyup', '#updateTotalDiscount, #updateAdvance', function (e) {
        // Calculate total discount
        let amountRP = parseInt($('#updateAmountRP').val());
        let totalDiscount = parseInt($('#updateTotalDiscount').val());
        let advance = parseInt($('#updateAdvance').val());

        let netAmount = amountRP - totalDiscount;
        let balance = netAmount - advance;

        $('#updateNetAmount').val(netAmount);
        $('#updateBalance').val(balance);
    });



    /////////////// ------------------ Add and Delete Issue Product Details Into Local Storage Ajax Part Start ---------------- /////////////////////////////
    // Function to validate form data
    function validateFormData() {
        let isValid = true;
        let errors = {};

        let product = $('#product').attr('data-id');
        let quantity = $('#quantity').val();
        let mrp = $('#mrp').val();
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
        else{
            $.ajax({
                url: urls.stock,
                method: 'GET',
                data: { product, quantity },
                async: false,
                success: function (res) {
                    if(res.result){
                        isValid = false;
                        errors.product = `Product stock is low. \n only ${res.totQuantity} product left.`;
                    }
                    displayErrors(errors);
                    return isValid;
                }
            });
        }


        // Validate Quantity
        if (!quantity || isNaN(quantity) || quantity <= 0) {
            isValid = false;
            errors.quantity = "Quantity must be a positive number.";
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

        displayErrors(errors);
        return isValid;
    }


    // Function to check for duplicate products
    function isProductDuplicate(product) {
        let productIssues = JSON.parse(localStorage.getItem('addData')) || [];
        return productIssues.some(products => products.product === product);
    }


    // Function to display error messages
    function displayErrors(errors) {
        $('#product_error').html(errors.product || '');
        $('#quantity_error').html(errors.quantity || '');
        $('#mrp_error').html(errors.mrp || '');
        $('#totAmount_error').html(errors.totAmount || '');
    }
    
    
    
    // Insert Product Into Local Storage
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        if (!validateFormData()) {
            return;
        }

        let product = Number($('#product').attr('data-id'));
        let name = $('#product').val();
        let groupe = $('#product').attr('data-groupe');
        let quantity = $('#quantity').val();
        let mrp = $('#mrp').val();
        let totAmount = $('#totAmount').val();


        let productIssue = {
            product,
            name,
            groupe,
            quantity,
            mrp,
            totAmount
        };

        // Retrieve existing productIssue from local storage
        let productIssues = JSON.parse(localStorage.getItem('addData')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('addData', JSON.stringify(productIssues));

        DisplayTransactionGrid();


        $('#product').val('');
        $('#product').removeAttr('data-id');
        $('#product').removeAttr('data-groupe');
        $('#quantity').val('1');
        $('#mrp').val('');
        $('#totAmount').val('');
        $("#product").focus();

    });



    // Remove Product from Local Storage
    $(document).on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productIssue = JSON.parse(localStorage.getItem('addData')) || [];

        productIssue.splice(index, 1);
        localStorage.setItem('addData', JSON.stringify(productIssue));
        DisplayTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayTransactionGrid() {
        let productIssues = JSON.parse(localStorage.getItem('addData')) || [];
        $('.transaction_grid tbody').html("");

        let total = 0;
        productIssues.forEach((products, index) => {
            $('.transaction_grid tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${products.name}</td>
                    <td>${products.quantity}</td>
                    <td>${products.mrp}</td>
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

    /////////////// ------------------ Add and Delete Issue Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////



    /////////////// ------------------ Edit and Delete Issue Product Details Into Local Storage Ajax Part Start ---------------- /////////////////////////////
    // Function to validate form data
    function validateEditFormData() {
        let isValid = true;
        let errors = {};

        let product = Number($('#updateProduct').attr('data-id'));
        let quantity = $('#updateQuantity').val();
        let mrp = $('#updateMrp').val();
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
        else{
            $.ajax({
                url: urls.stock,
                method: 'GET',
                data: { product, quantity },
                async: false,
                success: function (res) {
                    if(res.result){
                        isValid = false;
                        errors.product = `Product stock is low. \n only ${res.totQuantity} product left.`;
                    }
                    displayEditErrors(errors);
                    return isValid;
                }
            });
        }

        
        // Validate Quantity
        if (!quantity || isNaN(quantity) || quantity <= 0) {
            isValid = false;
            errors.quantity = "Quantity must be a positive number.";
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

        displayEditErrors(errors);
        return isValid;
    }


    // Function to check for duplicate products
    function isEditProductDuplicate(product) {
        let productIssues = JSON.parse(localStorage.getItem('editData')) || [];
        console.log("productIssues",productIssues.some(products => products.product === product));
        return productIssues.some(products => products.product === product);
    }


    // Function to display error messages
    function displayEditErrors(errors) {
        $('#update_product_error').html(errors.product || '');
        $('#update_quantity_error').html(errors.quantity || '');
        $('#update_mrp_error').html(errors.mrp || '');
        $('#update_totAmount_error').html(errors.totAmount || '');
    }



    // Insert Product Into Local Storage
    $(document).on('click', '#Update', function (e) {
        e.preventDefault();
        if (!validateEditFormData()) {
            return;
        }

        let product = $('#updateProduct').attr('data-id');
        let name = $('#updateProduct').val();
        let groupe = $('#updateProduct').attr('data-groupe');
        let quantity = $('#updateQuantity').val();
        let mrp = $('#updateMrp').val();
        let totAmount = $('#updateTotAmount').val();


        let productIssue = {
            product,
            name,
            groupe,
            quantity,
            mrp,
            totAmount
        };

        // Retrieve existing productIssue from local storage
        let productIssues = JSON.parse(localStorage.getItem('editData')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('editData', JSON.stringify(productIssues));

        DisplayEditTransactionGrid();


        $('#updateProduct').val('');
        $('#updateProduct').removeAttr('data-id');
        $('#updateProduct').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateMrp').val('');
        $('#updateTotAmount').val('');
        $("#updateProduct").focus();

    });



    // Remove Product from Local Storage
    $(document).on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productIssue = JSON.parse(localStorage.getItem('editData')) || [];

        productIssue.splice(index, 1);
        localStorage.setItem('editData', JSON.stringify(productIssue));
        DisplayEditTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayEditTransactionGrid() {
        let productIssues = JSON.parse(localStorage.getItem('editData')) || [];
        $('.update_transaction_grid tbody').html("");

        let total = 0;
        productIssues.forEach((products, index) => {
            $('.update_transaction_grid tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${products.name}</td>
                    <td>${products.quantity}</td>
                    <td>${products.mrp}</td>
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

    /////////////// ------------------ Add and Delete Issue Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////




    /////////////// ------------------ Add Inventory Issue Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#InsertMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('addData');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let method = 'Issue';
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
                    $('#store').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('#user').removeAttr('data-with');
                    $('.transaction_grid tbody').html('');
                    $('.load-data').load(location.href + ' .load-data');
                    $('#product').focus();
                    localStorage.removeItem('addData');
                    toastr.success('Inventory Issue Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Inventory Issue Main ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        let type = '5';
        let method = 'Receive';
        $('#updateProduct').val('');
        $('#updateProduct').removeAttr('data-id');
        $('#updateProduct').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateMrp').val('');
        $('#updateTotAmount').val('');
        $('#dId').val('');
        getTransactionWith(type, method, '#updatewithin');
        localStorage.removeItem('editData');
        $('.update_transaction_grid tbody').html('');
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
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

                $('#updateAdvance').val(res.inventory.receive);

                
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



    /////////////// ------------------ Update Transaction Issue Main ajax part start ---------------- /////////////////////////////
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
        let method = 'Issue';
        let amountRP = $('#updateAmountRP').val();
        let totalDiscount = $('#updateTotalDiscount').val();
        let netAmount = $('#updateNetAmount').val();
        let advance = $('#updateAdvance').val();
        let balance = $('#updateBalance').val();
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { products:JSON.stringify(products), id, tranid, method, amountRP, totalDiscount, netAmount, advance, balance },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('.load-data').load(location.href + ' .load-data');
                    $('#editModal').hide();
                    localStorage.removeItem('editData');
                    toastr.success('Inventory Issue Updated Successfully', 'Updated!');
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



    DeleteAjax('Inventory Issue Details Deleted', 'Deleted!');

    PaginationAjax({ type: 5, method: 'Issue' });

    SearchAjax({ type: 5, method: 'Issue' });
    
    SearchByDateAjax({ type: 5, method: 'Issue' });

    SearchPaginationAjax({ type: 5, method: 'Issue' });

    //get last transaction with by transaction type function
    function getTransactionWith(type, method, targetElement) {
        $.ajax({
            url: urls.with,
            method: 'GET',
            data: { type: type, method: method },
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


    //Get Inserted Transacetion Grid By Transaction Id Function
    function getTransactionGrid(tranId) {
        let status = 1;
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
                            mrp: inventory.mrp,
                            totAmount: inventory.total_amount
                        };
    
                        // Add the new productGrids to the list
                        productGrids.push(productGrid);
                    });

                    console.log(productGrids);
            
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