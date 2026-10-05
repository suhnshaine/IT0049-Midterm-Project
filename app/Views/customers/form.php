<?= view('partials/header', ['title' => $title]) ?>

<?php
$isEdit = ! empty($customer);

$action = $isEdit
    ? site_url('customers/' . $customer['id'])
    : site_url('customers');
?>

<div class="form-card">
    <h1><?= esc($title) ?></h1>

    <form action="<?= esc($action) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input
                id="full_name"
                type="text"
                name="full_name"
                value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>"
            >
            <span class="text-danger">
                <?= validation_show_error('full_name') ?>
            </span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="<?= esc(old('email', $customer['email'] ?? '')) ?>"
            >
            <span class="text-danger">
                <?= validation_show_error('email') ?>
            </span>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input
                id="phone"
                type="text"
                name="phone"
                value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>"
            >
            <span class="text-danger">
                <?= validation_show_error('phone') ?>
            </span>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Update Customer' : 'Add Customer' ?>
        </button>

        <a href="<?= site_url('customers') ?>" class="btn btn-danger">
            Cancel
        </a>
    </form>
</div>

<?= view('partials/footer') ?>