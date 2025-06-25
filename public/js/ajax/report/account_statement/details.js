// function ShowDetailsReports(data, startIndex) {
//     let opening = formatNumber(data.opening.total_receive - data.opening.total_payment);
//     $('#opening').text(opening)

//     let tableRows = '';
//     let grandReceive = 0;
//     let grandPayment = 0;

//     if(!$.isEmptyObject(data)){
//         $.each(data, function(title, datas) {
//             if(title != "opening" && title != "status"){
//                 if (Array.isArray(datas) && datas.length > 0) {
//                     let totalReceive = 0;
//                     let totalPayment = 0;
                    
//                     tableRows += `
//                     <tr>
//                         <td colspan="3">
//                             <table class="show-table" style="margin:20px 0;">
//                                 <thead>
//                                     <caption class="sub-caption">${title} Transaction</caption>
//                                     <tr>
//                                         <th style="width: 5%;">SL:</th>
//                                         <th style="width: 10%;">Tran Id</th>
//                                         <th style="text-align: center; width:20%;">Groupe</th>
//                                         <th style="text-align: center; width:40%;">Product/Service</th>
//                                         <th style="text-align: center; width:12%;">Receive</th>
//                                         <th style="text-align: center; width:12%;">Payment</th>
//                                     </tr>
//                                 </thead>
//                                 <tbody>`;

//                                     $.each(datas, function(key, item) {
//                                         let lastGroupeId = null;
//                                         let lastTranId = null;
//                                         totalReceive += item.receive;
//                                         totalPayment += item.payment;

                                        

//                                         tableRows += `
//                                         <tr>
//                                             <td>${key +1}</td>
//                                             ${item.tran_id != lastTranId ? 
//                                                 `<td>${item.tran_id}</td>
//                                                 <td>${item.groupe.tran_groupe_name}</td>` 
//                                                 :   
//                                                 `<td></td>
//                                                 ${item.tran_groupe_id != lastGroupeId ? 
//                                                     `<td>${item.groupe.tran_groupe_name}</td>` 
//                                                     : 
//                                                     `<td></td>`
//                                                 }`
//                                             }
                                            
//                                             <td>${item.head.tran_head_name}</td>
//                                             <td style="text-align: right">${formatNumber(item.receive)}</td>
//                                             <td style="text-align: right">${formatNumber(item.payment)}</td>
//                                         </tr>`;

//                                         lastTranId = item.tran_id;
//                                         lastGroupeId = item.tran_groupe_id;
//                                     });

//                                     grandReceive += totalReceive;
//                                     grandPayment += totalPayment;

//                                 tableRows += `
//                                 </tbody>
//                                 <tfoot>
//                                     <tr>
//                                         <td colspan="4" style="text-align: right">Sub Total:</td>
//                                         <td style="text-align: right;">${formatNumber(totalReceive)}</td>
//                                         <td style="text-align: right;">${formatNumber(totalPayment)}</td>
//                                     </tr>     
//                                 </tfoot> 
//                             </table>
//                         </td>
//                     </tr>`;
//                 }
//             }
//         });

//         $('#grandReceive').text(formatNumber(grandReceive));
//         $('#grandPayment').text(formatNumber(grandPayment));
//         $('#closing').text(formatNumber(opening + grandReceive - grandPayment));

//         // Inject the generated rows into the table body
//         $('.load-data .show-table tbody').html(tableRows);
//         // $('.load-data .show-table tfoot').html('')
//     }
//     else{
//         $('.load-data .show-table tbody').html('');
//         // $('.load-data .show-table tfoot').html('<tr><td colspan="5" style="text-align:center;">No Data Found</td></tr>')
//     }
// }; // End Function

