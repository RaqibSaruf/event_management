<div class="md:max-w-2xl lg:max-w-3xl xl:max-w-5xl mx-auto px-4 py-4">
    <div class="md:text-lg lg:text-xl font-bold"><?= $isPublic ? 'Events' : 'My Events' ?></div>
    <div class="my-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 mb-4">
                <input
                    type="text"
                    id="searchValue"
                    value="<?= $request->get('s') ?? '' ?>"
                    placeholder="Search..."
                    class="p-2 border border-gray-300 focus:border-gray-500 focus-visible:outline-gray-300 rounded-md text-sm" />
                <div id="search" class="bg-blue-300 px-4 py-2 rounded-md text-sm hover:bg-blue-400 cursor-pointer">Seacrh</div>
                <div id="reset" class="bg-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-400 cursor-pointer">Reset</div>
            </div>
            <?php if (!$isPublic): ?>
                <div>
                    <a class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md" href="<?= BASE_URL . "/events/create" ?>">Add</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable('id')">#<span id="sort-id" class="ml-2"></span></th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable('name')">Name<span id="sort-name" class="ml-2"></span></th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable('max_capacity')">Max Capacity<span id="sort-max_capacity" class="ml-2"></span></th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable('start_time')">Start Time<span id="sort-start_time" class="ml-2"></span></th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable('end_time')">End Time<span id="sort-end_time" class="ml-2"></span></th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable('created_at')">Created at<span id="sort-created_at" class="ml-2"></span></th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body"></tbody>
            </table>
        </div>

        <div id="pagination" class="mt-4 flex justify-end space-x-2">
        </div>
    </div>
</div>