<?= view('partials/header', ['title' => 'Product List']) ?>

<h1>Product List</h1>

 ?>" class="btn btn-success">
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
            <td><?= number_format($product['price'],2) ?></td>
            <td><?= esc($product['stock_quantity']) ?></td>
            <td><?= esc($product['image'] ?: 'No image') ?></td>
            <td><?= esc($product['created_at']) ?></td>

            <td class="actions">

                <a
                    href="<?= site_url('products/'.$product['id    Edit
                </a>

                <form
                    method="post"
                    action="<?= site_url('products/'.$product['id'].'/delete') ?>">

                    <?= csrf_field() ?>

                    <     </form>

            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

<?= view('partials/footer') ?>
