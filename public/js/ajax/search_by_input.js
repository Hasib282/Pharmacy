let timeoutId = null;
// Search By Input Function For Searching in Input
function SearchByInput(link, getData, targetInput, targetList, tableData = undefined, targetTable="", AdditionalEvent = undefined) {
    let keyDownProcessed = false;
    // Keydown Event
    $(document).off('keydown', targetInput).on('keydown', targetInput, function (e) {
        keyDownProcessed = true;
        setTimeout(() => {
            let data = getData($(this));
            KeyDown(e, link, data, targetList, targetInput, AdditionalEvent);
            $(targetTable).html('');
        }, 0);
    });



    // List Keypup Event
    $(document).off('keyup', `${targetList} li`).on('keyup', `${targetList} li`, function (e) {
        // Skip the list keyup event if input keydown was processed
        if (keyDownProcessed) {
            keyDownProcessed = false; // Reset the flag
            return;
        }

        ListKeyUp(e, targetList, targetInput, AdditionalEvent);
    });



    // Focus Event
    $(document).off('focus', targetInput).on('focus', targetInput, function (e) {
        let data = getData($(this));
        let id = $(this).attr('data-id');
        if(id == undefined) {
            GetInputList(link, data, targetList);
        }
        else{
            if (typeof tableData === "function") {
                tableData(id);
            }
        }
    });



    // Focous out event
    $(document).off('focusout', targetInput).on('focusout', targetInput, function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $(targetList).html('');
                }
            });
        }
    });


    // Company List Click Event
    $(document).off('click', `${targetList} li`).on('click', `${targetList} li`, function () {
        let value = $(this).text();
        let id = $(this).data('id');
        
        $(targetInput).val(value);
        $(targetInput).attr('data-id', id);
        $(targetList).html('');

        // Additional Events If Needed
        if (typeof AdditionalEvent === "function") {
            AdditionalEvent(targetInput, $(this));
        }
        
        $(targetInput).focus();
    });
}





// Keydown Event Function Start
function KeyDown(e, link, data, targetList, targetInput, AdditionalEvent){
    let key = e.key;
    let list = $(`${targetList} li`);
    
    if (key === 'Enter') { // Enter Key
        e.preventDefault();
    }
    else if (key === 'Tab') { // Tab key
        $(targetList).html('');
    }
    else if ((key.length === 1 && key.match(/^[a-zA-Z0-9]$/)) || key === "Backspace" || key === 'Space'){
        $(targetInput).removeAttr('data-id');

        
        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        // Set a new timeout for the GetInputList call
        timeoutId = setTimeout(() => {
            GetInputList(link, data, targetList);
        }, 800);
    }
    if (list.length > 0) {
        if (key === 'ArrowDown') {
            UpdateInput(list, 0, targetInput, AdditionalEvent);
        } 
        else if (key === 'ArrowUp') {
            UpdateInput(list, list.length - 1, targetInput, AdditionalEvent);
        }
    }
} // Keydown Event Function End




// List Keyup Event Function Start
function ListKeyUp(e, targetList, targetInput, AdditionalEvent) {
    let key = e.key;
    let list = $(`${targetList} li`);
    let focused = $(`${targetList} li:focus`);
    let nextIndex, prevIndex;

    if (key === 'ArrowDown') {
        nextIndex = (focused.index() + 1) % list.length;
        UpdateInput(list, nextIndex, targetInput, AdditionalEvent);
    } 
    else if (key === 'ArrowUp') {
        prevIndex = (focused.index() - 1) % list.length;
        UpdateInput(list, prevIndex, targetInput, AdditionalEvent);
    }
    else if (key === 'Enter') {
        $(targetList).html('');
        $(targetInput).focus();
    }
}



// Update The Input Value When Focusing on Lists
function UpdateInput(list, index, targetInput, AdditionalEvent) {
    let item = list.eq(index);
    item.focus();
    $(targetInput).val(item.text());
    $(targetInput).attr("data-id", item.data('id'));
    
    // Additional Events If Needed
    if (typeof AdditionalEvent === "function") {
        AdditionalEvent(targetInput, item);
    }
}





