// Store the currently selected table's ID
let selectedTable = null;

// Retrieve reserved tables from localStorage or initialize an empty array
let reservedTables = JSON.parse(localStorage.getItem('reservedTables')) || [];

/**
 * Renders the table grid on the page
 * @param {Array} tables - Array of table objects fetched from the backend
 */
function renderTables(tables) {
    const grid = document.getElementById('table-grid');
    grid.innerHTML = ''; // Clear the previous grid

    tables.forEach(table => {
        // Create a new div element for each table
        const tableElement = document.createElement('div');
        tableElement.className = `table table-${table.capacity}`; // Class for styling by capacity
        tableElement.textContent = `Table ${table.table_id} (${table.capacity})`; // Display table info
        tableElement.dataset.tableId = table.table_id; // Set table ID for access later
        tableElement.dataset.tableSize = table.capacity; // Set table size

        // If the table is reserved, mark it accordingly
        if (table.status === 'reserved') {
            tableElement.classList.add('reserved');
        } else {
            // If available, make it selectable and attach event listener
            tableElement.classList.add('available');
            tableElement.addEventListener('click', handleTableSelection);
        }

        // Add the table to the grid
        grid.appendChild(tableElement);
    });
}

/**
 * Handles the selection of a table by the user
 * @param {Event} event - Click event on a table element
 */
function handleTableSelection(event) {
    const clickedTable = event.currentTarget; // Get the clicked table
    const tableId = clickedTable.dataset.tableId;
    const tableSize = clickedTable.dataset.tableSize;

    // Remove 'selected' class from any previously selected table
    const previousSelected = document.querySelector('.table.selected');
    if (previousSelected) {
        previousSelected.classList.remove('selected');
    }

    // Mark this table as selected
    clickedTable.classList.add('selected');
    selectedTable = tableId; // Update global selectedTable variable

    // Update hidden input field with the selected table ID (for form submission)
    document.getElementById('selected-table').value = tableId;

    // Log selected table info for debugging
    console.log(`Selected Table ID: ${tableId}, Size: ${tableSize}`);
}

/**
 * Fetch available tables from the server based on date and time
 * @param {number} peopleCount - Number of people entered by the user
 * @param {string} date - Selected reservation date
 * @param {string} time - Selected reservation time
 */
function fetchTables(peopleCount, date, time) {
    fetch(`reservation/fetch_table.php?date=${date}&time=${time}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }

            // Render all tables (reserved or available)
            renderTables(data);

            // OPTIONAL: Filter by capacity if you only want suitable tables
            // const filteredTables = data.filter(table => table.capacity >= parseInt(peopleCount, 10));
            // renderTables(filteredTables);
        })
        .catch(error => console.error('Fetch error:', error));
}

//Initialize the table grid on page load if form data is already filled
document.addEventListener('DOMContentLoaded', () => {
    const peopleInput = document.getElementById('form-people');
    const dateInput = document.getElementById('form-date')?.value;
    const timeInput = document.getElementById('form-time')?.value;

    // Ensure all necessary inputs are available before fetching tables
    if (peopleInput && peopleInput.value && dateInput && timeInput) {
        fetchTables(peopleInput.value, dateInput, timeInput);
    } else {
        console.warn("Missing date/time/people info.");
    }
});
