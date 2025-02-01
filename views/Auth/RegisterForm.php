<!DOCTYPE html>
<html lang="en">
<?php require VIEW_PATH . "/layout/Head.php" ?>

<body>
    <?php require VIEW_PATH . "/layout/Layout.php" ?>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign up</h2>
        </div>

        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-sm">
            <form id="registerForm" class="space-y-6" action="<?= BASE_URL . '/register' ?>" method="POST">
                <?= csrf() ?>
                <div>
                    <label for="name" class="block text-sm/6 font-medium text-gray-900">Full Name</label>
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

                <div>
                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                    </div>
                    <div id="passwordError" class="text-red-500 text-sm mt-2"><?= $errors['password'] ?? '' ?></div>
                </div>

                <div>
                    <label for="passwordConfirmation" class="block text-sm/6 font-medium text-gray-900">Confirm Password</label>
                    <div class="mt-2">
                        <input type="password" name="password_confirmation" id="passwordConfirmation" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-300 sm:text-sm/6">
                    </div>
                    <div id="passwordConfirmationError" class="text-red-500 text-sm mt-2"><?= $errors['password_confirmation'] ?? '' ?></div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 cursor-pointer">Sign up</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Already have an account?
                <a href="<?= BASE_URL . '/login' ?>" class="font-semibold text-blue-600 hover:text-blue-500">Sign in</a>
            </p>
        </div>
    </div>

    <script src="<?= BASE_URL . '/assets/js/register-form.js' ?>"></script>
    <script src="<?= BASE_URL . '/assets/js/common.js' ?>"></script>

</body>

</html>