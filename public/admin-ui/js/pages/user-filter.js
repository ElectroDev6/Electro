import NotificationSystem from "/admin-ui/js/common/notification.js";

document.addEventListener("DOMContentLoaded", function () {
    const filterBtn = document.getElementById("filter-btn");
    const resetBtn = document.getElementById("reset-btn");
    const usernameInput = document.getElementById("filter-username");
    const roleSelect = document.getElementById("filter-role");
    const tableBody = document.querySelector(".user-table__body");
    const paginationInfo = document.querySelector(".pagination__info");
    const paginationButtons = document.querySelectorAll(".pagination__btn");
    const originalRows = Array.from(tableBody.querySelectorAll(".users-table__row"));
    const rowsPerPage = 9; 
    let currentPage = 1;

    function filterUsers(page = 1) {
        const username = usernameInput.value.toLowerCase().trim();
        const role = roleSelect.value;
        const filteredRows = originalRows.filter(row => {
            const name = row.querySelector(".user-table__username").textContent.toLowerCase();
            const email = row.querySelector(".user-table__cell:nth-child(2)").textContent.toLowerCase();
            const userRole = row.querySelector(".user-table__cell:nth-child(3)").textContent.trim();
            const usernameMatch = username === '' || name.includes(username) || email.includes(username);
            const roleMatch = role === '' || {
                0: "Admin",
                1: "User",
                2: "Khách"
            }[role] === userRole;

            return usernameMatch && roleMatch;
        });
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedRows = filteredRows.slice(start, end);
        // Update table
        tableBody.innerHTML = '';
        if (paginatedRows.length > 0) {
            paginatedRows.forEach(row => tableBody.appendChild(row.cloneNode(true)));
        } else {
            const noResultsRow = document.createElement('tr');
            noResultsRow.className = 'users-table__row';
            noResultsRow.innerHTML = '<td colspan="6" class="user-table__cell">Không có người dùng nào.</td>';
            tableBody.appendChild(noResultsRow);
        }
        if (paginationInfo) {
            paginationInfo.textContent = `Hiển thị ${start + 1}-${Math.min(end, filteredRows.length)} trong số ${filteredRows.length} mục`;
        }
        paginationButtons.forEach(btn => btn.classList.remove('pagination__btn--active'));
        if (paginationButtons[page - 1]) {
            paginationButtons[page - 1].classList.add('pagination__btn--active');
        }

        currentPage = page;
    }

    function resetFilters() {
        usernameInput.value = "";
        roleSelect.value = "";
        currentPage = 1;
        tableBody.innerHTML = '';
        originalRows.forEach(row => tableBody.appendChild(row.cloneNode(true)));
        if (paginationInfo) {
            paginationInfo.textContent = `Hiển thị 1-${originalRows.length} trong số ${originalRows.length} mục`;
        }
        paginationButtons.forEach(btn => btn.classList.remove('pagination__btn--active'));
        if (paginationButtons[0]) paginationButtons[0].classList.add('pagination__btn--active');
    }
    filterBtn.addEventListener('click', () => filterUsers(1));
    resetBtn.addEventListener('click', resetFilters);
    usernameInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') filterUsers(1);
    });

    // Handle pagination clicks
    paginationButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            const page = index + 1;
            filterUsers(page);
        });
    });

    // Handle success notification from URL
    const params = new URLSearchParams(window.location.search);
    const successMessage = params.get("success");
    if (successMessage) {
        NotificationSystem.success(decodeURIComponent(successMessage), 5000);
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Initial load
    filterUsers(1);
});