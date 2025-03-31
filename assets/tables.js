document.addEventListener('DOMContentLoaded', () => {
    const tableGrid = document.getElementById('table-grid');
    const tables = [];

    
    for (let i = 0; i < 5; i++) {
        tables.push({ id: i + 1, status: 'available', size: 10 });
    }

  
    for (let i = 5; i < 20; i++) {
        tables.push({ id: i + 1, status: 'available', size: 4 });
    }

    // Function to render tables dynamically
    function renderTables() {
        const tableGrid = document.querySelector('#table-grid');
        tableGrid.innerHTML = '';

        tables.forEach(table => {
            const tableElement = document.createElement('div');
            tableElement.classList.add('table', table.status);
            if (table.size === 10) {
                tableElement.classList.add('large');
            }

            tableElement.textContent = `Table ${table.id} (${table.size} people)`;
            tableElement.dataset.id = table.id;

            // Add event listener for selection
            tableElement.addEventListener('click', () => handleTableSelection(table, tableElement));

            tableGrid.appendChild(tableElement);
        });
    }

    // Handle table selection
    function handleTableSelection(table, tableElement) {
        if (table.status === 'available') {
            document.querySelectorAll('.table').forEach(t => t.classList.remove('selected'));
            tableElement.classList.add('selected');
            document.getElementById('submit-btn').disabled = false;
        }
    }

    // Handle form submission
    document.getElementById('reservation-form').addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const groupSize = parseInt(document.getElementById('group-size').value);
        const selectedTable = document.querySelector('.table.selected');

        if (selectedTable) {
            const tableId = parseInt(selectedTable.dataset.id);
            alert(`Reservation Confirmed for Table ${tableId}\nName: ${name}\nPhone: ${phone}\nGroup Size: ${groupSize}`);

            // Mark table as reserved
            tables[tableId - 1].status = 'reserved';
            renderTables();
        }
    });

    renderTables();
});