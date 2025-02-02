<!DOCTYPE html>
<html lang="en">
<?php

use App\Helpers\Auth;

require VIEW_PATH . "/layout/Head.php" ?>

<body>
    <?php require VIEW_PATH . "/layout/Layout.php" ?>
    <div class="md:max-w-2xl lg:max-w-3xl xl:max-w-5xl mx-auto px-4 py-4">
        <div class="md:text-lg lg:text-xl font-bold">Event Registration</div>
        <p class="mt-2 text-sm text-gray-400"><?= $event->name ?></p>
        <div class="my-6">

            <form id="eventRegistrationForm" action="<?= BASE_URL . '/events/' . $event->id . '/attendees'  ?>" method="POST" class="md:max-w-lg space-y-6">
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
                    <a
                        href="<?= Auth::check() ? BASE_URL . "/events" : BASE_URL ?>"
                        class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 cursor-pointer">Cancel</a>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 cursor-pointer">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL . '/assets/js/event-registration-form.js' ?>"></script>
    <script src="<?= BASE_URL . '/assets/js/common.js' ?>"></script>
</body>

</html>