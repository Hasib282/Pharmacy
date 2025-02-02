// Get Transaction With
function GetTransactionWith(type, method, targetElement, user = null, AdditionalEvent= null) {
    $.ajax({
        url: `${apiUrl}/admin/tranwith/get`,
        method: 'GET',
        data: { type, method, user },
        success: function (res) {
            if (res.status) {
                if(AdditionalEvent == 'Ok'){
                    CreateSelectOptions('#type', 'Select User Type', res.tranwith, null, 'tran_with_name')
                }
                else{
                    $(targetElement).html('');
                    $.each(res.tranwith, function (key, withs) {
                        $(targetElement).append(`<input type="checkbox" class="with-checkbox" name="with" value="${withs.id}" checked>`);
                    });
                }
            }
        }
    });
}



// Get Transaction Groupe Select Options
function GetTransactionGroupe(type = null, method = null, AdditionalEvent = null) {
    $.ajax({
        url: `${apiUrl}/admin/trangroupes/get`,
        method: 'GET',
        data: { type, method },
        success: function (res) {
            if (res.status) {
                if(AdditionalEvent == 'Ok'){
                    CreateSelectOptions('#groupe', 'Select Transaction Groupe', res.groupes, null, 'tran_groupe_name')
                }
                else{
                    let groupein = "";
                    let updategroupein = "";

                    // Groupin chedckbox
                    $.each(res.groupes, function(key, groupe) {
                        groupein += `<input type="checkbox" name="groupe" class="groupe-checkbox" value="${groupe.id}" checked>`
                    });
                    $('#groupein').html(groupein);


                    // Update Groupin chedckbox
                    $.each(res.groupes, function(key, groupe) {
                        updategroupein += `<input type="checkbox" name="groupe" class="updategroupe-checkbox"
                            value="${groupe.id}" checked>`
                    });
                    $('#updategroupein').html(updategroupein);
                }
            }
        }
    });
}











// Get Due Payment list by User Id
function getDueListByUserId(id, grid) {
    let tableRows = '';
    $.ajax({
        url: `${apiUrl}/transaction/party/get/due`,
        method: 'GET',
        data: { id:id },
        success: function (res) {
            if(res.status){
                $.each(res.data, function(key, item) {
                    tableRows += `
                    <tr>
                        <td>${key + 1}</td>
                        <td>${item.tran_id}</td>
                        <td style="text-align: right">${item.bill_amount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                        <td style="text-align: right">${item.due.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.</td>
                    </tr>`
                });

                $(grid).html(tableRows);



                let transactions = res.data ?? [];

                // Calculate total amount or show a message if no transactions
                let totalAmount = transactions.length > 0 ? transactions.reduce((sum, transaction) => sum + transaction.due, 0) : null;

                $('.due-grid tfoot').html(`
                    <tr>
                        <td colspan="4" style="text-align:${totalAmount !== null ? 'right' : 'center'};">
                            ${totalAmount !== null ? `Total Due: ${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 0 })} Tk.` : 'No transactions due'}
                        </td>
                    </tr>`
                );
            }
        }
    });
}