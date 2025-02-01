<?php if (isset($successMsg) && $successMsg): ?>
    <div id="successBadge" class="w-full flex px-2 sm:px-4 md:px-30 lg:px-42 mt-3">
        <div class="w-full flex items-center justify-between bg-green-300 p-4 rounded-lg shadow-lg">
            <div class="font-bold"><?= $successMsg ?></div>
            <div id="successBadgeClose" class="font-bold cursor-pointer">x</div>
        </div>
    </div>
<?php endif; ?>


<?php if (isset($errorMsg) && $errorMsg): ?>
    <div id="errorBadge" class="w-full flex px-2 sm:px-4 md:px-30 lg:px-42 mt-3">
        <div class="w-full flex items-center justify-between bg-red-300 p-4 rounded-lg shadow-lg">
            <div class="font-bold"><?= $errorMsg ?></div>
            <div id="errorBadgeClose" class="font-bold cursor-pointer">x</div>
        </div>
    </div>
<?php endif; ?>