<?= view('partials/header', ['title' => 'Customer List']) ?>

<h1>Customer List</h1>

<?php if (session()->getFlashdata('message')): ?>
    <div class="success-message">
        <?= esc(session()->getFlashdata('message')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="error-message">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<a href="<?= site_url('customers/new') ?>" class="btn btn-success">
    Add Customer
</a>

<br><br>

<?php if (! empty($customers)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= esc($customer['id']) ?></td>
                    <td><?= esc($customer['full_name']) ?></td>
                    <td><?= esc($customer['email']) ?></td>
                    <td><?= esc($customer['phone']) ?></td>
                    <td><?= esc($customer['created_at']) ?></td>

                    <td class="actions">
                        <a
                            href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>"
                            class="btn btn-primary">
                            Edit
                        </a>

                        <form
                            method="post"
                            action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>"
                            onsubmit="return confirm('Are you sure you want to delete this customer?');">
                            <?= csrf_field() ?>
                            <button
                                type="submit"
                                class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No customers found.</p>
<?php endif; ?>

<?= view('partials/footer') ?>