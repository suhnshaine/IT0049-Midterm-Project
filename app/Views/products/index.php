<?= view('partials/header', ['title' => 'Product List']) ?>

<h1>Product List</h1>

<a href="<?= site_url('products/new') ?>" class="btn btn-success">
    Add Product
</a>

<br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= esc($product['id']) ?></td>
                <td><?= esc($product['name']) ?></td>
                <td><?= number_format($product['price'], 2) ?></td>
                <td><?= esc($product['stock_quantity']) ?></td>
                <td>
                    <?php if (!empty($product['image'])): ?>
                        <img
                            src="<?= base_url('uploads/' . $product['image']) ?>"
                            alt="<?= esc($product['name']) ?>"
                            class="product-image"
                            width="80"
                            height="80"
                            style="object-fit: cover;">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td><?= esc($product['created_at']) ?></td>

                <td>
                    <div class="actions">
                        <a
                            href="<?= site_url('products/' . $product['id'] . '/edit') ?>"
                            class="btn btn-primary">
                            Edit
                        </a>

                        <form
                            method="post"
                            action="<?= site_url('products/' . $product['id'] . '/delete') ?>"
                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <?= csrf_field() ?>
                            <button
                                type="submit"
                                class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('partials/footer') ?>