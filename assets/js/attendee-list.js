async function fetchEvents() {
    const params = {
        s: searchQuery,
        page: parseInt(currentPage),
        order: orderQuery,
        dir: dirQuery
    };
    const filteredParams = Object.fromEntries(
        Object.entries(params).filter(([key, value]) => {
            if (key == 'page' && value == 1) {
                return false;
            }
            return value !== "" && value !== null && value !== undefined;
        })
    );
    const searchParams = new URLSearchParams(filteredParams);

    try {
        const searchString = searchParams.toString();
        history.pushState(null, '', `${window.location.pathname}${searchString ? `?${searchString}` : ''}`);

        const response = await fetch(`${apiUrl}${searchString ? `?${searchString}` : ''}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });
        const result = await response.json();

        if (response.ok) {
            renderTable(result.data);
            renderPagination(result.total, result.prev_page, result.next_page);
        } else {
            console.error("Error fetching data", result);
        }
    } catch (error) {
        console.error("Fetch error:", error);
    }
}

function renderTable(data) {
    const tableBody = document.getElementById("table-body");
    tableBody.innerHTML = "";

    if (data?.length == 0) {
        const row = `
            <tr class="bg-white border-b text-gray-700 bg-gray-50 border-gray-300">
                <td class="px-6 py-4" colspan="6">No record found</td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
        return;
    }
    data.forEach(attendee => {
        const row = `
            <tr class="bg-white border-b text-gray-700 bg-gray-50 border-gray-300">
                <td class="px-6 py-4">${attendee.id}</td>                       
                <td class="px-6 py-4">${attendee.name}</td>
                <td class="px-6 py-4">${attendee.email}</td>
                <td class="px-6 py-4">${attendee.created_at}</td>
                <td class="px-6 py-4 flex items-center gap-2">
                        <form method="POST" action="${baseUrl}/events/${eventId}/attendees/${attendee.id}">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 cursor-pointer">Delete</button>
                        </form>
                    </td>                       
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
    });
}

function renderPagination(totalItems, prevPage, nextPage) {
    const totalPages = parseInt(Math.ceil(totalItems / 20));
    const paginationDiv = document.getElementById("pagination");
    paginationDiv.innerHTML = "";

    const prevButton = document.createElement('button');
    prevButton.textContent = 'Prev';
    prevButton.className = `px-2 py-1 border border-gray-300 rounded  hover:bg-gray-200 ${!prevPage ? 'disabled !bg-gray-100' : 'cursor-pointer'}`;
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => changePage(currentPage - 1);
    paginationDiv.appendChild(prevButton);

    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        pageButton.className = `px-2 py-1 border border-gray-300 rounded cursor-pointer hover:bg-gray-200 ${i === currentPage ? 'bg-blue-500 text-white' : ''}`;
        pageButton.onclick = () => changePage(i);
        paginationDiv.appendChild(pageButton);
    }

    const nextButton = document.createElement('button');
    nextButton.textContent = 'Next';
    nextButton.className = `px-2 py-1 border border-gray-300 rounded  hover:bg-gray-200$ ${!nextPage ? 'disabled !bg-gray-100' : 'cursor-pointer'}`;
    nextButton.disabled = currentPage === totalPages;
    nextButton.onclick = () => changePage(currentPage + 1);
    paginationDiv.appendChild(nextButton);
}

function changePage(pageNumber) {
    currentPage = pageNumber;
    fetchEvents();
}

function sortTable(column) {
    if (orderQuery === column) {
        dirQuery = dirQuery === "asc" ? "desc" : "asc";
    } else {
        orderQuery = column;
        dirQuery = "asc";
    }
    currentPage = 1;
    fetchEvents();

    const columns = ["id", "name", "email", "created_at"];
    
    columns.forEach(col => {
        const iconElement = document.getElementById(`sort-${col}`);
        if (!iconElement) return;

        if (col === orderQuery) {
            iconElement.innerHTML = dirQuery === "asc" ? "▲" : "▼";
            iconElement.classList.add("text-blue-500", "font-bold");
        } else {
            iconElement.innerHTML = "";
            iconElement.classList.remove("text-blue-500", "font-bold");
        }
    });
}

document.getElementById("search").addEventListener("click", function() {
    const value = document.getElementById("searchValue").value.trim();
    if (value != '') {
        searchQuery = value;
        currentPage = 1;
        fetchEvents();
    }
});
document.getElementById("reset").addEventListener("click", function() {
    searchQuery = '';
    document.getElementById("searchValue").value = searchQuery;
    currentPage = 1;
    fetchEvents();
});

fetchEvents();
