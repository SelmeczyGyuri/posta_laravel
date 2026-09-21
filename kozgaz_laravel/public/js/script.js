document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('table[data-quick-actions]');
    if (!table) return; // page has no quick-action table, do nothing

    const deleteForm = document.getElementById('quick-delete-form');
    const baseRoute = table.dataset.baseRoute;
    const actionButtons = document.querySelectorAll('[data-action]');
    let selectedId = null;

    function setButtonsEnabled(enabled) {
        actionButtons.forEach(function (btn) {
            btn.disabled = !enabled;
        });
    }

    function selectRow(row) {
        table.querySelectorAll('tbody tr').forEach(r => r.classList.remove('row-selected'));
        row.classList.add('row-selected');
        selectedId = row.dataset.id;
        setButtonsEnabled(true);
    }

    // start disabled until something is picked
    setButtonsEnabled(false);

    table.querySelectorAll('tbody tr').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('a, button, form')) return;
            selectRow(row);
        });

        row.addEventListener('dblclick', function (e) {
            if (e.target.closest('a, button, form')) return;
            const id = row.dataset.id;
            if (!id) return;
            window.location.href = `${baseRoute}/${id}/edit`;
        });
    });

    actionButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!selectedId) return;
            const action = btn.dataset.action;

            if (action === 'show') {
                window.location.href = `${baseRoute}/${selectedId}`;
            } else if (action === 'edit') {
                window.location.href = `${baseRoute}/${selectedId}/edit`;
            } else if (action === 'delete') {
                if (confirm('Biztosan törölni szeretnéd?')) {
                    deleteForm.action = `${baseRoute}/${selectedId}`;
                    deleteForm.submit();
                }
            }
        });
    });
});

