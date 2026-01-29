<h2>Rejestracja</h2>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" placeholder="Imię i nazwisko" required>
    <input type="email" placeholder="E-mail" required>
    <input type="password" placeholder="Hasło" required>
    <button type="submit">Zarejestruj</button>
</form>