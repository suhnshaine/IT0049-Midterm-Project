<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

<div class="login-page">

    <div class="login-card">

        <h1>Staff Login</h1>

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

         ?>">

            <?= csrf_field() ?>

            <div class="form-group">
                <label>Username</label>
                <input type="text"
                       name="username"
                       value="<?= old('username') ?>">

                <span class="text-danger">
                    <?= validation_show_error('username') ?>
                </span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">

                <span class="text-danger">
                    <?= validation_show_error('password') ?>
                </span>
            </div>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>
