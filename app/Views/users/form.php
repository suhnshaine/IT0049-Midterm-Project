<?= view('partials/header', ['title' => $title]) ?>

<?php
$isEdit = ! empty($user);

$action = $isEdit
    ? site_url('users/' . $user['id'] . '/edit')
    : site_url('users');
?>

<div class="form-card">
    <h1><?= esc($title) ?></h1>

    <form
        method="post"
        action="<?= esc($action, 'attr') ?>"
        enctype="multipart/form-data"
    >
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Username</label>
            <input
                id="username"
                type="text"
                name="username"
                value="<?= esc(old('username', $user['username'] ?? ''), 'attr') ?>"
            >
            <span class="text-danger"><?= validation_show_error('username') ?></span>
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input
                id="full_name"
                type="text"
                name="full_name"
                value="<?= esc(old('full_name', $user['full_name'] ?? ''), 'attr') ?>"
            >
            <span class="text-danger"><?= validation_show_error('full_name') ?></span>
        </div>

        <div class="form-group">
            <label for="password">
                Password<?= $isEdit ? ' (leave blank to keep current password)' : '' ?>
            </label>
            <input id="password" type="password" name="password">
            <span class="text-danger"><?= validation_show_error('password') ?></span>
        </div>

        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input id="avatar" type="file" name="avatar" accept="image/*">
            <span class="text-danger"><?= validation_show_error('avatar') ?></span>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Update Staff User' : 'Add Staff User' ?>
        </button>

        <a href="<?= site_url('users') ?>" class="btn btn-danger">
            Cancel
        </a>
    </form>
</div>

<?= view('partials/footer') ?>
