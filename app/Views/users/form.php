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
        $isEdit = ! empty($user);

        $action = $isEdit
            ? site_url('users/' . $user['id'] . '/edit')
            : site_url('users');
    ?>

    <form method="post"
          action="<?= esc($action, 'attr') ?>"
          enctype="multipart/form-data">

        <?= csrf_field() ?>

        <div>
            <label for="username">Username</label><br>

            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc(old('username', $user['username'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('username') ?>
        </div>

        <br>

        <div>
            <label for="full_name">Full Name</label><br>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= esc(old('full_name', $user['full_name'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('full_name') ?>
        </div>

        <br>

        <div>
            <label for="password">Password</label><br>

            <input
                type="password"
                id="password"
                name="password"
            >

            <?= validation_show_error('password') ?>

            <?php if ($isEdit): ?>
                <p>Leave blank to keep the current password.</p>
            <?php endif; ?>
        </div>

        <br>

        <div>
            <label for="avatar">Avatar</label><br>

            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/jpeg,image/png,image/webp"
            >

            <?= validation_show_error('avatar') ?>
        </div>

        <br>

        <?php if ($isEdit && ! empty($user['avatar'])): ?>
            <p>Current avatar: <?= esc($user['avatar']) ?></p>
        <?php endif; ?>

        <button type="submit">
            <?= $isEdit ? 'Update Staff User' : 'Add Staff User' ?>
        </button>

        <a href="<?= site_url('users') ?>">Cancel</a>

    </form>

</body>
</html>