<h2>Rejestracja</h2>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post" action="/register">
    <input type="text" name="name" placeholder="Imię i nazwisko" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit">Zarejestruj</button>
</form>