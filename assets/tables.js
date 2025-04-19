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
    const capacityGroups = {};
    tables.forEach(table => {
        const capacity = parseInt(table.capacity, 10);
        if (table.status !== 'reserved' && capacity >= peopleCount) {
            if (!capacityGroups[capacity]) {
                capacityGroups[capacity] = [];
            }
            capacityGroups[capacity].push(table);
        }
    });
    const sortedCapacities = Object.keys(capacityGroups).map(Number).sort((a, b) => a - b);
    const optimalCapacity = sortedCapacities.find(cap => capacityGroups[cap].length > 0) || null;

    tables.forEach(table => {
        const tableElement = document.createElement('div');
        const capacity = parseInt(table.capacity, 10);
        let sizeClass = 'small';
        if (capacity === 10) sizeClass = 'xlarge';
        else if (capacity === 6) sizeClass = 'large';
        else if (capacity === 4) sizeClass = 'medium';

        tableElement.className = `table ${sizeClass}`;
        tableElement.textContent = `Table ${table.table_id} (${capacity})`;
        tableElement.dataset.tableId = table.table_id;
        tableElement.dataset.tableSize = capacity;

        const isReserved = table.status === 'reserved';
        const isTooSmall = capacity < peopleCount;
        const isNotOptimal = capacity !== optimalCapacity;

        if (isReserved) {
            tableElement.classList.add('reserved');
        } else if (isTooSmall || isNotOptimal) {
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

function renderAdminTableGrid(tables, reservationsMap) {
    const grid = document.getElementById('table-grid');
    grid.innerHTML = '';

    tables.forEach(table => {
        const tableElement = document.createElement('div');
        const capacity = parseInt(table.capacity, 10);
        let sizeClass = 'small';
        if (capacity === 10) sizeClass = 'xlarge';
        else if (capacity === 6) sizeClass = 'large';
        else if (capacity === 4) sizeClass = 'medium';

        tableElement.className = `table ${sizeClass}`;
        tableElement.textContent = `Table ${table.table_id} (${capacity})`;

        const booking = reservationsMap[table.table_id];

        if (booking) {
            tableElement.classList.add('reserved');
            tableElement.setAttribute('data-tooltip', `Booked by: ${booking.name} (${booking.email}, ${booking.phone})`);
        } else {
            tableElement.classList.add('available');
        }

        grid.appendChild(tableElement);
    });
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