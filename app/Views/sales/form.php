<?= view('partials/header', ['title' => 'Record Sale']) ?>

<div class="form-card">

    <h1>Record Sale</h1>

     ?>">

        <?= csrf_field() ?>

        <div class="form-group">
            <label>Product</label>

            <select name="product_id">

                <option value="">
                    Select Product
                </option>

                <?php foreach ($products as $product): ?>

                <option
                    value="<?= $product['id'] ?>"
                    <?= old('product_id') == $product['id'] ? 'selected' : '' ?>>

                    <?= esc($product['name']) ?>
                    (Stock: <?= esc($product['stock_quantity']) ?>)

                </option>

                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label>Customer</label>

            <select name="customer_id">
                <option value="">Walk-in Customer</option>

                <?php foreach ($customers as $customer): ?>

                <option
                    value="<?= $customer['id'] ?>"
                    <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>>

                    <?= esc($customer['full_name']) ?>

                </option>

                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label>Quantity</label>

            <input
                type="number"
                min="1"
                name="quantity"
                value="<?= old('quantity') ?>">
        </div>

        <button type="submit" class="btn btn-primary">
            Record Sale
        </button>

         ?>" class="btn btn-danger">
            Cancel
        </a>

    </form>

</div>

<?= view('partials/footer') ?>
