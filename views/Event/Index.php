<!DOCTYPE html>
<html lang="en">
<?php require VIEW_PATH . "/layout/Head.php" ?>

<body>
    <?php require VIEW_PATH . "/layout/Layout.php" ?>
    <div class="md:max-w-2xl lg:max-w-3xl xl:max-w-5xl mx-auto px-4 py-4">
        <div class="md:text-lg lg:text-xl font-bold">My Events</div>
        <div class="my-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2 mb-4">
                    <input
                        type="text"
                        id="searchValue"
                        value="<?= $request->get('s') ?? '' ?>"
                        placeholder="Search..."
                        class="p-2 border border-gray-300 focus:border-gray-500 focus-visible:outline-gray-300 rounded-md text-sm" />
                    <div id="search" class="bg-blue-300 px-2 py-1 rounded-md text-sm hover:bg-blue-400 cursor-pointer">Seacrh</div>
                    <div id="reset" class="bg-gray-300 px-2 py-1 rounded-md text-sm hover:bg-gray-400 cursor-pointer">Reset</div>
                </div>
                <div>
                    <a class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md" href="<?= BASE_URL . "/events/create" ?>">Add</a>
                </div>
            </div>
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Max Capacity</th>
                            <th class="px-6 py-3">Start Time</th>
                            <th class="px-6 py-3">End Time</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>

            <div id="pagination" class="mt-4 flex justify-center space-x-2">
            </div>
        </div>
    </div>
    <script>
        const apiUrl = "<?= BASE_URL . '/api/events' ?>";
        let currentPage = <?= $request->get('page') ?? 1 ?>;
        let searchQuery = "<?= $request->get('s') ?? '' ?>";
        let orderQuery = "<?= $request->get('order') ?? '' ?>";
        let dirQuery = "<?= $request->get('dir') ?? '' ?>";

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
                    renderPagination(result.last_page);
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

            data.forEach(event => {
                const row = `
            <tr class="bg-white border-b text-gray-700 bg-gray-50 border-gray-300">
                <td class="px-6 py-4">${event.id}</td>
                    <td class="px-6 py-4">${event.name}</td>
                    <td class="px-6 py-4">${event.max_capacity}</td>
                    <td class="px-6 py-4">${event.start_time}</td>
                    <td class="px-6 py-4">${event.end_time}</td>
                <td class="px-6 py-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                </td>
            </tr>
        `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        function renderPagination(totalPages) {
            const paginationDiv = document.getElementById("pagination");
            paginationDiv.innerHTML = "";

            if (totalPages <= 1) return;

            const prevButton = document.createElement('button');
            prevButton.textContent = 'Prev';
            prevButton.className = 'px-2 py-1 border border-gray-300 rounded cursor-pointer hover:bg-gray-200';
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
            nextButton.className = 'px-2 py-1 border border-gray-300 rounded cursor-pointer hover:bg-gray-200';
            nextButton.disabled = currentPage === totalPages;
            nextButton.onclick = () => changePage(currentPage + 1);
            paginationDiv.appendChild(nextButton);
        }

        function changePage(pageNumber) {
            currentPage = pageNumber;
            fetchEvents();
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
    </script>
    <script src="<?= BASE_URL . '/assets/js/common.js' ?>"></script>
</body>

</html>