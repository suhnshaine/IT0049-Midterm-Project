<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <h1>Staff Login</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login') ?>">

        <?= csrf_field() ?>

        <div>
            <label for="username">Username</label><br>

            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc(old('username'), 'attr') ?>"
            >

            <?= validation_show_error('username') ?>
        </div>

        <br>

        <div>
            <label for="password">Password</label><br>

            <input
                type="password"
                id="password"
                name="password"
            >

            <?= validation_show_error('password') ?>
        </div>

        <br>

        <button type="submit">Log In</button>

    </form>

</body>
</html>