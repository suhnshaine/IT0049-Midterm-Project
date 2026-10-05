<?= view('partials/header', ['title' => 'Sales History']) ?>

<h1>Sales History</h1>

<a href="<?= site_url('sales/new') ?>" class="btn btn-success">
    Record Sale
</a>

<br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Cashier</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?= esc($sale['id']) ?></td>
                <td><?= esc($sale['product_name']) ?></td>
                <td><?= esc($sale['customer_name'] ?: 'Walk-in Customer') ?></td>
                <td><?= esc($sale['cashier_name']) ?></td>
                <td><?= esc($sale['quantity']) ?></td>
                <td><?= esc(number_format($sale['total_price'], 2)) ?></td>
                <td><?= esc($sale['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('partials/footer') ?>