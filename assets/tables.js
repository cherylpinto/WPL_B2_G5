document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const peopleCount = parseInt(params.get("people")) || 1;

    const tables = [];
    for (let i = 0; i < 5; i++) {
        tables.push({ id: i + 1, status: 'available', size: 10 });
    }
    for (let i = 5; i < 20; i++) {
        tables.push({ id: i + 1, status: 'available', size: 4 });
    }

    // Load reserved tables from localStorage (or use an empty array if none exist)
    const reservedTables = JSON.parse(localStorage.getItem("reservedTables")) || [];

    // Update table statuses based on reserved data
    tables.forEach(table => {
        if (reservedTables.some(reserved => reserved.id === table.id)) {
            table.status = 'reserved';
        }
    });

    function renderTables() {
        const tableGrid = document.getElementById('table-grid');
        tableGrid.innerHTML = ''; // Clear existing tables

        tables.forEach(table => {
            const tableElement = document.createElement('div');
            tableElement.classList.add('table', table.status);
            tableElement.dataset.id = table.id;

            if (table.size === 10) {
                tableElement.classList.add('large');  
            }

            tableElement.innerHTML = `Table ${table.id} (${table.size} people)`;

            // Disable tables with capacity less than the number of people
            if (peopleCount > table.size) {
                tableElement.classList.add('disabled');
                tableElement.style.pointerEvents = 'none'; // Disable clicking
            }

            tableElement.addEventListener('click', () => handleTableSelection(table, tableElement));

            tableGrid.appendChild(tableElement);
        });
    }

    function handleTableSelection(table, tableElement) {
        if (table.status === "reserved") {
            alert("This table is already reserved.");
            return;
        }

        if (table.size < peopleCount) {
            alert("This table is too small for your group.");
            return;
        }

        // Remove selection from previously selected table
        document.querySelectorAll(".table.selected").forEach(t => t.classList.remove("selected"));

        // Select the new table
        tableElement.classList.add("selected");
        selectedTable = table;  // Store the table object
        document.getElementById("selectedTable").value = selectedTable.id;
    }

    renderTables();

    let selectedTable = null;

    // Handle reservation form submission
    document.getElementById("reservationForm").addEventListener("submit", function (event) {
        if (!selectedTable) {
            alert("Please select a table before submitting.");
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Save the reservation in localStorage
        let reservedTables = JSON.parse(localStorage.getItem("reservedTables")) || [];

        // Mark this table as reserved and save it
        selectedTable.status = 'reserved';
        reservedTables.push({ id: selectedTable.id, size: selectedTable.size });
        localStorage.setItem("reservedTables", JSON.stringify(reservedTables));

        alert("Table reserved successfully!");
    });
});
