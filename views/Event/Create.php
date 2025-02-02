<!DOCTYPE html>
<html lang="en">
<?php require VIEW_PATH . "/layout/Head.php" ?>

<body>
    <?php require VIEW_PATH . "/layout/Layout.php" ?>
    <div class="md:max-w-2xl lg:max-w-3xl xl:max-w-5xl mx-auto px-4 py-4">
        <div class="md:text-lg lg:text-xl font-bold">Create Event</div>
        <div class="my-6">

            <form id="eventCreateForm" action="<?= BASE_URL . '/events' ?>" method="POST" class="md:max-w-lg space-y-6">
                <?= csrf() ?>
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
                    <label for="description" class="block text-sm/6 font-medium text-gray-900">Description</label>
                    <div class="mt-2">
                        <textarea
                            name="description"
                            id="description"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6"
                            rows="3"><?= trim(input_value(null, $oldValues['description'] ?? null) ?? '') ?></textarea>
                    </div>
                    <div id="descriptionError" class="text-red-500 text-sm mt-2"><?= $errors['description'] ?? '' ?></div>
                </div>

                <div>
                    <label for="max_capacity" class="block text-sm/6 font-medium text-gray-900">Max Attendee Capacity</label>
                    <div class="mt-2">
                        <input
                            type="number"
                            name="max_capacity"
                            id="max_capacity"
                            value="<?= input_value(null, $oldValues['max_capacity'] ?? null) ?>"
                            min="1"
                            step="1"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                    </div>
                    <div id="maxCapacityError" class="text-red-500 text-sm mt-2"><?= $errors['max_capacity'] ?? '' ?></div>
                </div>

                <div>
                    <label for="start_time" class="block text-sm/6 font-medium text-gray-900">Start Time</label>
                    <div class="mt-2">
                        <input
                            type="datetime-local"
                            name="start_time"
                            id="start_time"
                            value="<?= input_value(null, $oldValues['start_time'] ?? null) ?>"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                    </div>
                    <div id="startTimeError" class="text-red-500 text-sm mt-2"><?= $errors['start_time'] ?? '' ?></div>
                </div>

                <div>
                    <label for="end_time" class="block text-sm/6 font-medium text-gray-900">End Time</label>
                    <div class="mt-2">
                        <input
                            type="datetime-local"
                            name="end_time"
                            id="end_time"
                            value="<?= input_value(null, $oldValues['end_time'] ?? null) ?>"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                    </div>
                    <div id="endTimeError" class="text-red-500 text-sm mt-2"><?= $errors['end_time'] ?? '' ?></div>
                </div>

                <div class="flex items-center gap-6">
                    <a
                        href="<?= BASE_URL . "/events" ?>"
                        class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 cursor-pointer">Cancel</a>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 cursor-pointer">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL . '/assets/js/event-form.js' ?>"></script>
    <script src="<?= BASE_URL . '/assets/js/common.js' ?>"></script>
</body>

</html>