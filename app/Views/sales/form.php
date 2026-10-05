<?= view('partials/header', ['title' => 'Record Sale']) ?>

<div class="form-card">
    <h1>Record Sale</h1>

    <form method="post" action="<?= site_url('sales') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="product_id">Product</label>
            <select id="product_id" name="product_id">
                <option value="">Select Product</option>

                <?php foreach ($products as $product): ?>
                    <option
                        value="<?= esc($product['id'], 'attr') ?>"
                        <?= old('product_id') == $product['id'] ? 'selected' : '' ?>
                    >
                        <?= esc($product['name']) ?>
                        (Stock: <?= esc($product['stock_quantity']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="text-danger"><?= validation_show_error('product_id') ?></span>
        </div>

        <div class="form-group">
            <label for="customer_id">Customer</label>
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
            <span class="text-danger"><?= validation_show_error('customer_id') ?></span>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input
                id="quantity"
                type="number"
                min="1"
                name="quantity"
                value="<?= esc(old('quantity'), 'attr') ?>"
            >
            <span class="text-danger"><?= validation_show_error('quantity') ?></span>
        </div>

        <button type="submit" class="btn btn-primary">Record Sale</button>
        <a href="<?= site_url('sales') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>

<?= view('partials/footer') ?>