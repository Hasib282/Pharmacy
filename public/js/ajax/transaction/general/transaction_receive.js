///////////////////////////////////////////////  Updated Format Start From Here /////////////////////////////////  
function ShowTransactionReceives(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    let totalDiscount = 0;
    let totalNetAmount = 0;
    let totalAdvance = 0;
    let totalDueCol = 0;
    let totalDueDiscount = 0;
    let totalDue = 0;
    
    if(data.length > 0){
        $.each(data, function(key, item) {
            tableRows += `
                <tr>
                    <td>${startIndex + key + 1}</td>
                    <td>${item.tran_id}</td>
                    <td>${item.user.user_name}</td>
                    <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.discount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.net_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.receive.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_col.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                        
                            <button class="open-modal" data-modal-id="printDetails" id="invoice"
                                    data-id="${item.tran_id}"><i class="fa-solid fa-circle-info"></i></button>
                                    
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                                    
                            <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                            
                        </div>
                    </td>
                </tr>
            `;

            totalBillAmount += parseFloat(item.bill_amount) || 0;
            totalDiscount += parseFloat(item.discount) || 0;
            totalNetAmount += parseFloat(item.net_amount) || 0;
            totalAdvance += parseFloat(item.receive) || 0;
            totalDueCol += parseFloat(item.due_col) || 0;
            totalDueDiscount += parseFloat(item.due_disc) || 0;
            totalDue += parseFloat(item.due) || 0;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);

    
        $('.load-data .show-table tfoot').html(`
                <tr>
                    <td colspan="3">Total:</td>
                    <td style="text-align: right">${totalBillAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalNetAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalAdvance.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDueCol.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDueDiscount.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${totalDue.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td></td>
                </tr>
        `);
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Transaction Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/transaction/receive`,
        method: "GET",
        success: function (res) {
            let groupein = "";
            let updategroupein = "";

            // Groupin chedckbox
            $.each(res.groupes, function(key, groupe) {
                groupein += `<input type="checkbox" id="groupe[]" name="groupe" class="groupe-checkbox"
                value="${groupe.id}" checked>`
            });
            $('#groupein').html(groupein);

            // Update Groupin chedckbox
            $.each(res.groupes, function(key, groupe) {
                updategroupein += `<input type="checkbox" id="groupe[]" name="groupe" class="updategroupe-checkbox"
                    value="${groupe.id}" checked>`
            });
            $('#updategroupein').html(updategroupein);
        },
    });


    // Load Data on Hard Reload
    ReloadData('transaction/receive', ShowTransactionReceives);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#date", function(){
        GetTransactionWith('1', 'Receive', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // // Insert Ajax
    // InsertAjax('transaction/receive', ShowTransactionReceives, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('transaction/receive', EditFormInputValue, EditModalOn);


    // // Update Ajax
    // UpdateAjax('transaction/receive', ShowTransactionReceives);
    

    // Delete Ajax
    DeleteAjax('transaction/receive', ShowTransactionReceives);


    // Pagination Ajax
    PaginationAjax(ShowTransactionReceives);


    // Search Ajax
    SearchAjax('transaction/receive', ShowTransactionReceives, { type: 1, method: 'Receive' });


    // Search By Date
    SearchByDateAjax('transaction/receive', ShowTransactionReceives, {type: 1, method: 'Receive'});


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.transaction.tran_id);

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

        $('#updateAdvance').val(res.transaction.receive);

        
        $("#updateHead").focus();
    }

    

    // Edit Modal Open Functionality
    function EditModalOn(){
        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        $('#dId').val('');
        GetTransactionWith('1', 'Receive', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }








    



    //Get Inserted Transacetion Grid By Transaction Id Function
    function getTransactionGrid(tranId) {
        let status = $('#status').length ? $('#status').val() : 1;
        $.ajax({
            url: `${apiUrl}/transaction/get/transactiongrid`,
            method: 'GET',
            data: { tranId, status },
            success: function (res) {
                if(res.status){
                    let transactions = res.transaction;
    
                    // Retrieve existing productGrids from local storage
                    let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];
    
                    transactions.forEach(transaction => {
                        let productGrid = {
                            product: transaction.tran_head_id,
                            name: transaction.head.tran_head_name,
                            groupe: transaction.tran_groupe_id,
                            quantity: transaction.quantity_actual,
                            amount: transaction.amount,
                            unit: transaction.unit_id,
                            cp: transaction.cp,
                            mrp: transaction.mrp,
                            totAmount: transaction.total_amount,
                            expiry: transaction.expiry_date
                        };
                        
                        // Add the new productGrids to the list
                        productGrids.push(productGrid);
                    });
                    // Save updated productGrids back to local storage
                    localStorage.setItem('transactionData', JSON.stringify(productGrids));
    
                    DisplayTransactionGrid();
                }
            }
        });
    };



















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
        let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];
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
    $(document).off('click', '#InsertTransaction').on('click', '#InsertTransaction', function (e) {
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
        let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('transactionData', JSON.stringify(productIssues));

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
    $(document).off("click", '.remove').on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productIssue = JSON.parse(localStorage.getItem('transactionData')) || [];

        productIssue.splice(index, 1);
        localStorage.setItem('transactionData', JSON.stringify(productIssue));
        DisplayTransactionGrid();
    })



    // Function to Display ProductGrids in The Transaction Grid Table
    function DisplayTransactionGrid() {
        let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];
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
        

        // Calculate Add Modal Bill
        $("#amountRP").val(total);
        let discount = Number($("#totalDiscount").val());
        let netAmount = total - discount;
        $("#netAmount").val(netAmount);
        let advance = Number($("#advance").val());
        let balance = netAmount - advance;
        $("#balance").val(balance);

        // Calculate Edit Modal Bill
        $("#updateAmountRP").val(total);
        let updateDiscount = Number($("#updateTotalDiscount").val());
        let updateNetAmount = total - updateDiscount;
        $("#updateNetAmount").val(updateNetAmount);
        let updateAdvance = Number($("#updateAdvance").val());
        let updateBalance = updateNetAmount - updateAdvance;
        $("#updateBalance").val(updateBalance);
    }

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
        let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];
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
    $(document).off('click', '#UpdateTransaction').on('click', '#UpdateTransaction', function (e) {
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
        let productIssues = JSON.parse(localStorage.getItem('transactionData')) || [];

        // Add the new productIssue to the list
        productIssues.push(productIssue);

        // Save updated productIssue back to local storage
        localStorage.setItem('transactionData', JSON.stringify(productIssues));

        DisplayTransactionGrid();


        $('#updateHead').val('');
        $('#updateHead').removeAttr('data-id');
        $('#updateHead').removeAttr('data-groupe');
        $('#updateQuantity').val('1');
        $('#updateAmount').val('');
        $('#updateTotAmount').val('');
        $("#updateHead").focus();
    });
    /////////////// ------------------ Edit and Delete Issue Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////



    ///////////// ------------------ Add Transaction Receive ajax part start ---------------- /////////////////////////////
    $(document).off('click', '#InsertMainTransaction').on('click', '#InsertMainTransaction', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let method = 'Receive';
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
            url: `${apiUrl}/transaction/receive`,
            method: 'POST',
            data: { products:JSON.stringify(products), type, method, withs, user, locations, amountRP, discount, netAmount, advance, balance },
            success: function (res) {
                if (res.status) {
                    $('#AddForm')[0].reset();
                    $('#location').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('#user').removeAttr('data-with');
                    $('.transaction_grid tbody').html('');
                    $('#date').focus();
                    localStorage.removeItem('transactionData');
                    ReloadData('transaction/receive', ShowTransactionReceives);
                    toastr.success(res.message, 'Added!');
                }
            }
        });
    });



    /////////////// ------------------ Update Transaction Receive Main ajax part start ---------------- /////////////////////////////
    $(document).off('click', '#UpdateMainTransaction').on('click', '#UpdateMainTransaction', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
        if (!products) {
            $('#update_message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let tranid = $('#updateTranId').val();
        let id = $('#id').val();
        let type = '1';
        let method = 'Receive';
        let amountRP = $('#updateAmountRP').val();
        let totalDiscount = $('#updateTotalDiscount').val();
        let netAmount = $('#updateNetAmount').val();
        let advance = $('#updateAdvance').val();
        let balance = $('#updateBalance').val();
        let withs = $('#updateUser').attr('data-with');
        let user = $('#updateUser').attr('data-id');
        $.ajax({
            url: `${apiUrl}/transaction/receive`,
            method: 'PUT',
            data: { products:JSON.stringify(products), id, tranid, type, method, user, withs, amountRP, totalDiscount, netAmount, advance, balance },
            success: function (res) {
                if (res.status) {
                    $('#editModal').hide();
                    localStorage.removeItem('transactionData');
                    ReloadData('transaction/receive', ShowTransactionReceives);
                    toastr.success(res.message, 'Updated!');
                }
            }
        });
    });
});