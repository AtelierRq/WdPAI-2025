document.addEventListener('click', async e => {
    const btn = e.target.closest('[data-action]');
    if (!btn) return;

    const card = btn.closest('.reservation-card');
    const id = card.dataset.id;
    const action = btn.dataset.action;

    if (!id || !action) return;

    //uzycie fetch API
    try {
        const res = await fetch(`/admin/bookings/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'fetch'
            },
            body: JSON.stringify({ id })
        });

        const data = await res.json();

        if (data.success) {
            card.remove();
        }
    } catch (err) {
        console.error(err);
        alert('Błąd podczas aktualizacji rezerwacji');
    }
});