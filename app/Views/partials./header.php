<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User List</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    
</head>

<body>

    <h1>User List</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= site_url('users/new') ?>">Add Staff User</a>
    </p>

    <?php if (! empty($users)): ?>

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Avatar Filename</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($users as $user): ?>

                    <tr>
                        <td><?= esc($user['id']) ?></td>

                        <td><?= esc($user['username']) ?></td>

                        <td><?= esc($user['full_name']) ?></td>

                        <td>
                            <?= ! empty($user['avatar'])
                                ? esc($user['avatar'])
                                : 'No avatar' ?>
                        </td>

                        <td><?= esc($user['created_at']) ?></td>

                        <td>
                            <a href="<?= site_url('users/' . $user['id'] . '/edit') ?>">
                                Edit
                            </a>

                            <form
                                method="post"
                                action="<?= site_url('users/' . $user['id'] . '/delete') ?>"
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

        <p>No users found.</p>

    <?php endif; ?>

</body>
</html>
