<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product List</title>
</head>

<body>

    <h1>Product List</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= site_url('products/new') ?>">Add Product</a>
    </p>

    <?php if (! empty($products)): ?>

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Image Filename</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($products as $product): ?>

                    <tr>
                        <td><?= esc($product['id']) ?></td>

                        <td><?= esc($product['name']) ?></td>

                        <td>
                            <?= number_format((float) $product['price'], 2) ?>
                        </td>

                        <td>
                            <?= esc($product['stock_quantity']) ?>
                        </td>

                        <td>
                            <?= ! empty($product['image'])
                                ? esc($product['image'])
                                : 'No image' ?>
                        </td>

                        <td>
                            <?= esc($product['created_at']) ?>
                        </td>

                        <td>
                            <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>">
                                Edit
                            </a>

                            <form
                                method="post"
                                action="<?= site_url('products/' . $product['id'] . '/delete') ?>"
                            >
                                <?= csrf_field() ?>

                                <button type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    <?php else: ?>

        <p>No products found.</p>

    <?php endif; ?>

</body>
</html>