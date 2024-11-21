function ShowPharmacyPurchases(data, startIndex) {
    let tableRows = '';
    let totalBillAmount = 0;
    let totalDiscount = 0;
    let totalNetAmount = 0;
    let totalAdvance = 0;
    let totalDueCol = 0;
    let totalDueDiscount = 0;
    let totalDue = 0;
    let params = GetQueryParams();
    
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
                    <td style="text-align: right">${item.payment.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_col.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due_disc.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            ${params['status'] == 2 ? 
                                `<button class="open-modal" data-modal-id="verifyModal" id="verify"
                                        data-id="${item.tran_id}"><i class="fa-solid fa-check"></i> Verify</button>`
                                :
                                ""
                            }
                            <button class="open-modal" data-modal-id="printDetails" id="invoice"
                                    data-id="${item.tran_id}"><i class="fa-solid fa-circle-info"></i></button>
                            
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="${item.tran_id}"><i class="fas fa-edit"></i></button>
                            
                            <button data-id="${item.tran_id}" id="delete"><i class="fas fa-trash"></i></button>
                            
                        </div>
                    </td>
                </tr>
            `;

            totalBillAmount += item.bill_amount;
            totalDiscount += item.discount;
            totalNetAmount += item.net_amount;
            totalAdvance += item.payment;
            totalDueCol += item.due_col;
            totalDueDiscount += item.due_disc;
            totalDue += item.due;
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
        `)
    }
    else{
        $('.load-data .show-table tbody').html('');
        $('.load-data .show-table tfoot').html('<tr><td colspan="11" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Creating Select Options Dynamically
    $.ajax({
        url: `${apiUrl}/pharmacy/transaction/purchase`,
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
    ReloadData('pharmacy/transaction/purchase', ShowPharmacyPurchases);
    

    // Add Modal Open Functionality
    AddModalFunctionality("#product", function(){
        GetTransactionWith(6, 'Payment', '#within');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    });


    // Insert Ajax
    // InsertAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases, {}, function() {
    //     $('#division').focus();
    // });


    //Edit Ajax
    EditAjax('pharmacy/transaction/purchase', EditFormInputValue, EditModalOn);


    // Update Ajax
    // UpdateAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases);
    

    // Delete Ajax
    DeleteAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases);


    // Pagination Ajax
    PaginationAjax(ShowPharmacyPurchases);


    // Search Ajax
    SearchAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases, { type: 6, method: 'Purchase', status: { selector: "#status"} });


    // Search By Date
    SearchByDateAjax('pharmacy/transaction/purchase', ShowPharmacyPurchases, { type: 6, method: 'Purchase', status: { selector: "#status"} });


    // Search By Methods, Roles, Types
    SearchBySelect('pharmacy/transaction/purchase', ShowPharmacyPurchases, '#status', { type: 6, method: 'Purchase', status: { selector: "#status"} } );


    // Additional Edit Functionality
    function EditFormInputValue(res){
        getTransactionGrid(res.pharmacy.tran_id);

        $('#id').val(res.pharmacy.id);
        
        $('#updateTranId').val(res.pharmacy.tran_id);

        var timestamps = new Date(res.pharmacy.tran_date);
        var formattedDate = timestamps.toLocaleDateString('en-US', { timeZone: 'UTC' });
        $('#updateDate').val(formattedDate);

        $('#updateStore').val(res.pharmacy.store.store_name);
        $('#updateStore').attr('data-id', res.pharmacy.store_id);
        
        $('#updateUser').attr('data-id',res.pharmacy.tran_user);
        $('#updateUser').attr('data-with',res.pharmacy.tran_type_with);
        $('#updateUser').val(res.pharmacy.user.user_name);

        $('#updateTotalDiscount').val(res.pharmacy.discount);

        $('#updateAdvance').val(res.pharmacy.payment);

        
        $("#updateProduct").focus();
    }


    function EditModalOn() {
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
        GetTransactionWith(6, 'Payment', '#updatewithin');
        localStorage.removeItem('transactionData');
        $('.transaction_grid tbody').html('');
    }



    /////////////// ------------------ Verify Pharmacy Purchase Ajax Part Start ---------------- /////////////////////////////
    // Verify Button Functionality
    $(document).off('click', '#verify').on('click', '#verify', function (e) {
        e.preventDefault();
        $('#verifyModal').show();
        let id = $(this).attr('data-id');
        $('#yes').attr('data-id',"");
        $('#yes').attr('data-id',id);
        $('#no').focus();
    });

    // Cancel Button Functionality
    $(document).off('click', '#no').on('click', '#no', function (e) {
        e.preventDefault();
        $('#verifyModal').hide();
    });

    // Confirm Button Functionality
    $(document).off('click', '#yes').on('click', '#yes', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: `${apiUrl}/pharmacy/transaction/purchase/verify`,
            method: 'DELETE',
            data: { id },
            success: function (res) {
                if (res.status) {
                    ReloadData('pharmacy/transaction/purchase', ShowPharmacyPurchases);
                    $('#verifyModal').hide();
                    toastr.success('Transaction Main Data Deleted Successfully', 'Deleted!');
                }
            }
        });
    });
    
    /////////////// ------------------ Verify Pharmacy Purchase Ajax Part End ---------------- /////////////////////////////
















    











    



    


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



    // Remove Product from Local Storage
    $(document).off("click", '.remove').on("click", '.remove', function (e){
        let index = $(this).attr('data-index');
        let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];

        productGrids.splice(index, 1);
        localStorage.setItem('transactionData', JSON.stringify(productGrids));
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
                    <td>${products.cp}</td>
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
        let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];
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
    $(document).off('click', '#Insert').on('click', '#Insert', function (e) {
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
        let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];

        // Add the new productGrids to the list
        productGrids.push(productGrid);

        // Save updated productGrids back to local storage
        localStorage.setItem('transactionData', JSON.stringify(productGrids));

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
        let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];
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
    $(document).off('click', '#Update').on('click', '#Update', function (e) {
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
        let productGrids = JSON.parse(localStorage.getItem('transactionData')) || [];

        // Add the new productGrids to the list
        productGrids.push(productGrid);

        // Save updated productGrids back to local storage
        localStorage.setItem('transactionData', JSON.stringify(productGrids));

        DisplayTransactionGrid();


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

    /////////////// ------------------ Edit and Delete Purchase Product Details Into Local Storage Ajax Part End ---------------- /////////////////////////////



    /////////////// ------------------ Add Pharmacy Purchase Ajax Part Start ---------------- /////////////////////////////
    $(document).on('click', '#InsertMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
        if (!products) {
            $('#message_error').html('No product added' || '');
            return;
        }

        products = JSON.parse(products);

        let method = 'Purchase';
        let type = '6';
        let withs = $('#user').attr('data-with');
        let user = $('#user').attr('data-id');
        let store = $('#store').attr('data-id');
        let amountRP = $('#amountRP').val();
        let discount = $('#totalDiscount').val();
        let netAmount = $('#netAmount').val();
        let advance = $('#advance').val();
        let balance = $('#balance').val();
        $.ajax({
            url: `${apiUrl}/pharmacy/transaction/purchase`,
            method: 'POST',
            data: { products:JSON.stringify(products), type, method, withs, user, store, amountRP, discount, netAmount, advance, balance },
            success: function (res) {
                if (res.status) {
                    $('#AddForm')[0].reset();
                    $('#location').removeAttr('data-id');
                    $('#user').removeAttr('data-id');
                    $('#user').removeAttr('data-with');
                    $('#store').removeAttr('data-id');
                    $('#status').val('1');
                    $('.transaction_grid tbody').html('');
                    ReloadData('pharmacy/transaction/purchase', ShowPharmacyPurchases);
                    localStorage.removeItem('transactionData');
                    toastr.success(res.message, 'Added!');
                }
            }
        });
    });


    /////////////// ------------------ Update Pharmacy Purchase ajax part start ---------------- /////////////////////////////
    $(document).on('click', '#UpdateMain', function (e) {
        e.preventDefault();
        let products = localStorage.getItem('transactionData');
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
            url: `${apiUrl}/pharmacy/transaction/purchase`,
            method: 'PUT',
            data: { products:JSON.stringify(products), status, id, tranid, method, amountRP, totalDiscount, netAmount, advance, balance },
            success: function (res) {
                if (res.status) {
                    ReloadData('pharmacy/transaction/purchase', ShowPharmacyPurchases);
                    $('#editModal').hide();
                    // $('#status').val('1');
                    localStorage.removeItem('transactionData');
                    toastr.success(res.message, 'Updated!');
                }
            }
        });
    });
});