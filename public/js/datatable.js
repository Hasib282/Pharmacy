class GenerateTable {
    constructor({tableId , data, createColumn}) {
        this.table = document.querySelector(tableId); // Select Table
        this.data = data; // Original Data
        this.filteredData = [...data]; // Copy of Original data
        this.currentPage = 1;
        this.rowsPerPage = 15;
        this.sortKey = null;
        this.sortOrder = 'asc';
        this.createColumn = createColumn;
        this.init();
    }


    init() {
        this.renderTable();
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
        });
    

        // Pagination Event Binding
        document.addEventListener('click', (e) => {
            if (e.target.matches('a.page-link') && e.target.dataset.page) {
                e.preventDefault();
                this.currentPage = +e.target.dataset.page;
                this.renderTable();
            }
        });

        // $(document).off('click', 'a.page-link').on('click', 'a.page-link', (e) => {
        //     e.preventDefault();
        //     this.currentPage = +e.target.dataset.page;
        //     this.renderTable();
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

                this.renderTable();
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
                val.toString().toLowerCase().includes(query.toLowerCase())
            )
        );

        this.currentPage = 1;
        
        this.renderTable();
    }


    // Column Search Method
    columnSearch() {
        let filters = {};

        $('.col-filter').each(function () {
            filters[$(this).data('key')] = $(this).val().toLowerCase(); // store the filter keys
        });

        this.filteredData = this.data.filter(row => {
            return Object.keys(filters).every(key =>
                row[key].toString().toLowerCase().includes(filters[key])
            );
        });

        this.currentPage = 1;

        this.renderTable();
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
    //   this.renderTable();
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


    
    // Create the Table Rows 
    renderTable() {
        const tbody = this.table.querySelector('tbody');
        tbody.innerHTML = '';
        const start = (this.currentPage - 1) * this.rowsPerPage;
        const pageData = this.filteredData.slice(start, start + this.rowsPerPage);
        
        let rows = "";
        pageData.forEach((row, i) => {
            rows +=`
                <tr>
                    <td>${start + i + 1}</td>
                    ${this.createColumn(row)}
                </tr>
            `;
        });
        
        tbody.innerHTML = rows;
    
        this.renderPagination();
    } // End Render Table



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
}