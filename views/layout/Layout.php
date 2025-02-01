<nav class="flex items-center w-full min-h-18 bg-gray-800">
    <div class="w-full py-2 lg:py-3 flex items-center justify-between text-white">
        <a href="<?= BASE_URL ?>" class="pl-4 md:pl-8 lg:pl-24 text-sm md:text-base lg:text-xl font-bold">Event Management</a>
        <?php if (!$user): ?>
            <div class="pr-4 md:pr-8 lg:pr-24 text-sm md:text-base">
                <?php if ($request->uri() !== '/login') : ?>
                    <a href="<?= BASE_URL . '/login' ?>">Login</a>
                <?php else: ?>
                    <a href="<?= BASE_URL . '/register' ?>">Sign up</a>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="flex items-center gap-4 pr-2 md:pr-4">
                <div class="text-right text-sm  hidden md:block">
                    <div><?= $user->name ?></div>
                    <div><?= $user->email ?></div>
                </div>
                <div id="dropdownToggle" class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center relative cursor-pointer">
                    <div class="text-base md:text-lg lg:text-2xl font-bold text-black"><?= substr($user->name, 0, 1) ?></div>

                    <div id="dropdownMenu" class="absolute right-0 top-full z-10 mt-2 w-48 rounded-b-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden hidden">
                        <div class="block px-4 py-2 text-sm text-gray-700 text-center md:hidden"><?= $user->name ?></div>
                        <div class="block px-4 py-2 text-sm text-gray-700 text-center md:hidden border-b-1"><?= $user->email ?></div>
                        <form action="<?= BASE_URL . "/logout" ?>" method="POST">
                            <?= csrf() ?>
                            <button type="submit" class="block w-full px-4 py-2 text-sm text-center text-gray-700 hover:bg-gray-200">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>

<?php require VIEW_PATH . "/components/Badge.php"; ?>