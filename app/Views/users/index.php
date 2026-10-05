<?= view('partials/header', ['title' => 'User List']) ?>

<h1>User List</h1>

<a href="<?= site_url('users/new') ?>" class="btn btn-success">
    Add Staff User
</a>

<br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Avatar</th>
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
                <td><?= esc($user['avatar'] ?: 'No Avatar') ?></td>
                <td><?= esc($user['created_at']) ?></td>

                <td class="actions">
                    <a
                        href="<?= site_url('users/' . $user['id'] . '/edit') ?>"
                        class="btn btn-warning"
                    >
                        Edit
                    </a>

                    <form
                        method="post"
                        action="<?= site_url('users/' . $user['id'] . '/delete') ?>"
                    >
                        <?= csrf_field() ?>

                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= view('partials/footer') ?>
