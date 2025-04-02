<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    echo "Reservation successful for: " . htmlspecialchars($name);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book A Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/dynamic_grid.css"> 
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const params = new URLSearchParams(window.location.search);
            const name = params.get("name");
            const phone = params.get("phone");
            const people = params.get("people");
    
            if (name && phone && people) {
                alert(`Reservation for ${name}, Phone: ${phone}, People: ${people}`);
            }
        });
    </script>
</head>
<body>

    <section class="reservation text-center">
        <h2>Book Your Table</h2>
        <p>Select a table:</p>

        <div class="container mt-4">
            <div class="row g-3 justify-content-center" id="table-grid">

            </div>
        </div>

      
        <div class="reservation-form mt-4">
            <form id="reservation-form" method="POST" action="fetch_reservations.php">
                <input type="hidden" id="selected-table" name="table_id"> 
                <button type="submit" class="reserve-btn">Reserve</button>
            </form>
            
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/tables.js"></script>
</body>
</html>