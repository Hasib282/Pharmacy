function ShowPharmacyItemflowStatements(data, startIndex, res) {
    let tableRows = '';
    let balance = res.openingBalance;
    
    tableRows += `
            <tr>
                <td></td>
                <td>Opening Balance</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>${res.openingBalance}</td>
                <td></td>
                <td></td>
            </tr>
        `;

    if(data.length > 0){
        $.each(data, function(key, item) {
            if (item.tran_method == "Purchase") {
                balance += item.quantity_actual;
            } else if (item.tran_method == "Issue") {
                balance -= item.quantity_actual;
            } else if (item.tran_method == "Supplier Return") {
                balance -= item.quantity_actual;
            } else if (item.tran_method == "Client Return") {
                balance += item.quantity_actual;
            } else if (item.tran_method == "Positive") {
                balance += item.quantity_actual;
            } else if (item.tran_method == "Negative") {
                balance -= item.quantity_actual;
            }

            tableRows += `
                <tr>
                    <td>${key + 1}</td>
                    <td>${item.tran_method}</td>
                    <td>${(item.tran_method == "Purchase" || item.tran_method == "Positive") ? item.quantity_actual.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td>${(item.tran_method == "Issue" || item.tran_method == "Negative") ? item.quantity_actual.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                    <td>${item.tran_method == "Supplier Return" ? item.quantity_actual.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0}</td>
                    <td>${item.tran_method == "Client Return" ? item.quantity_actual.toLocaleString('en-US', { minimumFractionDigits: 0 }) : 0 }</td>
                    <td>${balance.toLocaleString('en-US', { minimumFractionDigits: 0 })}</td>
                    <td>${item.tran_id}</td>
                    <td>${new Date(item.tran_date).toLocaleDateString('en-CA')}</td>
                </tr>
            `;
        });

        // Inject the generated rows into the table body
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html(``);
    }
    else{
        $('.load-data .show-table tbody').html(tableRows);
        $('.load-data .show-table tfoot').html('<tr><td colspan="13" style="text-align:center;">No Data Found</td></tr>')
    }
}; // End Function



