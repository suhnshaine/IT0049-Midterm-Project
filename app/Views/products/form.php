<?= view('partials/header', ['title' => $title]) ?>

<?php
$isEdit = ! empty($product);

$action = $isEdit
    ? site_url('products/'.$product['id'].'/edit')
    : site_url('products');
?>

<div class="form-card">

    <h1><?= esc($title) ?></h1>

    <form
        method="post"
        action="<?= esc($action,'attr') ?>"
        enctype="multipart/form-data">

        <?= csrf_field() ?>

        <div class="form-group">
    name="name"
                value="<?= old('name',$product['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price"
                value="<?= old('price',$product['price'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity"
                value="<?= old('stock_quantity',$product['stock_quantity'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image">
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Update Product' : 'Add Product' ?>
        </button>

         ?>" class="btn btn-danger">
            Cancel
        </a>

    </form>

</div>

<?= view('partials/footer') ?>
