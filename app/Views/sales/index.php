<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History</title>
</head>

<body>

    <h1>Sales History</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= site_url('sales/new') ?>">Record New Sale</a>
    </p>

    <?php if (! empty($sales)): ?>

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Cashier</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= esc($sale['id']) ?></td>

                        <td>
                            <?= esc($sale['product_name']) ?>
                        </td>

                        <td>
                            <?= ! empty($sale['customer_name'])
                                ? esc($sale['customer_name'])
                                : 'Walk-in Customer' ?>
                        </td>

                        <td>
                            <?= esc($sale['cashier_name']) ?>
                        </td>

                        <td>
                            <?= esc($sale['quantity']) ?>
                        </td>

                        <td>
                            <?= number_format((float) $sale['total_price'], 2) ?>
                        </td>

                        <td>
                            <?= esc($sale['created_at']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <p>No sales found.</p>

    <?php endif; ?>

</body>
</html>