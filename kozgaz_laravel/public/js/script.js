document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('table[data-quick-actions]');
    if (!table) return; // page has no quick-action table, do nothing

    const deleteForm = document.getElementById('quick-delete-form');
    const baseRoute = table.dataset.baseRoute;
    const actionButtons = document.querySelectorAll('[data-action]');
    let currentAction = null;

    function setActiveButton(button) {
        actionButtons.forEach(b => b.classList.remove('active'));
        if (button) button.classList.add('active');
    }

    actionButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (currentAction === btn.dataset.action) {
                // clicking the same button again cancels selection mode
                currentAction = null;
                setActiveButton(null);
                table.classList.remove('selecting');
            } else {
                currentAction = btn.dataset.action;
                setActiveButton(btn);
                table.classList.add('selecting');
            }
        });
    });

    table.querySelectorAll('tbody tr').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (!currentAction) return;

            // let the row's own links/buttons/forms keep working normally
            if (e.target.closest('a, button, form')) return;

            const id = row.dataset.id;
            if (!id) return;

            if (currentAction === 'show') {
                window.location.href = `${baseRoute}/${id}`;
            } else if (currentAction === 'edit') {
                window.location.href = `${baseRoute}/${id}/edit`;
            } else if (currentAction === 'delete') {
                if (confirm('Biztosan törölni szeretnéd?')) {
                    deleteForm.action = `${baseRoute}/${id}`;
                    deleteForm.submit();
                }
            }

            currentAction = null;
            setActiveButton(null);
            table.classList.remove('selecting');
        });
    });
});