$(document).ready(function () {
    /////////////// ------------------ Search Company by name and add value to input ajax part start ---------------- /////////////////////////////
    // Company Input Search
    SearchByInput(
        'admin/companies/get', 

        function ($input) {
            return {
                company: $input.val(),
            };
        }, 

        '#company', 

        '#company-list ul'
    );


    // Update Company Input Search
    SearchByInput(
        'admin/companies/get', 

        function ($input) {
            return {
                company: $input.val(),
            };
        }, 

        '#updateCompany', 

        '#update-company ul'
    );

    
    
    /////////////// ------------------ Search Department by name and add value to input ajax part start ---------------- /////////////////////////////
    // Department Input Search
    SearchByInput(
        'hr/setup/department/get', 

        function ($input) {
            return {
                department: $input.val(),
            };
        }, 

        '#department', 

        '#department-list ul'
    );


    // Update Department Input Search
    SearchByInput(
        'hr/setup/department/get', 

        function ($input) {
            return {
                department: $input.val(),
            };
        }, 

        '#updateDepartment', 

        '#update-department ul'
    );

    
    
    /////////////// ------------------ Search Designation by name and Department and add value to input ajax part start ---------------- /////////////////////////////
    // Designation Input Search
    SearchByInput(
        'hr/setup/designation/get', 

        function ($input) {
            return {
                department: $('#department').attr('data-id'),
                designation: $input.val(),
            };
        }, 

        '#designation', 

        '#designation-list ul'
    );


    // Update Designation Input Search
    SearchByInput(
        'hr/setup/designation/get', 

        function ($input) {
            return {
                department: $('#updateDepartment').attr('data-id'),
                designation: $input.val(),
            };
        }, 

        '#updateDesignation', 

        '#update-designation ul'
    );

    
    
    /////////////// ------------------ Search Location by Upazila and add value to input ajax part start ---------------- /////////////////////////////
    // Location Input Search
    SearchByInput(
        'admin/locations/get', 

        function ($input) {
            if ($('#division').length) {
                return {
                    division: $('#division').val(),
                    location: $input.val(),
                };
            }
            else{
                return {
                    division: 'undefined',
                    location: $input.val(),
                };
            }
        }, 

        '#location', 

        '#location-list ul'
    );


    // Update Location Input Search
    SearchByInput(
        'admin/locations/get', 

        function ($input) {
            if ($('#updateDivision').length) {
                return {
                    division: $('#updateDivision').val(),
                    location: $input.val(),
                };
            }
            else{
                return {
                    division: 'undefined',
                    location: $input.val(),
                };
            }
        }, 

        '#updateLocation', 

        '#update-location ul'
    );
    
    
    
    /////////////// ------------------ Search Bank by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bank Input Search
    SearchByInput(
        'admin/banks/get', 

        function ($input) {
            return {
                bank: $input.val(),
            };
        }, 

        '#bank', 

        '#bank-list ul'
    );


    // Update Bank Input Search
    SearchByInput(
        'admin/banks/get', 

        function ($input) {
            return {
                bank: $input.val(),
            };
        }, 

        '#updateBank', 

        '#update-bank ul'
    );
    
    
    
    /////////////// ------------------ Search Store by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Store Input Search
    SearchByInput(
        'admin/stores/get', 

        function ($input) {
            return {
                store: $input.val(),
            };
        }, 

        '#store', 

        '#store-list ul'
    );


    // Update Store Input Search
    SearchByInput(
        'admin/stores/get', 

        function ($input) {
            return {
                store: $input.val(),
            };
        }, 

        '#updateStore', 

        '#update-store ul'
    );
    
    
    
    /////////////// ------------------ Search Manufacturer by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Manufacturer Input Search
    SearchByInput(
        $('#manufacturer').data('url'),  

        function ($input) {
            return {
                manufacturer: $input.val(),
            };
        }, 

        '#manufacturer', 

        '#manufacturer-list ul'
    );


    // Update Manufacturer Input Search
    SearchByInput(
        $('#updateManufacturer').data('url'), 

        function ($input) {
            return {
                manufacturer: $input.val(),
            };
        }, 

        '#updateManufacturer', 

        '#update-manufacturer ul'
    );
    
    
    
    /////////////// ------------------ Search Category by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Category Input Search
    SearchByInput(
        $('#category').data('url'),  

        function ($input) {
            return {
                category: $input.val(),
            };
        }, 

        '#category', 

        '#category-list ul'
    );


    // Update Category Input Search
    SearchByInput(
        $('#updateCategory').data('url'), 

        function ($input) {
            return {
                category: $input.val(),
            };
        }, 

        '#updateCategory', 

        '#update-category ul'
    );
    
    
    
    /////////////// ------------------ Search Form by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Form Input Search
    SearchByInput(
        $('#form').data('url'),  

        function ($input) {
            return {
                form: $input.val(),
            };
        }, 

        '#form', 

        '#form-list ul'
    );


    // Update Form Input Search
    SearchByInput(
        $('#updateForm').data('url'), 

        function ($input) {
            return {
                form: $input.val(),
            };
        }, 

        '#updateForm', 

        '#update-form ul'
    );
    
    
    
    /////////////// ------------------ Search Unit by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Unit Input Search
    SearchByInput(
        $('#unit').data('url'),  

        function ($input) {
            return {
                unit: $input.val(),
            };
        }, 

        '#unit', 

        '#unit-list ul'
    );


    // Update Unit Input Search
    SearchByInput(
        $('#updateUnit').data('url'), 

        function ($input) {
            return {
                unit: $input.val(),
            };
        }, 

        '#updateUnit', 

        '#update-unit ul'
    );



    /////////////// ------------------ Search Product Batch Id and add value to input ajax part start ---------------- /////////////////////////////
    // Product Batch Input Search
    SearchByInput(
        'transaction/get/productbatch',  

        function ($input) {
            return {
                batch: $input.val(),
                product: $('#product').attr('data-id'),
            };
        }, 

        '#pbatch', 

        '#pbatch-list ul'
    );


    // Update Product Batch Input Search
    SearchByInput(
        'transaction/get/productbatch', 

        function ($input) {
            return {
                batch: $input.val(),
                product: $('#updateProduct').attr('data-id'),
            };
        }, 

        '#updatePbatch', 

        '#update-pbatch ul'
    );
    
    
    
    /////////////// ------------------ Search Batch Id and add value to input ajax part start ---------------- /////////////////////////////
    // Batch Input Search
    SearchByInput(
        'transaction/get/batch',  

        function ($input) {
            return {
                batch: $input.val(),
                type : $('#type').val(), 
                method : $('#method').val(),
            };
        }, 

        '#batch', 

        '#batch-list ul',

        function () {
            GetInputList('transaction/get/batch/details', {batch: $('#batch').attr('data-id')}, '#batch-details-list tbody');
        },

        '#batch-details-list tbody',
    );

    

    // Update Batch Input Search
    SearchByInput(
        'transaction/get/batch', 

        function ($input) {
            return {
                batch: $input.val(),
                type : $('#type').val(), 
                method : $('#method').val(),
            };
        }, 

        '#updateBatch', 

        '#update-batch ul',

        function () {
            GetInputList('transaction/get/batch/details', {batch: $('#updateBatch').attr('data-id')}, '#update-batch-details-list tbody');
        },

        '#batch-details-list tbody',
    );



    // Select batch item to return 
    $(document).off('click', '.batch-table tbody tr').on('click', '.batch-table tbody tr', function (e) {
        $('#product').val($(this).attr('data-name'))
        $('#product').attr("data-id", $(this).attr('data-id'))
        $('#product').attr("data-groupe",$(this).attr('data-groupe'))
        $('#product').attr("data-batch",$(this).attr('data-batch'))
        $('#product').attr("data-quantity",$(this).attr('data-quantity'))
        $('#quantity').val($(this).attr('data-quantity'))
        $('#price').val($(this).attr('data-price'))
        $('#totAmount').val($(this).attr('data-tot'))
        $('#quantity').focus();
    });
    
    
    
    ////////////// ------------------- Search Transaction User and add value to input ajax part start --------------- ////////////////////////////
    // User Input Search
    SearchByInput(
        'transaction/get/user',  

        function ($input) {
            if ($('#within').length) {
                tranUserType = $('.with-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                within = 1;
            } else {
                tranUserType = $('#with').val();
                within = 0;
            }

            return {
                tranUserType,
                within,
                tranUser: $input.val(),
            };
        }, 

        '#user', 

        '#user-list ul',

        function (id) {
            getDueListByUserId(id, '.due-grid tbody');
            getPayrollByUserId(id, '.payroll-grid tbody');
        },

        ".due-grid tbody, .due-grid tfoot, .payroll-grid tbody, .payroll-grid tfoot",

        function (targetInput, item) {
            $(targetInput).attr("data-with", item.data('with'));
            $('#name').val(item.data('name'));
            $('#phone').val(item.data('phone'));
            $('#address').val(item.data('address'));
        }
    );


    // Update User Input Search
    SearchByInput(
        'transaction/get/user', 

        function ($input) {
            if ($('#within').length) {
                tranUserType = $('.with-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                within = 1;
            } else {
                tranUserType = $('#updateWith').val();
                within = 0;
            }

            return {
                tranUserType,
                within,
                tranUser: $input.val(),
            };
        }, 

        '#updateUser', 

        '#update-user ul',
        
        function (id) {
            getDueListByUserId(id, '.due-grid tbody');
            getPayrollByUserId(id, '.payroll-grid tbody');
        },

        ".due-grid tbody, .due-grid tfoot, .payroll-grid tbody, .payroll-grid tfoot",

        function (targetInput, item) {
            $(targetInput).attr("data-with", item.data('with'));
            $('#updateName').val(item.data('name'));
            $('#updatePhone').val(item.data('phone'));
            $('#updateAddress').val(item.data('address'));
        }
    );



    /////////////// ------------------ Search Transaction Heads By Name And Group Add value to input ajax part start ---------------- /////////////////////////////
    // Head Input Search
    SearchByInput(
        'admin/tranheads/get',  

        function ($input) {
            let groupe;
            let groupein;
            if ($('#groupein').length) {
                groupe = $('.groupe-checkbox:checked').map(function() {
                    return $(this).val()
                }).get();
                groupein = 1;
            } else {
                groupe = $('#groupe').val();
                groupein = 0;
            }
            return {
                groupe,
                groupein,
                head: $input.val(),
            };
        }, 

        '#head', 

        '#head-list ul',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).attr("data-groupe", item.data('groupe'));
        }
    );



    // Update Head Input Search
    SearchByInput(
        'admin/tranheads/get', 

        function ($input) {
            let groupe;
            let groupein;
            if ($('#groupein').length) {
                groupe = $('.groupe-checkbox:checked').map(function() {
                    return $(this).val()
                }).get();
                groupein = 1;
            } else {
                groupe = $('#updateGroupe').val();
                groupein = 0;
            }

            return {
                groupe,
                groupein,
                head: $input.val(),
            };
        }, 

        '#updateHead', 

        '#update-head ul',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).attr("data-groupe", item.data('groupe'));
        }
    );







    /////////////// ------------------ Search Products By Name And Group add value to input ajax part start ---------------- /////////////////////////////
    // // Product Input Search
    // SearchByInput(
    //     'inventory/setup/product/get',  

    //     function ($input) {
    //         let groupe;
    //         let groupein;
    //         if ($('#groupein').length) {
    //             groupe = $('.groupe-checkbox:checked').map(function() {
    //                 return $(this).val()
    //             }).get();
    //             groupein = 1;
    //         } else {
    //             groupe = $('#updateGroupe').val();
    //             groupein = 0;
    //         }

    //         return {
    //             product: $input.val(),
    //         };
    //     }, 

    //     '#product', 

    //     '#product-list ul'
    // );


    // // Update Product Input Search
    // SearchByInput(
    //     'inventory/setup/product/get', 

    //     function ($input) {
    //         let groupe;
    //         let groupein;
    //         if ($('#groupein').length) {
    //             groupe = $('.groupe-checkbox:checked').map(function() {
    //                 return $(this).val()
    //             }).get();
    //             groupein = 1;
    //         } else {
    //             groupe = $('#updateGroupe').val();
    //             groupein = 0;
    //         }
            
    //         return {
    //             product: $input.val(),
    //         };
    //     }, 

    //     '#updateProduct', 

    //     '#update-product ul'
    // );



    // Head Keyup Event
    $(document).off('keyup', '#product').on('keyup', '#product', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#groupein').length) {
            groupe = $('.groupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#groupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        ProductKeyUp(e, groupe, groupein, product, id, '#product', '#product-list table tbody', '#mrp', '#cp', '#unit', '#quantity', '#totAmount');
    });

    // Product Key down Event
    $(document).off('keydown', '#product').on('keydown', '#product', function (e) {
        let list = $('#product-list table tbody tr');
        ProductKeyDown(e, list, '#product', '#product-list table tbody', '#mrp', '#cp', '#unit', '#quantity', '#totAmount');
    });


    // Product List Key down Event
    $(document).off('keydown', '#product-list table tbody tr').on('keydown', '#product-list table tbody tr', function (e) {
        let list = $('#product-list table tbody tr');
        let focused = $('#product-list table tbody tr:focus');
        ProductListKeyDown(e, list, focused, '#product', '#product-list table tbody', '#mrp', '#cp', '#unit', '#quantity', '#totAmount');
    });


    // Product Focus Event
    $(document).off('focus', '#product').on('focus', '#product', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#groupein').length) {
            groupe = $('.groupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#groupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getProductByGroupe(groupe, groupein, product,  '#product-list table tbody');
        }
        else{
            e.preventDefault();
        }
    });


    // Product Focous out event
    $(document).off('focusout', '#product').on('focusout', '#product', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#product-list table tbody').html('');
                }
            });
        }
    });


    // Product List Click Event
    $(document).off('click', '#product-list tbody tr').on('click', '#product-list tbody tr', function () {
        let value = $(this).find('td:first').text();
        let id = $(this).data('id');
        let groupe = $(this).data('groupe');
        let qty = $('#quantity').val();
        let cp = $(this).data('cp');
        let mrp = $(this).data('mrp');
        let unitid = $(this).data('unit-id');
        let unitname = $(this).data('unit');

        $('#product').val(value);
        $('#product').attr('data-id', id);
        $('#product').attr('data-groupe', groupe);
        $('#mrp').val(mrp);
        $('#cp').val(cp);
        $('#unit').val(unitname);
        $('#unit').attr('data-id', unitid);

        const path = window.location.pathname;
        const pathSegments = path.split("/");

        if(pathSegments[3] === 'issue'){
            $('#totAmount').val(mrp * qty);
        }
        else if(pathSegments[3] === 'purchase'){
            $('#totAmount').val(cp * qty);
        }

        $('#product-list table tbody').html('');
        $('#product').focus();
        
    });



    // Update Product Keyup event
    $(document).off('keyup', '#updateProduct').on('keyup', '#updateProduct', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#updategroupein').length) {
            groupe = $('.updategroupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#updategroupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        ProductKeyUp(e, groupe, groupein, product, id, '#updateProduct', '#update-product table tbody', '#updateMrp', '#updateCp', '#updateUnit', '#updateQuantity', '#updateTotAmount');
    });



    // Update Product Keydown event
    $(document).off('keydown', '#updateProduct').on('keydown', '#updateProduct', function (e) {
        let list = $('#update-product table tbody tr');
        ProductKeyDown(e, list, '#updateProduct', '#update-product table tbody', '#updateMrp', '#updateCp', '#updateUnit', '#updateQuantity', '#updateTotAmount');
    });



    // Update Product List Keydown event
    $(document).off('keydown', '#update-product table tbody tr').on('keydown', '#update-product table tbody tr', function (e) {
        let list = $('#update-product table tbody tr');
        let focused = $('#update-product table tbody tr:focus');
        ProductListKeyDown(e, list, focused, '#updateProduct', '#update-product table tbody', '#updateMrp', '#updateCp', '#updateUnit', '#updateQuantity', 'totAmount');
    });



    // Update Product Focus Event
    $(document).off('focus', '#updateProduct').on('focus', '#updateProduct', function (e) {
        let product = $(this).val();
        let groupe;
        let groupein;
        if ($('#updategroupein').length) {
            groupe = $('.updategroupe-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            groupein = 1;
        } else {
            groupe = $('#updateGroupe').val();
            groupein = 0;
        }
        let id = $(this).attr('data-id');
        if(id == undefined){
            getProductByGroupe(groupe, groupein, product, '#update-product table tbody');
        }
        else{
            e.preventDefault();
        }
    });


    
    // Update Product Focousout event
    $(document).off('focusout', '#updateProduct').on('focusout', '#updateProduct', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#update-product table tbody').html('');
                }
            });
        }
    });


    // Update Product Click Event
    $(document).off('click', '#update-product tbody tr').on('click', '#update-product tbody tr', function () {
        let value = $(this).find('td:first').text();
        let id = $(this).data('id');
        let groupe = $(this).data('groupe');
        let qty = $('#updateQuantity').val();
        let cp = $(this).data('cp');
        let mrp = $(this).data('mrp');
        let unitid = $(this).data('unit-id');
        let unitname = $(this).data('unit');

        $('#updateProduct').val(value);
        $('#updateProduct').attr('data-id', id);
        $('#updateProduct').attr('data-groupe', groupe);
        $('#updateMrp').val(mrp);
        $('#updateCp').val(cp);
        $('#updateUnit').val(unitname);
        $('#updateUnit').attr('data-id', unitid);

        const path = window.location.pathname;
        const pathSegments = path.split("/");

        if(pathSegments[3] === 'issue'){
            $('#updateTotAmount').val(mrp * qty);
        }
        else if(pathSegments[3] === 'purchase'){
            $('#updateTotAmount').val(cp * qty);
        }



        $('#update-product table tbody').html('');
        $('#updateProduct').focus();
    });



    // Product Key Up Event Function
    function ProductKeyUp(e, groupe, groupein, product, id, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5, targetElement6, targetElement7){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            $(targetElement1).removeAttr('data-groupe');
            $(targetElement5).removeAttr('data-id');
            $(targetElement3).val('');
            $(targetElement4).val('');
            $(targetElement5).val('');
            $(targetElement7).val('');
            getProductByGroupe(groupe, groupein, product,  targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                $(targetElement1).removeAttr('data-groupe');
                $(targetElement5).removeAttr('data-id');
                $(targetElement3).val('');
                $(targetElement4).val('');
                $(targetElement5).val('');
                $(targetElement7).val('');
                getProductByGroupe(groupe, groupein, product,  targetElement2);
            }
        }
    }


    // Product Key Down Event Function
    function ProductKeyDown(e, list, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5, targetElement6, targetElement7) {
        if (list.length > 0) {
            let qty = $(targetElement6).val();
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().find('td:first').text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-groupe", list.data('groupe'));
                $(targetElement5).attr('data-id',list.data('unit-id'));
                $(targetElement3).val(list.first().attr('data-mrp'));
                $(targetElement4).val(list.first().attr('data-cp'));
                $(targetElement5).val(list.first().attr('data-unit'));

                const path = window.location.pathname;
                const pathSegments = path.split("/");

                if(pathSegments[3] === 'issue'){
                    $(targetElement7).val(list.first().attr('data-mrp') * qty);
                }
                else if(pathSegments[3] === 'purchase'){
                    $(targetElement7).val(list.first().attr('data-cp') * qty);
                }
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().find('td:first').text());
                $(targetElement1).attr("data-id", list.data('id'));
                $(targetElement1).attr("data-groupe", list.data('groupe'));
                $(targetElement5).attr('data-id',list.data('unit-id'));
                $(targetElement3).val(list.last().attr('data-mrp'));
                $(targetElement4).val(list.last().attr('data-cp'));
                $(targetElement5).val(list.last().attr('data-unit'));

                const path = window.location.pathname;
                const pathSegments = path.split("/");

                if(pathSegments[3] === 'issue'){
                    $(targetElement7).val(list.last().attr('data-mrp') * qty);
                }
                else if(pathSegments[3] === 'purchase'){
                    $(targetElement7).val(list.last().attr('data-cp') * qty);
                }
            } 
            else if (e.keyCode === 13) { // Enter key
                e.preventDefault();
            } 
            else if (e.keyCode === 9) { // Tab key
                $(targetElement2).html('');
            }
        }
    }


    // Product List Key Down Event function
    function ProductListKeyDown(e, list, focused, targetElement1, targetElement2, targetElement3, targetElement4, targetElement5, targetElement6, targetElement7) {
        let qty = $(targetElement6).val();
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).find('td:first').text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));
            $(targetElement1).attr("data-groupe", list.eq(nextIndex).data('groupe'));
            $(targetElement5).attr('data-id',list.data('unit-id'));
            $(targetElement3).val(list.eq(nextIndex).attr('data-mrp'));
            $(targetElement4).val(list.eq(nextIndex).attr('data-cp'));
            $(targetElement5).val(list.eq(nextIndex).attr('data-unit'));

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $(targetElement7).val(list.eq(nextIndex).attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $(targetElement7).val(list.eq(nextIndex).attr('data-cp') * qty);
            }
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).find('td:first').text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));
            $(targetElement1).attr("data-groupe", list.eq(prevIndex).data('groupe'));
            $(targetElement5).attr('data-id',list.data('unit-id'));
            $(targetElement3).val(list.eq(prevIndex).attr('data-mrp'));
            $(targetElement4).val(list.eq(prevIndex).attr('data-cp'));
            $(targetElement5).val(list.eq(prevIndex).attr('data-unit'));

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $(targetElement7).val(list.eq(prevIndex).attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $(targetElement7).val(list.eq(prevIndex).attr('data-cp') * qty);
            }
        } 
        else if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(targetElement2).html('');
            $(targetElement1).focus();
        }
        else if (e.keyCode === 9) { // Tab key
            e.preventDefault();
        }
    }


    // Search Product by Name
    function getProductByGroupe(groupe, groupein, product, targetElement1) {
        $.ajax({
            url: `${apiUrl}/inventory/setup/product/get`,
            method: 'GET',
            data: { groupe, groupein, product },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }

    /////////////// ------------------ Search Head By Name And Groupe add value to input ajax part end ---------------- /////////////////////////////





    /////////////// ------------------ Search Specialization by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Specialization Input Search
    SearchByInput(
        'hospital/setup/specialization/get',  

        function ($input) {
            return {
                specialization: $input.val(),
            };
        }, 

        '#specialization', 

        '#specialization-list ul'
    );


    // Update Specialization Input Search
    SearchByInput(
        'hospital/setup/specialization/get', 

        function ($input) {
            return {
                specialization: $input.val(),
            };
        }, 

        '#updateSpecialization', 

        '#update-specialization ul'
    );





    /////////////// ------------------ Search Bed Category by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bed Category Input Search
    SearchByInput(
        'hospital/setup/bedcategory/get',  

        function ($input) {
            return {
                bed_category: $input.val(),
            };
        }, 

        '#bed_category', 

        '#bed_category-list ul'
    );


    // Update Bed Category Input Search
    SearchByInput(
        'hospital/setup/bedcategory/get', 

        function ($input) {
            return {
                bed_category: $input.val(),
            };
        }, 

        '#updateBed_Category', 

        '#update-bed_category ul'
    );
    
    
    
    
    
    /////////////// ------------------ Search Bed List by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Bed List Input Search
    SearchByInput(
        'hospital/setup/bedlist/get',  

        function ($input) {
            return {
                bed_list: $input.val(),
                bed_category: $('#bed_category').attr('data-id'),
            };
        }, 

        '#bed_list', 

        '#bed_list-list ul'
    );


    // Update Bed List Input Search
    SearchByInput(
        'hospital/setup/bedlist/get', 

        function ($input) {
            return {
                bed_list: $input.val(),
                bed_category: $('#updateBed_Category').attr('data-id'),
            };
        }, 

        '#updateBed_List', 

        '#update-bed_list ul'
    );





    /////////////// ------------------ Search Nursing Station by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Nursing Station Input Search
    SearchByInput(
        'hospital/setup/nursingstation/get',  

        function ($input) {
            return {
                nursing_station: $input.val(),
            };
        }, 

        '#nursing_station', 

        '#nursing_station-list ul'
    );


    // Update Nursing Station Input Search
    SearchByInput(
        'hospital/setup/nursingstation/get', 

        function ($input) {
            return {
                nursing_station: $input.val(),
            };
        }, 

        '#updateNursing_Station', 

        '#update-nursing_station ul'
    );





    /////////////// ------------------ Search Sales Representative by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Sales Representative Input Search
    SearchByInput(
        'transaction/get/user',  

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '4',
            };
        }, 

        '#sr', 

        '#sr-list ul'
    );


    // Update Sales Representative Input Search
    SearchByInput(
        'transaction/get/user', 

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '4',
            };
        }, 

        '#updateSR', 

        '#update-sr ul'
    );





    /////////////// ------------------ Search Marketing Head by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Marketing Head Input Search
    SearchByInput(
        'transaction/get/user',  

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '5',
            };
        }, 

        '#marketing_head', 

        '#marketing_head-list ul'
    );


    // Update Marketing Head Input Search
    SearchByInput(
        'transaction/get/user', 

        function ($input) {
            return {
                tranUser: $input.val(),
                tranUserType: '5',
            };
        }, 

        '#updateMarketing_Head', 

        '#update-marketing_head ul'
    );





    /////////////// ------------------ Search Doctor by Name and add value to input ajax part start ---------------- /////////////////////////////
    // Doctor Input Search
    SearchByInput(
        'hospital/users/doctors/get',  

        function ($input) {
            return {
                doctor: $input.val(),
            };
        }, 

        '#doctor', 

        '#doctor-list ul'
    );


    // Update Doctor Input Search
    SearchByInput(
        'hospital/users/doctors/get', 

        function ($input) {
            return {
                doctor: $input.val(),
            };
        }, 

        '#updateDoctor', 

        '#update-doctor ul'
    );
});