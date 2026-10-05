<?= view('partials/header', ['title' => $title]) ?>

<?php
$isEdit = ! empty($product);

$action = $isEdit
    ? site_url('products/' . $product['id'] . '/edit')
    : site_url('products');
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
            <label for="name">Product Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="<?= esc(old('name', $product['name'] ?? ''), 'attr') ?>"
            >
            <span class="text-danger"><?= validation_show_error('name') ?></span>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input
                id="price"
                type="number"
                step="0.01"
                name="price"
                value="<?= esc(old('price', $product['price'] ?? ''), 'attr') ?>"
            >
            <span class="text-danger"><?= validation_show_error('price') ?></span>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input
                id="stock_quantity"
                type="number"
                name="stock_quantity"
                value="<?= esc(old('stock_quantity', $product['stock_quantity'] ?? ''), 'attr') ?>"
            >
            <span class="text-danger"><?= validation_show_error('stock_quantity') ?></span>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input id="image" type="file" name="image" accept="image/*">
            <span class="text-danger"><?= validation_show_error('image') ?></span>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Update Product' : 'Add Product' ?>
        </button>

        <a href="<?= site_url('products') ?>" class="btn btn-danger">
            Cancel
        </a>
    </form>
</div>

<?= view('partials/footer') ?>
