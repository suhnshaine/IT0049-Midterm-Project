<?= view('partials/header', ['title' => $title]) ?>

<?php
$isEdit = ! empty($user);

$action = $isEdit
    ? site_url('users/'.$user['id'].'/edit')
    : site_url('users');
?>

<div class="form-card">

    <h1><?= esc($title) ?></h1>

     ?>"
        enctype="multipart/form-data">

        <?= csrf_field() ?>

        <div class="form-group">
            <label>Username</label>
            <input type="text"
                name="username"
                value="<?= old('username',$user['username'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Full Name</label>
            <input type="text"
                name="full_name"
                value="<?= old('full_name',$user['full_name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Avatar</label>
            <input type="file" name="avatar">
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Update Staff User' : 'Add Staff User' ?>
        </button>

         ?>" class="btn btn-danger">
            Cancel
        </a>

    </form>

</div>

<?= view('partials/footer') ?>
