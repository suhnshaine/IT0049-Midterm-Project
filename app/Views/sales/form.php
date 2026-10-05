<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Sale</title>
</head>

<body>

    <h1>Record Sale</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('sales') ?>">

        <?= csrf_field() ?>

        <div>
            <label for="product_id">Product</label><br>

            <select id="product_id" name="product_id">
                <option value="">Select Product</option>

                <?php foreach ($products as $product): ?>
                    <option
                        value="<?= esc($product['id'], 'attr') ?>"
                        <?= old('product_id') == $product['id'] ? 'selected' : '' ?>
                    >
                        <?= esc($product['name']) ?>
                        - Stock: <?= esc($product['stock_quantity']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?= validation_show_error('product_id') ?>
        </div>

        <br>

        <div>
            <label for="customer_id">Customer (Optional)</label><br>

            <select id="customer_id" name="customer_id">
                <option value="">Walk-in Customer</option>

                <?php foreach ($customers as $customer): ?>
                    <option
                        value="<?= esc($customer['id'], 'attr') ?>"
                        <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>
                    >
                        <?= esc($customer['full_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?= validation_show_error('customer_id') ?>
        </div>

        <br>

        <div>
            <label for="quantity">Quantity</label><br>

            <input
                type="number"
                id="quantity"
                name="quantity"
                min="1"
                value="<?= esc(old('quantity'), 'attr') ?>"
            >

            <?= validation_show_error('quantity') ?>
        </div>

        <br>

        <button type="submit">Record Sale</button>

        <a href="<?= site_url('sales') ?>">Cancel</a>

    </form>

</body>
</html>