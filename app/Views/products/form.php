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
        $isEdit = ! empty($product);

        $action = $isEdit
            ? site_url('products/' . $product['id'] . '/edit')
            : site_url('products');
    ?>

    <form method="post" action="<?= esc($action, 'attr') ?>" enctype="multipart/form-data">

        <?= csrf_field() ?>

        <div>
            <label for="name">Product Name</label><br>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= esc(old('name', $product['name'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('name') ?>
        </div>

        <br>

        <div>
            <label for="price">Price</label><br>

            <input
                type="number"
                id="price"
                name="price"
                step="0.01"
                min="0"
                value="<?= esc(old('price', $product['price'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('price') ?>
        </div>

        <br>

        <div>
            <label for="stock_quantity">Stock Quantity</label><br>

            <input
                type="number"
                id="stock_quantity"
                name="stock_quantity"
                min="0"
                value="<?= esc(old('stock_quantity', $product['stock_quantity'] ?? ''), 'attr') ?>"
            >

            <?= validation_show_error('stock_quantity') ?>
        </div>

        <br>

        <div>
            <label for="image">Product Image</label><br>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">

            <?= validation_show_error('image') ?>
        </div>

        <br>

        <?php if ($isEdit && ! empty($product['image'])): ?>
            <p>Current image: <?= esc($product['image']) ?></p>
        <?php endif; ?>

        <button type="submit">
            <?= $isEdit ? 'Update Product' : 'Add Product' ?>
        </button>

        <a href="<?= site_url('products') ?>">Cancel</a>

    </form>

</body>
</html>