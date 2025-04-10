let timeoutId = null;
// Search By Input Function For Searching in Input
function SearchByInput(link, getData, targetInput, targetUl, targetList, tableData = undefined, targetTable="", AdditionalEvent = undefined, RemoveData = undefined) {
    let keyDownProcessed = false;
    // Keydown Event
    $(document).off('keydown', targetInput).on('keydown', targetInput, function (e) {
        keyDownProcessed = true;
        setTimeout(() => {
            let data = getData($(this));
            KeyDown(e, link, data, targetUl, targetList, targetInput, AdditionalEvent, RemoveData);
            $(targetTable).html('');
        }, 0);
    });



    // List Keypup Event
    $(document).off('keyup', `${targetList}`).on('keyup', `${targetList}`, function (e) {
        // Skip the list keyup event if input keydown was processed
        if (keyDownProcessed) {
            keyDownProcessed = false; // Reset the flag
            return;
        }

        ListKeyUp(e, targetUl, targetList, targetInput, AdditionalEvent);
    });



    // Focus Event
    $(document).off('focus', targetInput).on('focus', targetInput, function (e) {
        let data = getData($(this));
        let id = $(this).attr('data-id');
        if(id == undefined) {
            GetInputList(link, data, targetUl);
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
                    $(targetUl).html('');
                }
            });
        }
    });


    // Company List Click Event
    $(document).off('click', `${targetList}`).on('click', `${targetList}`, function () {
        let value = $(this).text();
        let id = $(this).data('id');
        
        $(targetInput).val(value);
        $(targetInput).attr('data-id', id);
        $(targetUl).html('');

        // Additional Events If Needed
        if (typeof AdditionalEvent === "function") {
            AdditionalEvent(targetInput, $(this));
        }
        
        $(targetInput).focus();
    });
}





