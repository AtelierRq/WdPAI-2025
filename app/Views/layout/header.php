<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dębowy Jar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/assets/css/main.css">
    <script defer src="/assets/js/menu.js"></script>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">

        <a href="/" class="logo">
            <img src="/assets/images/debowyjar_logo.png" alt="Dębowy Jar">
        </a>

        <button class="menu-toggle" aria-label="Menu">
            ☰
        </button>

        <nav class="main-nav">
            <a href="/#o-nas">O nas</a>
            <a href="/booking" class="btn-nav">Rezerwuj</a>

            <?php if (!empty($_SESSION['user'])): ?>

                <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                    <a href="/admin/bookings/pending">Oczekujące</a>
                <?php endif; ?>

                <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                    <a href="/admin/bookings/accepted">Zaakceptowane</a>
                <?php endif; ?>

                <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                    <a href="/admin/bookings/rejected">Odrzucone</a>
                <?php endif; ?>

                <?php if (($_SESSION['user']['role'] ?? '') === 'user'): ?>
                    <a href="/my-bookings">Moje rezerwacje</a>
                <?php endif; ?>

                <span class="nav-user">
                    Zalogowany jako:
                    <?= htmlspecialchars($_SESSION['user']['email']) ?>
                </span>

                <a href="/logout">Wyloguj</a>

            <?php else: ?>

                <a href="/login">Logowanie</a>
                <a href="/register">Rejestracja</a>

            <?php endif; ?>
        </nav>

    </div>
</header>

<main class="site-content">