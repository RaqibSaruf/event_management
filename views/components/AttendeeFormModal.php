<div id="eventModal" class="fixed inset-0 bg-gray-800/30 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
        <div class="flex justify-between items-start border-b pb-2 mb-4">
            <div>
                <h2 class="text-lg font-semibold">Event Registration <span id="modalMsg" class="text-green-500 text-sm"></span></h2>
                <p class="mt-2 text-sm text-gray-400" id="modalEventName"></p>
            </div>
            <button id="closeModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        </div>
        <form id="eventRegistrationForm" class="md:max-w-lg space-y-6">
            <input id="eventId" name="event_id" type="hidden" />
            <div>
                <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                <div class="mt-2">
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="<?= input_value(null, $oldValues['name'] ?? null) ?>"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                </div>
                <div id="nameError" class="text-red-500 text-sm mt-2"><?= $errors['name'] ?? '' ?></div>
            </div>
            <div>
                <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                <div class="mt-2">
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="<?= input_value(null, $oldValues['email'] ?? null) ?>"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                </div>
                <div id="emailError" class="text-red-500 text-sm mt-2"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div class="flex items-center gap-6">
                <button type="button" id="closeModalBtn" class="cursor-pointer px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                <button
                    id="eventRegistrationSubmitBtn"
                    type="submit"
                    class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 cursor-pointer">
                    Register <span id="btnLoading" class="hidden ml-4">Loading ...</span>
                </button>
            </div>
        </form>
    </div>
</div>