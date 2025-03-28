document.addEventListener('DOMContentLoaded', () => {
    // Define the tables, some are large (10 people), and others are small (4 people)
    const tables = [];
    for (let i = 0; i < 5; i++) {  // 5 tables for 10 people
        tables.push({ id: i + 1, status: 'available', size: 10 });
    }
    for (let i = 5; i < 20; i++) {  // 15 tables for 4 people
        tables.push({ id: i + 1, status: 'available', size: 4 });
    }

    // Function to render tables dynamically
    function renderTables() {
        const tableGrid = document.querySelector('.table-grid');
        tableGrid.innerHTML = ''; // Clear any existing tables

        tables.forEach(table => {
            const tableElement = document.createElement('div');
            tableElement.classList.add('table');
            tableElement.classList.add(table.status); // Apply the status class
            if (table.size === 10) {
                tableElement.classList.add('large');  // Larger tables for 10 people
            }

            tableElement.innerHTML = `Table ${table.id} (${table.size} people)`;

            // Add event listener for selection
            tableElement.addEventListener('click', () => handleTableSelection(table));

            tableGrid.appendChild(tableElement);
        });
    }

    // Handle table selection (change color and enable the reservation form)
    function handleTableSelection(table) {
        const groupSize = parseInt(document.getElementById('group-size').value);
        if (table.status === 'available' && groupSize <= table.size) {
            const selectedTable = document.querySelector('.table.selected');
            if (selectedTable) {
                selectedTable.classList.remove('selected');
            }

            // Mark the clicked table as selected
            const tableElement = document.querySelector(`.table:nth-child(${table.id})`);
            tableElement.classList.add('selected');

            // Enable the reservation button
            document.getElementById('submit-btn').disabled = false;
        }
    }

    // Handle form submission (store reservation)
    document.getElementById('reservation-form').addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const groupSize = document.getElementById('group-size').value;
        const selectedTable = document.querySelector('.table.selected');

        if (selectedTable) {
            const tableId = selectedTable.innerHTML.replace('Table ', '').split(' ')[0];
            alert(`Reservation Confirmed for Table ${tableId}\nName: ${name}\nPhone: ${phone}\nGroup Size: ${groupSize}`);
            // Reset the form
            document.getElementById('reservation-form').reset();
            document.getElementById('submit-btn').disabled = true;
            // Mark the table as reserved and update the status
            tables[tableId - 1].status = 'reserved';
            renderTables(); // Re-render tables to update the grid
        }
    });

    renderTables(); // Initially render the tables
});
