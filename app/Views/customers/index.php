<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer List</title>
</head>

<body>

    <h1>Customer List</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= site_url('customers/new') ?>">Add Customer</a>
    </p>

    <?php if (! empty($customers)): ?>

        <table border="1" cellpadding="10">
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

                        <td>
                            <?= ! empty($customer['phone'])
                                ? esc($customer['phone'])
                                : 'Not provided' ?>
                        </td>

                        <td><?= esc($customer['created_at']) ?></td>

                        <td>
                            <a href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">
                                Edit
                            </a>

                            <form
                                method="post"
                                action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>"
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

        <p>No customers found.</p>

    <?php endif; ?>

</body>
</html>