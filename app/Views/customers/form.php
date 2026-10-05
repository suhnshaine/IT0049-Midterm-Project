<?= view('partials/header', ['title' => $title]) ?>

<?php
$isEdit = ! empty($customer);

$action = $isEdit
    ? site_url('customers/'.$customer['id'].'/edit')
    : site_url('customers');
?>

<div class="form-card">

    <h1><?= esc($title) ?></h1>

    <?>">

        <?= csrf_field() ?>

        <div class="form-group">
            <label>Full Name</label>

            <input
                type="text"
                name="full_name"
                value="<?= old('full_name', $customer['full_name'] ?? '') ?>">

            <span class="text-danger">
                <?= validation_show_error('full_name') ?>
            </span>
        </div>

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="<?= old('email', $customer['email'] ?? '') ?>">

            <span class="text-danger">
                <?= validation_show_error('email') ?>
            </span>
        </div>

        <div class="form-group">
            <label>Phone</label>

            <input
                type="text"
                name="phone"
                value="<?= old('phone', $customer['phone'] ?? '') ?>">

            <span class="text-danger">
                <?= validation_show_error('phone') ?>
            </span>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Update Customer' : 'Add Customer' ?>
        </button>

         ?>" class="btn btn-danger">
            Cancel
        </a>

    </form>

</div>

<?= view('partials/footer') ?>
