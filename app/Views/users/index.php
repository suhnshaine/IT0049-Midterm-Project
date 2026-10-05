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
                <td>
                    <?php if (!empty($user['avatar'])): ?>
                        <img
                            src="<?= base_url('uploads/' . $user['avatar']) ?>"
                            alt="<?= esc($user['avatar']) ?>"
                            class="product-image"
                            width="80"
                            height="80"
                            style="object-fit: cover;">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td><?= esc($user['created_at']) ?></td>

                <td>
                    <div class="actions">
                        <a
                            href="<?= site_url('users/' . $user['id'] . '/edit') ?>"
                            class="btn btn-primary">
                            Edit
                        </a>

                        <form
                            method="post"
                            action="<?= site_url('users/' . $user['id'] . '/delete') ?>"
                            style="display:inline"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
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