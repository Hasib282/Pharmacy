$(document).ready(function () {
    // Get Last Transaction Id By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        getTransactionWith('1', 'Payment', '#within');
        $('#date').focus();
        localStorage.removeItem('generalAC');
        $('.transaction_grid tbody').html('');
    });


    // Show Transaction Print Details 
    $(document).on('click','#details', function(e){
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $.ajax({
            url: urls.print,
            method: 'GET',
            data: { id },
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



    $(document).on('keyup', '#quantity, #amount', function (e) {
        let quantity = $('#quantity').val();
        let amount = $('#amount').val();
        let totalAmount = quantity * amount;
        $('#totAmount').val(totalAmount);
    });
    
    
    $(document).on('keyup', '#updateQuantity, #updateAmount', function (e) {
        let quantity = $('#updateQuantity').val();
        let amount = $('#updateAmount').val();
        let totalAmount = quantity * amount;
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

        let head = $('#head').attr('data-id');
        let quantity = $('#quantity').val();
        let amount = $('#amount').val();
        let totAmount = $('#totAmount').val();

        
        // Validate Product
        if (!head) {
            isValid = false;
            errors.head = "Service/Product name is required.";
        }
        else if (isProductDuplicate(head)) {
            isValid = false;
            errors.head = "This service/product has already been added.";
        }


        // Validate Quantity
        if (!quantity || isNaN(quantity) || quantity <= 0) {
            isValid = false;
            errors.quantity = "Quantity must be a positive number.";
        }

        // Validate MRP
        if (!amount || isNaN(amount) || amount <= 0) {
            isValid = false;
            errors.amount = "Amount must be a positive number.";
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
        let productIssues = JSON.parse(localStorage.getItem('generalAC')) || [];
        return productIssues.some(products => products.product == product);
    }


    // Function to display error messages
    function displayErrors(errors) {
        $('#head_error').html(errors.head || '');
        $('#quantity_error').html(errors.quantity || '');
        $('#amount_error').html(errors.amount || '');
        $('#totAmount_error').html(errors.totAmount || '');
    }
    
    
    
    // Insert Product Into Local Storage
    $(document).on('click', '#InsertTransaction', function (e) {
        e.preventDefault();
        if (!validateFormData()) {
            return;
        }

        let product = Number($('#head').attr('data-id'));
        let name = $('#head').val();
        let groupe = $('#head').attr('data-groupe');
        let quantity = $('#quantity').val();
        let amount = $('#amount').val();
        let totAmount = $('#totAmount').val();


        let productIssue = {
            product,
            name,
            groupe,
            quantity,
            amount,
            totAmount
        };

        // Retrieve existing productIssue from local storage
        let productIssues = JSON.parse(localStorage.getItem('generalAC')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('generalAC', JSON.stringify(productIssues));

        DisplayTransactionGrid();


        $('#head').val('');
        $('#head').removeAttr('data-id');
        $('#head').removeAttr('data-groupe');
        $('#quantity').val('1');
        $('#amount').val('');
        $('#totAmount').val('');
        $("#head").focus();

    });



    // Remove Product from Local Storage
    $(document).on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productIssue = JSON.parse(localStorage.getItem('generalAC')) || [];

        productIssue.splice(index, 1);
        localStorage.setItem('generalAC', JSON.stringify(productIssue));
        DisplayTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayTransactionGrid() {
        let productIssues = JSON.parse(localStorage.getItem('generalAC')) || [];
        $('.transaction_grid tbody').html("");

        let total = 0;
        productIssues.forEach((products, index) => {
            $('.transaction_grid tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${products.name}</td>
                    <td>${products.quantity}</td>
                    <td>${products.amount}</td>
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

        let head = Number($('#updateHead').attr('data-id'));
        let quantity = $('#updateQuantity').val();
        let amount = $('#updateAmount').val();
        let totAmount = $('#updateTotAmount').val();

        // Validate Product
        if (!head) {
            isValid = false;
            errors.head = "Product/Service name is required.";
        }
        else if (isEditProductDuplicate(head)) {
            isValid = false;
            errors.head = "This product/service has already been added.";
        }

        
        // Validate Quantity
        if (!quantity || isNaN(quantity) || quantity <= 0) {
            isValid = false;
            errors.quantity = "Quantity must be a positive number.";
        }

        // Validate MRP
        if (!amount || isNaN(amount) || amount <= 0) {
            isValid = false;
            errors.amount = "Amount must be a positive number.";
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
        let productIssues = JSON.parse(localStorage.getItem('generalAC')) || [];
        return productIssues.some(products => products.product == product);
    }


    // Function to display error messages
    function displayEditErrors(errors) {
        $('#update_head_error').html(errors.head || '');
        $('#update_quantity_error').html(errors.quantity || '');
        $('#update_amount_error').html(errors.amount || '');
        $('#update_totAmount_error').html(errors.totAmount || '');
    }



    // Insert Product Into Local Storage
    $(document).on('click', '#UpdateTransaction', function (e) {
        e.preventDefault();
        if (!validateEditFormData()) {
            return;
        }

        let product = $('#updateHead').attr('data-id');
        let name = $('#updateHead').val();
        let groupe = $('#updateHead').attr('data-groupe');
        let quantity = $('#updateQuantity').val();
        let amount = $('#updateAmount').val();
        let totAmount = $('#updateTotAmount').val();


        let productIssue = {
            product,
            name,
            groupe,
            quantity,
            amount,
            totAmount
        };

        // Retrieve existing productIssue from local storage
        let productIssues = JSON.parse(localStorage.getItem('generalAC')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('generalAC', JSON.stringify(productIssues));

        DisplayEditTransactionGrid();


        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        $("#updateHead").focus();

    });



    // Remove Product from Local Storage
    $(document).on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productIssue = JSON.parse(localStorage.getItem('generalAC')) || [];

        productIssue.splice(index, 1);
        localStorage.setItem('generalAC', JSON.stringify(productIssue));
        DisplayEditTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayEditTransactionGrid() {
        let productIssues = JSON.parse(localStorage.getItem('generalAC')) || [];
        $('.update_transaction_grid tbody').html("");

        let total = 0;
        productIssues.forEach((products, index) => {
            $('.update_transaction_grid tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${products.name}</td>
                    <td>${products.quantity}</td>
                    <td>${products.amount}</td>
                    <td>${products.totAmount}</td>
                    <td><div class="center"><button class="remove" data-index="${index}"><i class="fas fa-trash"></i></button></div></td>
                </tr>`
            );

            total = total + Number(products.totAmount);
        });

        // Calculate the Bill
        $("#updateAmountRP").val(total);
        let discount = Number($("#updateTotalDiscount").val());
        let netAmount = total - discount;
        $("#updateNetAmount").val(netAmount);
        let advance = Number($("#updateAdvance").val());
        let balance = netAmount - advance;
        $("#updateBalance").val(balance);
    }

    /////////////// ------------------ Edit and Delete Issue Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////



    ///////////// ------------------ Add Transaction Payment ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#InsertMainTransaction', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('generalAC');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let method = 'Payment';
        let type = '1';
        let withs = $('#user').attr('data-with');
        let user = $('#user').attr('data-id');
        let locations = $('#location').attr('data-id');
        let amountRP = $('#amountRP').val();
        let discount = $('#totalDiscount').val();
        let netAmount = $('#netAmount').val();
        let advance = $('#advance').val();
        let balance = $('#balance').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { products:JSON.stringify(products), type, method, withs, user, locations, amountRP, discount, netAmount, advance, balance },
            beforeSend: function () {
                $(document).find('span.error').text('');
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#location').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('#user').removeAttr('data-with');
                    $('.transaction_grid tbody').html('');
                    $('.load-data').load(location.href + ' .load-data');
                    $('#date').focus();
                    localStorage.removeItem('generalAC');
                    toastr.success('Transaction Added Successfully', 'Added!');
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



    ///////////// ------------------ Edit Transaction ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#edit', function () {
        let modalId = $(this).data('modal-id');
        let id = $(this).data('id');
        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        $('#dId').val('');
        getTransactionWith('1', 'Payment', '#within');
        localStorage.removeItem('generalAC');
        $('.update_transaction_grid tbody').html('');
        
        $.ajax({
            url: urls.edit,
            method: 'GET',
            data: { id },
            success: function (res) {
                getTransactionGrid(id);
                $('#id').val(res.transaction.id);
                
                $('#updateTranId').val(res.transaction.tran_id);

                var timestamps = new Date(res.transaction.tran_date);
                var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
                $('#updateDate').val(formattedDate);
                
                $('#updateLocation').val(res.transaction.location.upazila);
                $('#updateLocation').attr('data-id', res.transaction.loc_id);
                
                $('#updateUser').attr('data-id',res.transaction.tran_user);
                $('#updateUser').attr('data-with',res.transaction.tran_type_with);
                $('#updateUser').val(res.transaction.user.user_name);

                $('#updateTotalDiscount').val(res.transaction.discount);

                $('#updateAdvance').val(res.transaction.payment);
                
                $("#updateHead").focus();
                
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



    /////////////// ------------------ Update Transaction ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#UpdateMainTransaction', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('generalAC');
        if (!products) {
            $('#update_message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let tranid = $('#updateTranId').val();
        let id = $('#id').val();
        let type = '1';
        let method = 'Payment';
        let amountRP = $('#updateAmountRP').val();
        let totalDiscount = $('#updateTotalDiscount').val();
        let netAmount = $('#updateNetAmount').val();
        let advance = $('#updateAdvance').val();
        let balance = $('#updateBalance').val();
        let withs = $('#updateUser').attr('data-with');
        let user = $('#updateUser').attr('data-id');
        $.ajax({
            url: urls.update,
            method: 'PUT',
            data: { products:JSON.stringify(products), id, tranid, user, withs, type, method, amountRP, totalDiscount, netAmount, advance, balance },
            beforeSend:function() {
                $(document).find('span.error').text('');  
            },
            success: function (res) {
                if (res.status == "success") {
                    $('.load-data').load(location.href + ' .load-data');
                    $('#editModal').hide();
                    localStorage.removeItem('generalAC');
                    toastr.success('Transaction Updated Successfully', 'Updated!');
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

    DeleteAjax('Transaction Deleted', 'Deleted!');

    PaginationAjax({ type: 1, method: 'Payment' });

    SearchAjax({ type: 1, method: 'Payment' });
    
    SearchByDateAjax({ type: 1, method: 'Payment' });

    SearchPaginationAjax({ type: 1, method: 'Payment' });


    // Get last transaction with by transaction type function
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
        $.ajax({
            url: urls.grid,
            method: 'GET',
            data: { tranId },
            success: function (res) {
                if(res.status === 'success'){
                    let transactions = res.transaction;

                    // Retrieve existing productGrids from local storage
                    let productGrids = JSON.parse(localStorage.getItem('generalAC')) || [];
                    transactions.forEach(transaction => {
                        let productGrid = {
                            product: transaction.tran_head_id,
                            name: transaction.head.tran_head_name,
                            groupe: transaction.tran_groupe_id,
                            quantity: transaction.total_quantity,
                            amount: transaction.amount,
                            totAmount: transaction.total_amount
                        };
    
                        // Add the new productGrids to the list
                        productGrids.push(productGrid);
                    });
            
                    // Save updated productGrids back to local storage
                    localStorage.setItem('generalAC', JSON.stringify(productGrids));

                    DisplayEditTransactionGrid();
                }
                else{
                    $(grid).html('');
                }
                
            }
        });
    };
});