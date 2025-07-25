<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Custom DataTable</title>
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
        <!-- including custom style sheet -->
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
        <!-- Font Awesome CDN -->
        <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
    </head>
    <body>
        {{-- Add Button And Search Fields --}}
        <div class="add-search">
            <div class="rows">
                <div class="c-3">
                        <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add </button>
                </div>
                <div class="c-6">

                </div>
                <div class="c-3" style="padding: 0;">
                    <input type="text" id="globalSearch" placeholder="Search..." />
                </div>
            </div>
        </div>

        {{-- Datatable Part --}}
        <div class="load-data">
            <table class="data-table" id="data-table">
                <caption> Details</caption>
                <thead></thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
    
            <div id="paginate"></div>
        </div>


        {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
        <script>
            let tableInstance = null;
            class GenerateTable {
                constructor({tableId , data, tbody, actions}) {
                    this.table = document.querySelector(tableId); // Select Table
                    this.data = data; // Original Data
                    this.filteredData = [...data]; // Copy of Original data
                    this.currentPage = 1;
                    this.rowsPerPage = 15;
                    this.sortKey = null;
                    this.sortOrder = 'asc';
                    this.tbody = tbody;
                    this.actions = actions;
                    this.init();
                }


                init() {
                    this.renderTableBody();
                    this.bindEvents();
                }


                // Bind Events Related To the Genarated Tables
                bindEvents() {
                    // Global Search Event
                    const globalSearch = document.getElementById('globalSearch');
                    if (globalSearch) {
                        globalSearch.addEventListener('keyup', (e) => this.globalSearch(e.target.value));
                    }
                

                    // Column Filter
                    const colFilters = document.querySelectorAll('.col-filter');
                    colFilters.forEach(input => {
                        input.addEventListener('keyup', () => this.columnSearch());
                        input.addEventListener('change', () => this.columnSearch());
                    });
                

                    // Pagination Event Binding
                    document.addEventListener('click', (e) => {
                        if (e.target.matches('a.page-link') && e.target.dataset.page) {
                            e.preventDefault();
                            this.currentPage = +e.target.dataset.page;
                            this.renderTableBody();
                        }
                    });

                    // $(document).off('click', 'a.page-link').on('click', 'a.page-link', (e) => {
                    //     e.preventDefault();
                    //     this.currentPage = +e.target.dataset.page;
                    //     this.renderTableBody();
                    // });



                    // const tableHeaders = this.table.querySelectorAll('thead th[data-key]');
                    // tableHeaders.forEach(th => {
                    //     th.addEventListener('click', (e) => {
                    //         const key = e.currentTarget.dataset.key;
                    //         this.sortData(key);
                    //     });
                    // });
                
                    const exportBtn = document.getElementById('exportCSV');
                    if (exportBtn) {
                        exportBtn.addEventListener('click', () => this.exportCSV());
                    }


                    const perPage = document.getElementById('rowsPerPage');
                    if (perPage) {
                        perPage.addEventListener('change', (e) => {
                            this.currentPage = 1;
                            this.rowsPerPage = +e.target.value;

                            this.renderTableBody();
                        });
                    }
                
                    // const selectAll = document.getElementById('selectAll');
                    // if (selectAll) {
                    //     selectAll.addEventListener('change', (e) => {
                    //     const isChecked = e.target.checked;
                    //     const checkboxes = this.table.querySelectorAll('tbody input[type="checkbox"]');
                    //     checkboxes.forEach(cb => cb.checked = isChecked);
                    //     });
                    // }
                }


                // Global Search Method
                globalSearch(query) {
                    this.filteredData = this.data.filter(rows =>
                        Object.values(rows).some(val =>
                            (val ?? '').toString().toLowerCase().includes(query.toLowerCase())
                        )
                    );

                    this.currentPage = 1;
                    
                    this.renderTableBody();
                }


                // Column Search Method
                columnSearch() {
                    let filters = {};

                    document.querySelectorAll('.col-filter').forEach(input => {
                        filters[input.dataset.key] = input.value.toLowerCase(); // store the filter keys
                    });

                    this.filteredData = this.data.filter(row => {
                        return Object.keys(filters).every(key => {
                            const value = key.split('.').reduce((obj, k) => obj?.[k], row);
                            return (value ?? '').toString().toLowerCase().includes(filters[key]);
                        });
                    });

                    this.currentPage = 1;

                    this.renderTableBody();
                }


                // Sort Data Column Wise
                // sortData(key) {
                //     console.log(key);
                    
                //   this.sortOrder = (this.sortKey === key && this.sortOrder === 'asc') ? 'desc' : 'asc';
                //   this.sortKey = key;
                //   this.filteredData.sort((a, b) => {
                //     const valA = a[key].toString();
                //     const valB = b[key].toString();
                //     return this.sortOrder === 'asc'
                //       ? valA.localeCompare(valB)
                //       : valB.localeCompare(valA);
                //   });
                //   this.renderTableBody();
                // }


                // Export To CSV File
                exportCSV() {
                    if (!this.filteredData.length) return;

                    const escapeCSV = (value) => {
                        const str = value == null ? '' : value.toString();
                        return `"${str.replace(/"/g, '""')}"`;
                    };


                    const headers = Object.keys(this.filteredData[0]);
                    let csv = headers.join(',') + '\n';

                    this.filteredData.forEach(row => {
                        csv += headers.map(h => escapeCSV(row[h])).join(',') + '\n';
                    });
                    
                    // Create csv File and Download It
                    const blob = new Blob([csv], { type: 'text/csv' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'data.csv';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }


                
                // Create the tbody Rows 
                renderTableBody() {
                    const tbody = this.table.querySelector('tbody');
                    const startIndex = (this.currentPage - 1) * this.rowsPerPage;
                    const filteredData = this.filteredData.slice(startIndex, startIndex + this.rowsPerPage);

                    // Extracting the Rows one By one and create colums
                    tbody.innerHTML = filteredData.map((row, i) => { 
                        const columns = this.tbody.map(colConfig => { // Create Colums acording to tbody values
                            const col = typeof colConfig === 'string' ? { key: colConfig, type: 'text' } : colConfig;
                            const value = col.key.split('.').reduce((obj, key) => obj?.[key], row);
                            const type = col.type || 'text';
                            
                            switch (type) {
                                case 'number':
                                    return `<td style="text-align:right;">${Number(value).toLocaleString()}</td>`;
                
                                case 'status':
                                    const checked = value ? 'checked' : '';
                                    return `<td>
                                        <label class="switch">
                                            <input type="checkbox" ${checked} data-id="${row.id}" class="status-toggle">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>`;
                
                                case 'image':
                                    return `<td><img src="${apiUrl.replace('/api', '')}/storage/${value ? value : 'male.png'}?${new Date().getTime()}" alt="Image" height="30px" width="30px"></td>`
                
                                case 'date':
                                    if (!value) return `<td></td>`;
                                    const date = new Date(value);
                                    return `<td>${date.toLocaleDateString('en-US', { day:'numeric', month: 'short', year: 'numeric' })}</td>`;
                
                                case 'timestamp':
                                    if (!value) return `<td></td>`;
                                    return `<td>${new Date(value).toLocaleString()}</td>`;
                
                                default:
                                    return `<td>${value ?? ''}</td>`;
                            }
                        }).join('');
                
                        return `
                            <tr>
                                <td>${startIndex + i + 1}</td>
                                ${columns}
                                <td width="10%"><div id="actions">${this.actions(row)}</div></td>
                            </tr>`;
                    }).join('');

                    this.renderPagination();
                }



                // Create the Pagination 
                renderPagination() {
                    let totalPages = Math.ceil(this.filteredData.length / this.rowsPerPage);
                    let currentPage = this.currentPage;

                    // Arrow Function For creating page numbers 
                    const CreatePageItem = (i, isActive) => `
                        <li class="page-item ${isActive ? 'active' : ''}">
                            ${isActive ? `<span class="page-link">${i}</span>` : `<a class="page-link" data-page="${i}">${i}</a>`}
                        </li>
                    `;
                
                    // Arrow Function For Add Elipsis
                    const AddElipsis = () => `
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">...</span>
                        </li>
                    `;

                    let paginationHtml = `<nav style="display:flex;align-items:center;gap:10px;"><ul class="pagination">`;
                    
                    // Create Previous Link
                    paginationHtml += currentPage != 1 ? `
                        <li class="page-item">
                            <a class="page-link" data-page="${currentPage - 1}">&#60</a>
                        </li>
                    ` : `
                        <li class="page-item disabled">
                            <span class="page-link">&#60;</span>
                        </li>
                    `;


                    // Create Page Links
                    if (totalPages <= 10) {
                        for (let i = 1; i <= totalPages; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                    } 
                    else {
                        if (currentPage < 8) {
                            for (let i = 1; i <= 10; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                            paginationHtml += AddElipsis() + CreatePageItem(totalPages - 1) + CreatePageItem(totalPages);
                        } 
                        else if (currentPage <= totalPages - 7) {
                            paginationHtml += CreatePageItem(1) + CreatePageItem(2) + AddElipsis();
                            for (let i = currentPage - 3; i <= currentPage + 3; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                            paginationHtml += AddElipsis() + CreatePageItem(totalPages - 1) + CreatePageItem(totalPages);
                        } 
                        else {
                            paginationHtml += CreatePageItem(1) + CreatePageItem(2) + AddElipsis();
                            for (let i = totalPages - 9; i <= totalPages; i++) paginationHtml += CreatePageItem(i, i === currentPage);
                        }
                    }


                    // Create Next Link
                    paginationHtml += currentPage != totalPages ? `
                        <li class="page-item">
                            <a class="page-link" data-page="${currentPage + 1}">&#62</a>
                        </li>
                    ` : `
                        <li class="page-item disabled">
                            <span class="page-link">&#62;</span>
                        </li>
                    `;


                    paginationHtml += `</ul></nav>`;
                    
                    const pagination = document.getElementById('paginate');
                    pagination.innerHTML = '';
                    pagination.innerHTML = paginationHtml;
                } // End Render Pagination



                // Add Row After Inserting into Database
                addRow(data) {
                    this.data.unshift(data);
                    this.filteredData.unshift(data);
                    this.renderTableBody();
                }



                // Edit Row After Updating in Database
                editRow(id, updatedData) {
                    this.data = this.data.map(item => item.id == id ? { ...item, ...updatedData } : item);
                    this.filteredData = this.filteredData.map(item => item.id == id ? { ...item, ...updatedData } : item);
                    this.renderTableBody();
                }



                // Delete Row After Delete From Database
                deleteRow(id) {
                    this.data = this.data.filter(item => item.id != id);
                    this.filteredData = this.filteredData.filter(item => item.id != id);
                    this.renderTableBody();
                }
            }


            // Create the thead Rows 
            function renderTableHead(thead) {
                const head = document.querySelector('.data-table thead');
                const row1 = thead.map(h => `<th>${h.label}</th>`).join('');

                const row2 = thead.map(h => {
                    if (h.type === 'date') { // Rowper page
                        return `<th><input class="col-filter" data-key="${h.key}" type="date" style="width:82px;font-size:10px;padding:2px;"></th>`;
                    }
                    else if (h.type === 'select') { // Rowper page
                        const opts = h.options.map(option => `<option value="${option}">${option}</option>`).join('');
                        return `<th style="width:50px;"><select id="rowsPerPage">${opts}</select></th>`;
                    }
                    else if (Array.isArray(h.status)) {
                        const opts = h.status.map(item => 
                            `<option value="${item.key}">${item.label}</option>`
                        ).join('');
                    
                        return `<th style="width:60px;"><select class="col-filter" data-key="status" style="width:60px;font-size:10px;">${opts}</select></th>`;
                    }
                    else if (h.type === 'button') { // Action Button
                        return `<th><button id="exportCSV"><i class="fa-regular fa-file-excel"></i></button></th>`;
                    }
                    else if (h.key) { // Col-Fielter Input
                        return `<th><input type="text" class="col-filter" data-key="${h.key}" /></th>`;
                    }
                    else {
                        return `<th></th>`;
                    }
                }).join('');

                head.innerHTML = `
                    <tr>${row1}</tr>
                    <tr>${row2}</tr>
                `;
            } // End Render thead Rows




            document.addEventListener('DOMContentLoaded', () => {
                renderTableHead([
                    { label: 'SL:', type: 'select', options: [15, 30, 50, 100] },
                    { label: 'Name', key: 'name' },
                    { label: 'Email', key: 'email' },
                    { label: 'Age', key: 'age' },
                    { label: 'Action', type: 'button' }
                ]);


                const demoData = Array.from({ length: 1000 }, (_, i) => ({
                    name: `User ${i + 1}`,
                    email: `user${i + 1}@domain.com`,
                    age: 20 + (i % 30)
                }));

                new GenerateTable({
                    tableId: '#data-table',
                    data: demoData,
                    tbody: ['name','email','age'],
                    actions: (row) => `
                            <button data-modal-id="editModal" id="edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                                    
                            <button data-modal-id="deleteModal" data-id="${row.id}" id="delete"><i class="fas fa-trash"></i></button>
                            `,
                });

                
            });
        </script>
    </body>
</html>