$(document).ready(function () {
    // Load Transaction Groupe
    GetTransactionGroupe(6);
    // Creating Select Options Dynamically
    // $.ajax({
    //     url: `${apiUrl}/pharmacy/report/item/flow`,
    //     method: "GET",
    //     success: function (res) {
    //         let groupein = "";
    //         let updategroupein = "";

    //         // Groupin chedckbox
    //         $.each(res.groupes, function(key, groupe) {
    //             groupein += `<input type="checkbox" id="groupe[]" name="groupe" class="groupe-checkbox"
    //             value="${groupe.id}" checked>`
    //         });
    //         $('#groupein').html(groupein);

    //         // Update Groupin chedckbox
    //         $.each(res.groupes, function(key, groupe) {
    //             updategroupein += `<input type="checkbox" id="groupe[]" name="groupe" class="updategroupe-checkbox"
    //                 value="${groupe.id}" checked>`
    //         });
    //         $('#updategroupein').html(updategroupein);
    //     },
    // });

    // Load Data on Hard Reload
    ReloadData('pharmacy/report/item/flow', ShowPharmacyItemflowStatements);
    

    // Pagination Ajax
    // PaginationAjax(ShowPharmacyItemflowStatements);


    // Search Ajax
    // SearchAjax('pharmacy/report/item/flow', ShowPharmacyItemflowStatements, {search_id: { selector: '#search', attribute: 'data-id' }});


    // Search By Month or Year
    SearchByDateAjax('pharmacy/report/item/flow', ShowPharmacyItemflowStatements, {search_id: { selector: '#product-search', attribute: 'data-id' }})



    /////////////// ------------------ Search Products By Name And Group add value to input ajax part start ---------------- /////////////////////////////
    // Head Keyup Event
    $(document).off('keyup', '#product-search').on('keyup', '#product-search', function (e) {
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
        ProductKeyUp(e, groupe, groupein, product, id, '#product-search', '#product-search-list ul');
    });

    // Product Key down Event
    $(document).off('keydown', '#product-search').on('keydown', '#product-search', function (e) {
        let list = $('#product-search-list ul li');
        ProductKeyDown(e, list, '#product-search', '#product-search-list ul li');
    });


    // Product List Key down Event
    $(document).off('keydown', '#product-search-list ul li').on('keydown', '#product-search-list ul li', function (e) {
        let list = $('#product-search-list ul li');
        let focused = $('#product-search-list ul li:focus');
        ProductListKeyDown(e, list, focused, '#product-search', '#product-search-list ul');
    });


    // Product Focus Event
    $(document).off('focus', '#product-search').on('focus', '#product-search', function (e) {
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
            getProductByGroupe(groupe, groupein, product,  '#product-search-list ul');
        }
        else{
            e.preventDefault();
        }
    });


    // Product Focous out event
    $(document).off('focusout', '#product-search').on('focusout', '#product-search', function (e) {
        let id = $(this).attr('data-id');
        if(id == undefined){
            $(document).on('click', function (e){
                if($(e.target).attr('tabindex') == undefined){
                    $('#product-search-list ul').html('');
                }
            });
        }
    });


    // Product List Click Event
    $(document).off('click', '#product-search-list ul li').on('click', '#product-search-list ul li', function () {
        let value = $(this).text();
        let id = $(this).data('id');

        $('#product-search').val(value);
        $('#product-search').attr('data-id', id);
        $('#product-search-list ul').html('');
        $('#product-search').focus();
        
        LoadSearchData('inventory/report/item/flow', ShowInventoryItemflowStatements, {search_id: { selector: '#product-search', attribute: 'data-id' }});
    });



    // Product Key Up Event Function
    function ProductKeyUp(e, groupe, groupein, product, id, targetElement1, targetElement2){
        if (e.keyCode === 13) { // Enter Key
            e.preventDefault();
        }
        else if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 8){
            //keyCode 65 = a, keyCode 90 = z, keyCode 96 = 0, keyCode 105 = 9, keyCode 8 = backSpace
            $(targetElement1).removeAttr('data-id');
            getProductByGroupe(groupe, groupein, product,  targetElement2);
        }
        else if (e.keyCode === 9) { // Tab key
            if (id != undefined) {
                e.preventDefault();
            }
            else{
                $(targetElement1).removeAttr('data-id');
                getProductByGroupe(groupe, groupein, product,  targetElement2);
            }
        }
    }


    // Product Key Down Event Function
    function ProductKeyDown(e, list, targetElement1, targetElement2) {
        if (list.length > 0) {
            if (e.keyCode === 40) { // Down arrow key
                e.preventDefault();
                list.first().focus();
                $(targetElement1).val(list.first().text());
                $(targetElement1).attr("data-id", list.data('id'));

                LoadSearchData('pharmacy/report/item/flow', ShowPharmacyItemflowStatements, {search_id: { selector: '#product-search', attribute: 'data-id' }});
            } 
            else if (e.keyCode === 38) { // Up arrow key
                e.preventDefault();
                list.last().focus();
                $(targetElement1).val(list.last().text());
                $(targetElement1).attr("data-id", list.data('id'));

                LoadSearchData('pharmacy/report/item/flow', ShowPharmacyItemflowStatements, {search_id: { selector: '#product-search', attribute: 'data-id' }});
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
    function ProductListKeyDown(e, list, focused, targetElement1, targetElement2) {
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            let nextIndex = focused.index() + 1;
            if (nextIndex >= list.length) {
                nextIndex = 0; // Loop to the first item
            }
            list.eq(nextIndex).focus();
            $(targetElement1).val(list.eq(nextIndex).text());
            $(targetElement1).attr("data-id", list.eq(nextIndex).data('id'));

            LoadSearchData('pharmacy/report/item/flow', ShowPharmacyItemflowStatements, {search_id: { selector: '#product-search', attribute: 'data-id' }});
        } 
        else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            let prevIndex = focused.index() - 1;
            if (prevIndex < 0) {
                prevIndex = list.length - 1; // Loop to the last item
            }
            list.eq(prevIndex).focus();
            $(targetElement1).val(list.eq(prevIndex).text());
            $(targetElement1).attr("data-id", list.eq(prevIndex).data('id'));

            LoadSearchData('pharmacy/report/item/flow', ShowPharmacyItemflowStatements, {search_id: { selector: '#product-search', attribute: 'data-id' }});
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
            url: `${apiUrl}/pharmacy/setup/product/get/list`,
            method: 'GET',
            data: { groupe, groupein, product },
            success: function (res) {
                $(targetElement1).html(res);
            }
        });
    }
    /////////////// ------------------ Search Head By Name And Groupe add value to input ajax part end ---------------- /////////////////////////////
});