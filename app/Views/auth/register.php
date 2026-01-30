
<section class="auth">
    <div class="container auth-container">

        <h1>Rejestracja</h1>

        <?php if (!empty($error)): ?>
            <p class="auth-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p style="color:red"><?= $error ?></p>
        <?php endif; ?>

        <form method="post" class="auth-form" action="/register">

            <div class="form-group">
                <label for="name">Imię i nazwisko</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Hasło</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn-primary full-width">
                Zarejestruj się
            </button>

        </form>

    </div>
</section>