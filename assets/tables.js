document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
<<<<<<< HEAD
    const peopleCount = parseInt(params.get("people")) || 1; 

=======
    const peopleCount = parseInt(params.get("people")) || 1;
>>>>>>> ec3546f9528c051d183b42f88dbc0ba56f4cc4a2
    const tables = [];
    for (let i = 0; i < 5; i++) {
        tables.push({ id: i + 1, size: 10 });
    }
    for (let i = 5; i < 20; i++) {
        tables.push({ id: i + 1, size: 4 });
    }
<<<<<<< HEAD

=======
    
>>>>>>> ec3546f9528c051d183b42f88dbc0ba56f4cc4a2
    let reservedTables = JSON.parse(localStorage.getItem("reservedTables")) || [];
    let selectedTable = null;

    function renderTables() {
        const tableGrid = document.getElementById('table-grid');
        tableGrid.innerHTML = ''; // Clear existing tables

        tables.forEach(table => {
            const tableElement = document.createElement('div');
            tableElement.classList.add('col-md-3', 'col-sm-4', 'col-6', 'table');
            tableElement.dataset.id = table.id;

            if (table.size === 10) {
                tableElement.classList.add('large');  
            }

            tableElement.innerHTML = `Table ${table.id}<br>(${table.size} people)`;

            if (reservedTables.includes(table.id)) {
                tableElement.classList.add('reserved');
                tableElement.innerHTML += '<br>(Reserved)';
                tableElement.style.pointerEvents = 'none';
                tableElement.style.opacity = '0.5';
            } else if (peopleCount > table.size) {
                tableElement.classList.add('disabled');
                tableElement.style.pointerEvents = 'none';
                tableElement.style.opacity = '0.5';
            }

            tableElement.addEventListener('click', () => handleTableSelection(table, tableElement));

            tableGrid.appendChild(tableElement);
        });
    }

    function handleTableSelection(table, tableElement) {
        if (reservedTables.includes(table.id)) {
            alert("This table is already reserved.");
            return;
        }

        document.querySelectorAll(".table.selected").forEach(t => t.classList.remove("selected"));

        tableElement.classList.add("selected");
        selectedTable = table.id;

        document.getElementById("selected-table").value = selectedTable;

        const reserveButton = document.getElementById("reserve-button");
        reserveButton.disabled = false;
        reserveButton.textContent = `Reserve Table ${selectedTable}`;
    }

    document.getElementById("reservation-form").addEventListener("submit", function(event) {
        if (!selectedTable) {
            alert("Please select a table before submitting.");
            event.preventDefault(); 
            return;
        }
    });

    renderTables();
});
