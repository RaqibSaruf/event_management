<!DOCTYPE html>
<html lang="en">
<?php

use App\Helpers\Auth;

require VIEW_PATH . "/layout/Head.php" ?>

<body>
    <?php require VIEW_PATH . "/layout/Layout.php" ?>
    <div class="md:max-w-2xl lg:max-w-3xl xl:max-w-5xl mx-auto px-4 py-4">
        <div class="">
            <div class="px-4 sm:px-0 flex items-center justify-between">
                <h3 class="md:text-lg lg:text-xl font-bold text-gray-900">Event Detail</h3>
                <div class="flex items-center justify-between gap-4">
                    <?php if (Auth::check()) : ?>
                        <div onclick="onModalOpen('<?= $event->id ?>', '<?= $event->name ?>')" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded shadow-md cursor-pointer">Register Attendee</div>
                        <a class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded shadow-md" href="<?= BASE_URL . "/events" ?>">Back</a>
                        <a class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md" href="<?= BASE_URL . "/events/{$event->id}/edit" ?>">Edit</a>
                    <?php else: ?>
                        <div onclick="onModalOpen('<?= $event->id ?>', '<?= $event->name ?>')" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md cursor-pointer">Register Now</div>
                        <a class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded shadow-md" href="<?= BASE_URL ?>">Back</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-6 border-t border-gray-100 rounded-md shadow-md p-4">
                <div class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">ID</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $event->id ?></div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Name</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $event->name ?></div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Duration</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"><?= "{$event->start_time} to {$event->end_time}" ?></div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Status</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"><?= date('Y-m-d H:i:s') >= $event->start_time &&  date('Y-m-d H:i:s') <= $event->end_time ? 'Active' : 'Inactive' ?></div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Max Attendee Capacity</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $event->max_capacity ?></div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Total Attendee</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <span><?= $totalAttendees ?></span>
                            <?php if (Auth::check()): ?>
                                <a class="underline ml-4 text-blue-500 hover:text-blue-300" href="<?= BASE_URL . "/events/{$event->id}/attendees" ?>">View all</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Created at</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $event->created_at ?></div>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <div class="text-sm/6 font-medium text-gray-900">Description</div>
                        <div class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 text-wrap"><?= $event->description ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require VIEW_PATH . "/components/AttendeeFormModal.php" ?>

    <script src="<?= BASE_URL . '/assets/js/attendee-modal-form.js' ?>"></script>
    <script src="<?= BASE_URL . '/assets/js/common.js' ?>"></script>
</body>

</html>