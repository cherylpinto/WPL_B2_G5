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

    function renderTables() {
        const tableGrid = document.getElementById('table-grid');
        tableGrid.innerHTML = ''; 

        tables.forEach(table => {
            const tableElement = document.createElement('div');
            tableElement.classList.add('table', table.status);
            tableElement.dataset.id=table.id;

            if (table.size === 10) {
                tableElement.classList.add('large');  
            }

            tableElement.innerHTML = `Table ${table.id} (${table.size} people)`;

            
            if (peopleCount <= table.size && table.status === 'available') {
                tableElement.classList.add('suggested');
            }

            tableElement.addEventListener('click', () => handleTableSelection(table, tableElement));

            tableGrid.appendChild(tableElement);
        });
    }

    function handleTableSelection(table, tableElement) {
        if(table.status==="reserved"){
            alert("This table is already reserved.");
        }
        document.querySelectorAll(" .table.selected").forEach(t=>t.classList.remove("selected"));

        tableElement.classList.add("selected");
        selectedTable=table.id;
        document.getElementById("selectedTable").value=selectedTable;
    }

    renderTables();


    let selectedTable = null; 


document.querySelectorAll(".table").forEach(table => {
    table.addEventListener("click", function () {
        if (this.classList.contains("reserved")) {
            alert("This table is already reserved.");
            return;
        }

       
        if (selectedTable) {
            selectedTable.classList.remove("selected");
        }

        
        selectedTable = this;
        selectedTable.classList.add("selected");

        
        document.getElementById("selectedTable").value = selectedTable.id;
    });
});


document.getElementById("reservationForm").addEventListener("submit", function(event) {
    if (!selectedTable) {
        alert("Please select a table before submitting.");
        event.preventDefault(); 
        return;
    }

    
    let reservedTables = JSON.parse(localStorage.getItem("reservedTables")) || [];
    reservedTables.push(selectedTable);
    localStorage.setItem("reservedTables", JSON.stringify(reservedTables));

   
});

});
