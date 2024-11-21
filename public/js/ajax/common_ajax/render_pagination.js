//////////////////// -------------------- Render the Design of Pagination Navigation/Controls -------------------- ////////////////////
function RenderPagination(pagination, link) {
    let currentPage = GetCurrentPageFromURL();
    let totalPages = pagination.last_page;

    // Arrow Function For creating page numbers 
    const CreatePageItem = (i, isActive) => `
        <li class="page-item ${isActive ? 'active' : ''}">
            ${isActive ? `<span class="page-link">${i}</span>` : `<a class="page-link" href="${`${link}?page=${i}`}">${i}</a>`}
        </li>
    `;

    // Arrow Function For Add Elipsis
    const AddElipsis = () => `
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">...</span>
        </li>
    `;

    if(pagination.next_page_url != null || pagination.prev_page_url != null){
        let paginationHtml = '<nav><ul class="pagination">';
    
        // Create Previous Link
        paginationHtml += pagination.prev_page_url ? `
            <li class="page-item">
                <a class="page-link" href="${pagination.prev_page_url}" rel="prev" aria-label="« Previous">&#60</a>
            </li>
        ` : `
            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                <span class="page-link" aria-hidden="true">&#60;</span>
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
        paginationHtml += pagination.next_page_url ? `
            <li class="page-item">
                <a class="page-link" href="${pagination.next_page_url}" rel="next" aria-label="Next »">&#62</a>
            </li>
        ` : `
            <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                <span class="page-link" aria-hidden="true">&#62;</span>
            </li>
        `;


        paginationHtml += '</ul></nav>';

        $('#paginate').html(paginationHtml);
    } 
    else{
        $('#paginate').html("");
    }
} // End Method