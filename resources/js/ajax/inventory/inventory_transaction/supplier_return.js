$(document).ready(function () {
    // Get Last Transaction With By Transaction Method and Type
    $(document).on('click', '.add', function (e) {
        let type = '5';
        let method = 'Payment';
        $('#AddForm')[0].reset();
        $('#type').val(5);
        $('#method').val('Purchase');
        $('#batch').removeAttr('data-id');
        $('#store').removeAttr('data-id');
        $('#user').removeAttr('data-id');
        $('#user').removeAttr('data-with');
        $('#product').removeAttr('data-id');
        $('#product').removeAttr('data-groupe');
        getTransactionWith(type, method, '#within');
        localStorage.removeItem('addData');
        $('.transaction_grid tbody').html('');
        $('#batch-details-list tbody').html('');
        $('#store').focus();
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
    
    

    // On focus batch display batch details
    $(document).on('focus', '#batch', function (e) {
        let batch = $('#batch').attr('data-id');
        $.ajax({
            url: urls.batch,
            method: 'GET',
            data: { batch },
            success: function (res) {
                let batches = res.batches;
                rows = '';
                batches.forEach(batch => {
                    rows += `<tr data-id="${batch.tran_head_id}" data-name="${batch.head.tran_head_name}" data-groupe="${batch.tran_groupe_id}" data-quantity="${batch.quantity}" data-cp="${batch.cp}" data-tot="${batch.tot_amount}">
                        <td>${batch.head.tran_head_name}</td>
                        <td style="text-align: center">${batch.quantity}</td>
                        <td style="text-align: right">${batch.cp}</td>
                        <td style="text-align: right">${batch.tot_amount}</td>
                    </tr>`;
                });
                $('#batch-details-list tbody').html(rows);
            }
        });
    });

    $(document).on('keyup', '#batch', function (e) {
        $('#batch-details-list tbody').html('');
    });


    // Select batch item to return 
    $(document).on('click', '.batch-table tbody tr', function (e) {
        $('#product').val($(this).attr('data-name'))
        $('#product').attr("data-id", $(this).attr('data-id'))
        $('#product').attr("data-groupe",$(this).attr('data-groupe'))
        $('#product').attr("data-quantity",$(this).attr('data-quantity'))
        $('#quantity').val($(this).attr('data-quantity'))
        $('#price').val($(this).attr('data-cp'))
        $('#totAmount').val($(this).attr('data-tot'))
        $('#quantity').focus();
    });

    $(document).on('keyup', '#quantity', function (e) {
        let quantity = $('#quantity').val();
        let cp = $('#price').val();
        let totalAmount = quantity * cp;
        $('#totAmount').val(totalAmount);
    });



    $(document).on('keyup', '#updateQuantity', function (e) {
        let quantity = $('#updateQuantity').val();
        let cp = $('#updateCp').val();
        let totalAmount = quantity * cp;
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



    /////////////// ------------------ Add and Delete Purchase Product Details Into Local Storage Ajax Part Start ---------------- /////////////////////////////
    // Function to validate form data
    function validateAddFormData() {
        let isValid = true;
        let errors = {};

        let product = $('#product').attr('data-id');
        let pq = Number($('#product').attr('data-quantity'));
        let quantity = Number($('#quantity').val());
        let cp = $('#price').val();
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
        else if(quantity > pq){
            isValid = false;
            errors.quantity = "Quantity is bigger than the invoice quantity.";
        }

        // Validate Cost Price
        if (!cp || isNaN(cp) || cp <= 0) {
            isValid = false;
            errors.cp = "CP must be a positive number.";
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
        let productGrids = JSON.parse(localStorage.getItem('addData')) || [];
        return productGrids.some(products => products.product == product);
    }

    // Function to display error messages
    function displayErrors(errors) {
        $('#product_error').html(errors.product || '');
        $('#quantity_error').html(errors.quantity || '');
        $('#price_error').html(errors.cp || '');
        $('#totAmount_error').html(errors.totAmount || '');
    }
    
    
    
    // Insert Product Into Local Storage
    $(document).on('click', '#Add', function (e) {
        e.preventDefault();
        // Validate form data
        if (!validateAddFormData()) {
            return;
        }

        let product = Number($('#product').attr('data-id'));
        let name = $('#product').val();
        let groupe = $('#product').attr('data-groupe');
        let quantity = $('#quantity').val();
        let cp = $('#price').val();
        let totAmount = $('#totAmount').val();


        let productGrid = {
            product,
            name,
            groupe,
            quantity,
            cp,
            totAmount
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
        $('#quantity').val('1');
        $('#price').val('');
        $('#totAmount').val('');
        $("#batch").focus();
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
    


    /////////////// ------------------ Add Inventory Supplier Return Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#Insert', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('addData');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let method = 'Supplier Return';
        let type = '5';
        let withs = $('#user').attr('data-with');
        let user = $('#user').attr('data-id');
        let store = $('#store').attr('data-id');
        let amountRP = $('#amountRP').val();
        let discount = $('#totalDiscount').val();
        let netAmount = $('#netAmount').val();
        let advance = $('#advance').val();
        let balance = $('#balance').val();
        let batch = $('#batch').val();
        $.ajax({
            url: urls.insert,
            method: 'POST',
            data: { products:JSON.stringify(products), batch, type, method, withs, user, store, amountRP, discount, netAmount, advance, balance },
            beforeSend: function () {
                $(document).find('span.error').text('');
            },
            success: function (res) {
                if (res.status == "success") {
                    $('#AddForm')[0].reset();
                    $('#store').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('#user').removeAttr('data-with');
                    $('#batch').removeAttr('data-id');
                    $('.transaction_grid tbody').html('');
                    $('#batch-details-list tbody').html('');
                    $('.load-data').load(location.href + ' .load-data');
                    $('#store').focus();
                    localStorage.removeItem('addData');
                    toastr.success('Supplier Return Added Successfully', 'Added!');
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

    DeleteAjax('Party Payment Deleted', 'Deleted');

    PaginationAjax({ type: 5, method: 'Supplier Return' });

    SearchAjax({ type: 5, method: 'Supplier Return' });
    
    SearchByDateAjax({ type: 5, method: 'Supplier Return' });

    SearchPaginationAjax({ type: 5, method: 'Supplier Return' });

    // get last transaction with by transaction type function
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
});