<!DOCTYPE html>
<html lang="en">
<?php require VIEW_PATH . "/layout/Head.php" ?>

<body>
    <?php require VIEW_PATH . "/layout/Layout.php" ?>
    <?php require VIEW_PATH . "/components/EventList.php" ?>
    <?php require VIEW_PATH . "/components/AttendeeFormModal.php" ?>

    <script>
        const isPublic = true;
        const baseUrl = "<?= BASE_URL ?>";
        const apiUrl = `${baseUrl}/api/get-events`;
        let currentPage = <?= $request->get('page') ?? 1 ?>;
        let searchQuery = "<?= $request->get('s') ?? '' ?>";
        let orderQuery = "<?= $request->get('order') ?? '' ?>";
        let dirQuery = "<?= $request->get('dir') ?? '' ?>";
    </script>
    <script src="<?= BASE_URL . '/assets/js/event-list.js' ?>"></script>
    <script src="<?= BASE_URL . '/assets/js/attendee-modal-form.js' ?>"></script>
    <script src="<?= BASE_URL . '/assets/js/common.js' ?>"></script>
</body>

</html>