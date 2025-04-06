<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book A Table</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/dynamic_grid.css"> 
</head>
<body>
  <section class="reservation text-center">
    <h2>Book Your Table</h2>
    <p>Select a table:</p>

    <div class="container mt-4">
      <div id="table-grid"></div>
    </div>

    <div class="reservation-form mt-4">
      <form id="reservation-form" method="POST" action="reservation/save_reservations.php">
        <input type="hidden" id="selected-table" name="table_id" value=""> 
        <input type="hidden" id="form-name" name="name">
        <input type="hidden" id="form-phone" name="phone">
        <input type="hidden" id="form-email" name="email">
        <input type="hidden" id="form-date" name="date">
        <input type="hidden" id="form-time" name="time">
        <input type="hidden" id="form-people" name="people">
        <input type="hidden" id="form-requests" name="requests">
        <button type="submit" class="reserve-btn" id="reserve-button">Select a Table to Reserve</button>
      </form>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const params = new URLSearchParams(window.location.search);
      const fields = ["name", "phone", "email", "date", "time", "people", "requests"];
      fields.forEach(field => {
        const value = params.get(field);
        if (value) {
          document.getElementById("form-" + field).value = value;
        }
      });
    });
  </script>


  <script src="../assets/tables.js"></script>
</body>
</html>