function ShowDetailsReports(res) {
    let opening = Number(res.data.opening.total_receive - res.data.opening.total_payment);

    let tableRows = '';
    let grandReceive = 0;
    let grandPayment = 0;
    let balance = opening;
    console.log(opening);
    
    if ($('#data-table thead #opening-row').length === 0) {
        $('#data-table thead').append(`<tr id="opening-row">
                                        <th style="text-align: right;" colspan="5">Opening Balance</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right; width:10%;" id="opening">${formatNumber(opening)}</th>
                                    </tr>`);
    }
    else{
        $('#opening').html(formatNumber(opening))
    }

    if(!$.isEmptyObject(res.data)){
        $.each(res.data, function(title, datas) {
            if(title != "opening" && title != "status"){
                if (Array.isArray(datas) && datas.length > 0) {
                    let totalReceive = 0;
                    let totalPayment = 0;
                    let lastGroupeId = null;
                    let lastTranId = null;
                    
                    tableRows += `
                    <tr>
                        <td colspan="13" style="font-size:18px;padding: 8px 0 8px 4px;">
                            <strong>${title} Transaction </strong>
                        </td>    
                    <tr>`;

                    $.each(datas, function(key, item) {
                        
                        totalReceive += item.receive;
                        totalPayment += item.payment;
                        balance += item.receive;
                        balance -= item.payment;
                        

                        tableRows += `
                        <tr>
                            ${item.tran_id != lastTranId ? 
                                `<td>${item.tran_id}</td>
                                <td>${new Date(item.tran_date).toLocaleDateString('en-US', { day:'numeric', month: 'short', year: 'numeric' })}</td> 
                                <td>${item.tran_bank ? item.bank?.name: item.user?.user_name}</td> 
                                <td>${item.groupe?.tran_groupe_name}</td>` 
                                // <td>${item.groupe.tran_groupe_name}</td>` 
                                :  
                                `<td></td>
                                <td></td>
                                <td></td>
                                ${item.tran_groupe_id != lastGroupeId ? 
                                    `<td>${item.groupe?.tran_groupe_name}</td>` 
                                    // `<td>${item.groupe.tran_groupe_name}</td>` 
                                    : 
                                    `<td></td>`
                                }`
                            }
                            
                            <td>${item.head?.tran_head_name}</td>
                            <td style="text-align: right">${formatNumber(item.receive)}</td>
                            <td style="text-align: right">${formatNumber(item.payment)}</td>
                            <td style="text-align: right">${formatNumber(balance)}</td>
                        </tr>`;

                        lastTranId = item.tran_id;
                        lastGroupeId = item.tran_groupe_id;
                    });

                    grandReceive += totalReceive;
                    grandPayment += totalPayment;

                    tableRows += `
                    <tr>
                        <td colspan="5">Sub Total:</td>
                        <td style="text-align: right;">${formatNumber(totalReceive)}</td>
                        <td style="text-align: right;">${formatNumber(totalPayment)}</td>
                        <td style="text-align: right;">${formatNumber(balance)}</td>
                    </tr>`;

                }
            }
        });
        $('#data-table tbody').html(tableRows);
    }

    $('#data-table tfoot').html(
        `<tr>
            <td style="text-align: right;" colspan="5">Grand Total:</td>
            <td style="text-align: right;width:10%;">${formatNumber(Number(grandReceive))}</td>
            <td style="text-align: right;width:10%;">${formatNumber(Number(grandPayment))}</td>
            <td style="width:10%;"></td>
        </tr>
        <tr>
            <td style="text-align: right;" colspan="5">Closing Balance</td>
            <td></td>
            <td></td>
            <td style="text-align: right;">${formatNumber(Number(opening + grandReceive - grandPayment))}</td>
        </tr>`
    );
    

    UpdateUrl('/api/report/account/details/print', {type: $("#typeOption").val(),startDate: $('#startDate').val(), endDate: $('#endDate').val() });
}

$(document).ready(function () {
    // Render The Table Heads
    renderTableHead([
        { label: 'Tran Id', key: 'tran_id' },
        { label: 'Date', key: 'tran_date', type:"date" },
        { label: 'Client/Supplier', key: 'user.user_name' },
        { label: 'Groupe', key: 'groupe.tran_groupe_name' },
        { label: 'Product/Service', key:'head.tran_head_name' },
        { label: 'Receive' },
        { label: 'Payment' },
        { label: 'Balance' },
    ]);


    // Load Data on Hard Reload
    ReloadData('report/account/details', ShowDetailsReports);


    // Search By Date
    SearchByDateAjax('report/account/details/search', ShowDetailsReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/account/details/search', ShowDetailsReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    })
});