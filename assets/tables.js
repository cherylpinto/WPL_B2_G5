let selectedTable = null;
let reservedTables = JSON.parse(localStorage.getItem('reservedTables')) || [];

/**
 * Renders the table grid on the page
 * @param {Array} tables - Array of table objects fetched from the backend
 */
function renderTables(tables) {
    const grid = document.getElementById('table-grid');
    grid.innerHTML = ''; 

    const peopleCount = parseInt(document.getElementById('form-people').value, 10);
    tables.forEach(table => {
        const tableElement = document.createElement('div');
        const capacity = parseInt(table.capacity, 10);
        let sizeClass = 'small';

        if (capacity === 10) {
            sizeClass = 'xlarge';
        } else if (capacity === 6) {
            sizeClass = 'large';
        } else if (capacity === 4) {
            sizeClass = 'medium';
        } else if (capacity === 2) {
            sizeClass = 'small';
        }
        console.log(`Rendering Table ${table.table_id} (Capacity: ${capacity}) → Class: ${sizeClass}`);

        tableElement.className = `table ${sizeClass}`;
        tableElement.textContent = `Table ${table.table_id} (${capacity})`;
        tableElement.dataset.tableId = table.table_id;
        tableElement.dataset.tableSize = capacity;

        if (table.status === 'reserved') {
            tableElement.classList.add('reserved');
        } else if (capacity < peopleCount) {
            tableElement.classList.add('disabled');
        } else {
            tableElement.classList.add('available');
            tableElement.addEventListener('click', handleTableSelection);
        }

        grid.appendChild(tableElement);
    });
}

/**
 * Handles the selection of a table by the user
 * @param {Event} event - Click event on a table element
 */
function handleTableSelection(event) {
    const clickedTable = event.currentTarget; 
    const tableId = clickedTable.dataset.tableId;
    const tableSize = clickedTable.dataset.tableSize;
    const previousSelected = document.querySelector('.table.selected');
    if (previousSelected) {
        previousSelected.classList.remove('selected');
    }
    clickedTable.classList.add('selected');
    selectedTable = tableId; 
    document.getElementById('selected-table').value = tableId;
    console.log(`Selected Table ID: ${tableId}, Size: ${tableSize}`);
}

/**
 * Fetch available tables from the server based on date and time
 * @param {number} peopleCount - Number of people entered by the user
 * @param {string} date - Selected reservation date
 * @param {string} time - Selected reservation time
 */
function fetchTables(peopleCount, date, time) {
    fetch(`./reservation/fetch_table.php?date=${date}&time=${time}`)
        .then(response => response.json())
        .then(data => {
            console.log("Fetched table data:", data);
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }
            renderTables(data);
        })
        .catch(error => console.error('Fetch error:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    const peopleInput = document.getElementById('form-people');
    const dateInput = document.getElementById('form-date')?.value;
    const timeInput = document.getElementById('form-time')?.value;

    if (peopleInput && peopleInput.value && dateInput && timeInput) {
        console.log("Calling fetchTables with:", peopleInput.value, dateInput, timeInput);
        fetchTables(peopleInput.value, dateInput, timeInput);
    } else {
        console.warn("Missing date/time/people info.");
    }
});
