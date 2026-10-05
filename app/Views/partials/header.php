<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'POS System') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<header class="header">
    <div class="logo">
        POS System
    </div>
    <nav>
        <a href="<?= site_url('products') ?>">Products</a>
        <a href="<?= site_url('customers') ?>">Customers</a>
        <a href="<?= site_url('users') ?>">Users</a>
        <a href="<?= site_url('sales') ?>">Sales</a>
        
        <form action="<?= site_url('logout') ?>" method="post" style="display:inline;">
            <?= csrf_field() ?>
            <button
                type="submit"
                class="btn btn-danger"
            >
                Logout
            </button>
        </form>
    </nav>
</header>
<div class="container">
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