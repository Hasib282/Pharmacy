// function ShowSummaryGroupeReports(data, startIndex) {
    // let opening = formatNumber(data.opening.total_receive - data.opening.total_payment);
    // $('#opening').text(opening)

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
//                                         <th style="text-align: center; width:20%;">Groupe</th>
//                                         <th style="text-align: center; width:12%;">Receive</th>
//                                         <th style="text-align: center; width:12%;">Payment</th>
//                                     </tr>
//                                 </thead>
//                                 <tbody>`;

//                                     $.each(datas, function(key, item) {
//                                         let lastGroupeId = null;
//                                         totalReceive += item.total_receive;
//                                         totalPayment += item.total_payment;

                                        

//                                         tableRows += `
//                                         <tr>
//                                             <td>${key +1}</td>
//                                             ${item.tran_groupe_id != lastGroupeId ? `<td>${item.groupe.tran_groupe_name}</td>` : `<td></td>`}
//                                             <td style="text-align: right">${formatNumber(item.total_receive)}</td>
//                                             <td style="text-align: right">${formatNumber(item.total_payment)}</td>
//                                         </tr>`;

//                                         lastGroupeId = item.tran_groupe_id;
//                                     });
//                                     grandReceive += totalReceive;
//                                     grandPayment += totalPayment;


//                                 tableRows += `
//                                 </tbody>
//                                 <tfoot>
//                                     <tr>
//                                         <td colspan="2" style="text-align: right">Sub Total:</td>
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


function ShowSummaryGroupeReports(res) {
    let opening = Number(res.data.opening.total_receive - res.data.opening.total_payment);
    $('#opening').text(opening)

    let tableRows = '';
    let grandReceive = 0;
    let grandPayment = 0;
    
    if(!$.isEmptyObject(res.data)){
        $.each(res.data, function(title, datas) {
            if(title != "opening" && title != "status"){
                if (Array.isArray(datas) && datas.length > 0) {
                    let totalReceive = 0;
                    let totalPayment = 0;
                    
                    tableRows += `
                    <tr>
                        <td colspan="3">
                            <table class="show-table" style="margin:20px 0;">
                                <thead>
                                    <caption class="sub-caption">${title} Transaction</caption>
                                    <tr>
                                        <th style="width: 5%;">SL:</th>
                                        <th style="text-align: center; width:20%;">Groupe</th>
                                        <th style="text-align: center; width:12%;">Receive</th>
                                        <th style="text-align: center; width:12%;">Payment</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                    $.each(datas, function(key, item) {
                                        let lastGroupeId = null;
                                        totalReceive += item.total_receive;
                                        totalPayment += item.total_payment;

                                        

                                        tableRows += `
                                        <tr>
                                            <td>${key +1}</td>
                                            ${item.tran_groupe_id != lastGroupeId ? `<td>${item.tran_groupe_id}</td>` : `<td></td>`}
                                            <td style="text-align: right">${formatNumber(item.total_receive)}</td>
                                            <td style="text-align: right">${formatNumber(item.total_payment)}</td>
                                        </tr>`;

                                        lastGroupeId = item.tran_groupe_id;
                                    });
                                    grandReceive += totalReceive;
                                    grandPayment += totalPayment;


                                tableRows += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: right">Sub Total:</td>
                                        <td style="text-align: right;">${formatNumber(totalReceive)}</td>
                                        <td style="text-align: right;">${formatNumber(totalPayment)}</td>
                                    </tr>     
                                </tfoot> 
                            </table>
                        </td>
                    </tr>`;
                }
            }
        });
        $('#data-table tbody').html(tableRows);
    }
    // tableInstance = new GenerateTable({
    //     tableId: '#data-table',
    //     data: res.data,
    //     tbody: ['head.tran_head_name',{key:'expiry_date', type: 'date'},{key:'quantity',type:'number'},'tran_id'],
    // });

    $('#grandReceive').text(Number(grandReceive));
    $('#grandPayment').text(Number(grandPayment));
    $('#closing').text(Number(opening + grandReceive - grandPayment));
}



$(document).ready(function () {
    // $(document).off(`.${'SearchBySelect'}`);


    // Render The Table Heads
    // renderTableHead([
    //     { label: 'SL:', type: 'select', options: [15, 30, 50, 100, 500] },
    //     { label: 'Company Id', key: 'company_id' },
    //     { label: 'Company Name', key: 'name' },
    //     { label: 'Permission', key: 'permission' },
    //     { label: 'Action', type: 'button' }
    // ]);


    // Load Data on Hard Reload
    ReloadData('report/account/summarygroupe', ShowSummaryGroupeReports);


    // Search By Date
    SearchByDateAjax('report/account/summarygroupe/search', ShowSummaryGroupeReports, {type: $("#typeOption").val()});


    // Search by Type
    SearchBySelect('report/account/summarygroupe/search', ShowSummaryGroupeReports, "#typeOption", {type: $("#typeOption").val()});


    // Get Trantype
    GetSelectInputList('admin/mainheads/get', function (res) {
        CreateSelectOptions('#typeOption', "Select Tran Type", res.data, 'type_name');
    })
});