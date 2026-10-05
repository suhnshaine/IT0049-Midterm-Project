<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
</head>

<body>

    <h1><?= esc($title) ?></h1>

    <?php
        $isEdit = ! empty($customer);

        $action = $isEdit
            ? site_url('customers/' . $customer['id'] . '/edit')
            : site_url('customers');
    ?>

    <form method="post" action="<?= esc($action, 'attr') ?>">

        <?= csrf_field() ?>

        <div>
            <label for="full_name">Full Name</label><br>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= esc(old('full_name', $customer['full_name'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('full_name') ?>
        </div>

        <br>

        <div>
            <label for="email">Email</label><br>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc(old('email', $customer['email'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('email') ?>
        </div>

        <br>

        <div>
            <label for="phone">Phone</label><br>

            <input
                type="text"
                id="phone"
                name="phone"
                value="<?= esc(old('phone', $customer['phone'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('phone') ?>
        </div>

        <br>

        <button type="submit">
            <?= $isEdit ? 'Update Customer' : 'Add Customer' ?>
        </button>

        <a href="<?= site_url('customers') ?>">Cancel</a>

    </form>

</body>
</html>