// Keydown Event Function Start
function KeyDown(e, link, data, targetUl, targetList, targetInput, AdditionalEvent, RemoveData){
    let key = e.key;
    let list = $(`${targetList}`);
    
    if (key === 'Enter') { // Enter Key
        e.preventDefault();
    }
    else if (key === 'Tab') { // Tab key
        $(targetUl).html('');
    }
    else if ((key.length === 1 && key.match(/^[a-zA-Z0-9]$/)) || key === "Backspace" || key === 'Space'){
        $(targetInput).removeAttr('data-id');

        // Remove Input Data Events If Needed
        if (typeof RemoveData === "function") {
            RemoveData(targetInput);
        }
        
        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        // Set a new timeout for the GetInputList call
        timeoutId = setTimeout(() => {
            GetInputList(link, data, targetUl);
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
function ListKeyUp(e, targetUl, targetList, targetInput, AdditionalEvent) {
    let key = e.key;
    let list = $(`${targetList}`);
    let focused = $(`${targetList}:focus`);
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
        $(targetUl).html('');
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

        '#company-list ul',

        '#company-list ul li',
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

        '#update-company ul',

        '#update-company ul li',
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

        '#department-list ul',

        '#department-list ul li',
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

        '#update-department ul',

        '#update-department ul li',
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

        '#designation-list ul',

        '#designation-list ul li',
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

        '#update-designation ul',

        '#update-designation ul li',
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

        '#location-list ul',

        '#location-list ul li',
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

        '#update-location ul',

        '#update-location ul li'
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

        '#bank-list ul',

        '#bank-list ul li',
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

        '#update-bank ul',

        '#update-bank ul li',
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

        '#store-list ul',

        '#store-list ul li',
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

        '#update-store ul',

        '#update-store ul li',
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

        '#manufacturer-list ul',

        '#manufacturer-list ul li',
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

        '#update-manufacturer ul',

        '#update-manufacturer ul li',
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

        '#category-list ul',

        '#category-list ul li',
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

        '#update-category ul',

        '#update-category ul li',
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

        '#form-list ul',

        '#form-list ul li',
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

        '#update-form ul',

        '#update-form ul li',
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

        '#unit-list ul',

        '#unit-list ul li',
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

        '#update-unit ul',

        '#update-unit ul li',
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

        '#pbatch-list ul',

        '#pbatch-list ul li',
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

        '#update-pbatch ul',

        '#update-pbatch ul li',
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

        '#batch-list ul li',

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

        '#update-batch ul li',

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

        '#user-list ul li',

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

        '#update-user ul li',
        
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

        '#head-list ul li',

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

        '#update-head ul li',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).attr("data-groupe", item.data('groupe'));
        }
    );







    /////////////// ------------------ Search Products By Name And Group add value to input ajax part start ---------------- /////////////////////////////
    // Product Input Search
    SearchByInput(
        'inventory/setup/product/get',  

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
                product: $input.val(),
            };
        }, 

        '#product', 

        '#product-list table tbody',

        '#product-list table tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $(targetInput).attr("data-groupe", item.data('groupe'));
            $('#mrp').val(item.attr('data-mrp'));
            $('#cp').val(item.attr('data-cp'));
            $('#unit').val(item.attr('data-unit'));
            $('#unit').attr('data-id',item.data('unit-id'));
            let qty = $('#quantity').val();

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $('#totAmount').val(item.attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $('#totAmount').val(item.attr('data-cp') * qty);
            }
        },

        function (targetInput) {
            $(targetInput).removeAttr('data-groupe');
            $('#unit').removeAttr('data-id');
            $('#mrp').val('');
            $('#cp').val('');
            $('#unit').val('');
            $('#totAmount').val('');
        }
    );


    
    // Update Product Input Search
    SearchByInput(
        'inventory/setup/product/get', 

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
                product: $input.val(),
            };
        }, 

        '#updateProduct', 

        '#update-product table tbody',

        '#update-product table tbody tr',

        undefined, 

        "",

        function (targetInput, item) {
            $(targetInput).val(item.find('td:first').text());
            $(targetInput).attr("data-groupe", item.data('groupe'));
            $('#updateMrp').val(item.attr('data-mrp'));
            $('#updateCp').val(item.attr('data-cp'));
            $('#updateUnit').val(item.attr('data-unit'));
            $('#updateUnit').attr('data-id',item.data('unit-id'));
            let qty = $('#updateQuantity').val();

            const path = window.location.pathname;
            const pathSegments = path.split("/");
            
            if(pathSegments[3] === 'issue'){
                $('#updateTotAmount').val(item.attr('data-mrp') * qty);
            }
            else if(pathSegments[3] === 'purchase'){
                $('#updateTotAmount').val(item.attr('data-cp') * qty);
            }
        }, 

        function (targetInput) {
            $(targetInput).removeAttr('data-groupe');
            $('#updateUnit').removeAttr('data-id');
            $('#updateMrp').val('');
            $('#updateCp').val('');
            $('#updateUnit').val('');
            $('#updateTotAmount').val('');
        }
    );

    /////////////// ------------------ Search Products By Name And Groupe add value to input ajax part end ---------------- /////////////////////////////





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

        '#specialization-list ul',

        '#specialization-list ul li',
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

        '#update-specialization ul',

        '#update-specialization ul li',
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

        '#bed_category-list ul',

        '#bed_category-list ul li',
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

        '#update-bed_category ul',

        '#update-bed_category ul li',
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

        '#bed_list-list ul',

        '#bed_list-list ul li',
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

        '#update-bed_list ul',

        '#update-bed_list ul li',
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

        '#nursing_station-list ul',

        '#nursing_station-list ul li',
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

        '#update-nursing_station ul',

        '#update-nursing_station ul li',
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

        '#sr-list ul',

        '#sr-list ul li',
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

        '#update-sr ul',

        '#update-sr ul li',
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

        '#marketing_head-list ul',

        '#marketing_head-list ul li',
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

        '#update-marketing_head ul',

        '#update-marketing_head ul li',
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

        '#doctor-list ul',

        '#doctor-list ul li',
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

        '#update-doctor ul',

        '#update-doctor ul li',
    );





    /////////////// ------------------ Search Patients And add value to input ajax part start ---------------- /////////////////////////////
    // Patient Input Search
    SearchByInput(
        'hospital/ptnregistration/get/patient',  

        function ($input) {
            return {
                ptn_id: $input.val(),
                opt: 1,
            };
        }, 

        '#ptn_id', 

        '#ptn-list ul',

        '#ptn-list ul li',

        undefined, 

        "",

        // function (targetInput, item) {
        //     $(targetInput).val(item.find('td:first').text());
        //     $(targetInput).attr("data-groupe", item.data('groupe'));
        //     $('#mrp').val(item.attr('data-mrp'));
        //     $('#cp').val(item.attr('data-cp'));
        //     $('#unit').val(item.attr('data-unit'));
        //     $('#unit').attr('data-id',item.data('unit-id'));
        //     let qty = $('#quantity').val();

        //     const path = window.location.pathname;
        //     const pathSegments = path.split("/");
            
        //     if(pathSegments[3] === 'issue'){
        //         $('#totAmount').val(item.attr('data-mrp') * qty);
        //     }
        //     else if(pathSegments[3] === 'purchase'){
        //         $('#totAmount').val(item.attr('data-cp') * qty);
        //     }
        // },

        // function (targetInput) {
        //     $(targetInput).removeAttr('data-groupe');
        //     $('#unit').removeAttr('data-id');
        //     $('#mrp').val('');
        //     $('#cp').val('');
        //     $('#unit').val('');
        //     $('#totAmount').val('');
        // }
    );


    
    // Update Patient Input Search
    SearchByInput(
        'hospital/ptnregistration/get/patient', 

        function ($input) {
            return {
                ptn_id: $input.val(),
                opt: 1,
            };
        }, 

        '#updatePtn_Id', 

        '#update-ptn ul',

        '#update-ptn ul li',

        undefined, 

        "",

        // function (targetInput, item) {
        //     $(targetInput).val(item.find('td:first').text());
        //     $(targetInput).attr("data-groupe", item.data('groupe'));
        //     $('#updateMrp').val(item.attr('data-mrp'));
        //     $('#updateCp').val(item.attr('data-cp'));
        //     $('#updateUnit').val(item.attr('data-unit'));
        //     $('#updateUnit').attr('data-id',item.data('unit-id'));
        //     let qty = $('#updateQuantity').val();

        //     const path = window.location.pathname;
        //     const pathSegments = path.split("/");
            
        //     if(pathSegments[3] === 'issue'){
        //         $('#updateTotAmount').val(item.attr('data-mrp') * qty);
        //     }
        //     else if(pathSegments[3] === 'purchase'){
        //         $('#updateTotAmount').val(item.attr('data-cp') * qty);
        //     }
        // }, 

        // function (targetInput) {
        //     $(targetInput).removeAttr('data-groupe');
        //     $('#updateUnit').removeAttr('data-id');
        //     $('#updateMrp').val('');
        //     $('#updateCp').val('');
        //     $('#updateUnit').val('');
        //     $('#updateTotAmount').val('');
        // }
    );
    
    
    
    /////////////// ------------------ Search Patients And add value to input ajax part start ---------------- /////////////////////////////
    // Patient Input Search
    SearchByInput(
        'hospital/ptnregistration/get/patient',  

        function ($input) {
            return {
                ptn_phone: $input.val(),
                opt: 2,
            };
        }, 

        '#ptn_phone', 

        '#ptn-phone-list ul',

        '#ptn-phone-list ul li',

        undefined, 

        "",

        // function (targetInput, item) {
        //     $(targetInput).val(item.find('td:first').text());
        //     $(targetInput).attr("data-groupe", item.data('groupe'));
        //     $('#mrp').val(item.attr('data-mrp'));
        //     $('#cp').val(item.attr('data-cp'));
        //     $('#unit').val(item.attr('data-unit'));
        //     $('#unit').attr('data-id',item.data('unit-id'));
        //     let qty = $('#quantity').val();

        //     const path = window.location.pathname;
        //     const pathSegments = path.split("/");
            
        //     if(pathSegments[3] === 'issue'){
        //         $('#totAmount').val(item.attr('data-mrp') * qty);
        //     }
        //     else if(pathSegments[3] === 'purchase'){
        //         $('#totAmount').val(item.attr('data-cp') * qty);
        //     }
        // },

        // function (targetInput) {
        //     $(targetInput).removeAttr('data-groupe');
        //     $('#unit').removeAttr('data-id');
        //     $('#mrp').val('');
        //     $('#cp').val('');
        //     $('#unit').val('');
        //     $('#totAmount').val('');
        // }
    );


    
    // Update Patient Input Search
    SearchByInput(
        'hospital/ptnregistration/get/patient', 

        function ($input) {
            return {
                ptn_phone: $input.val(),
                opt: 2,
            };
        }, 

        '#updatePtn_Phone', 

        '#update-ptn-phone ul',

        '#update-ptn-phone ul li',

        undefined, 

        "",

        // function (targetInput, item) {
        //     $(targetInput).val(item.find('td:first').text());
        //     $(targetInput).attr("data-groupe", item.data('groupe'));
        //     $('#updateMrp').val(item.attr('data-mrp'));
        //     $('#updateCp').val(item.attr('data-cp'));
        //     $('#updateUnit').val(item.attr('data-unit'));
        //     $('#updateUnit').attr('data-id',item.data('unit-id'));
        //     let qty = $('#updateQuantity').val();

        //     const path = window.location.pathname;
        //     const pathSegments = path.split("/");
            
        //     if(pathSegments[3] === 'issue'){
        //         $('#updateTotAmount').val(item.attr('data-mrp') * qty);
        //     }
        //     else if(pathSegments[3] === 'purchase'){
        //         $('#updateTotAmount').val(item.attr('data-cp') * qty);
        //     }
        // }, 

        // function (targetInput) {
        //     $(targetInput).removeAttr('data-groupe');
        //     $('#updateUnit').removeAttr('data-id');
        //     $('#updateMrp').val('');
        //     $('#updateCp').val('');
        //     $('#updateUnit').val('');
        //     $('#updateTotAmount').val('');
        // }
    );

    /////////////// ------------------ Search Patients and add value to input ajax part end ---------------- /////////////////////////////
});