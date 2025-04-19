<?php
session_start();
// Add an authentication check here if needed for admin

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - View Reserved Tables</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/dynamic_grid.css">
  <style>

    .back-btn {
      color: white;
      background-color: red;
      border: 1px solid red;
      padding: 8px 16px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-left: 20px;
      font-size: 16px;
    }
    
    .back-btn:hover {
      background-color: darkred;
      border-color: darkred;
    }

    h2 {
      font-size: 24px;
      font-weight: bold;
      color: white;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    label {
      font-size: 16px;
      font-weight: normal;
    }

    input[type="date"], input[type="time"] {
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 8px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<a href="admin_dashboard.php" class="back-btn mb-4 mt-4"> < Back to Dashboard</a>
  <div class="container mt-4 text-center">
    <h2>Admin Table Overview</h2>
    <form id="admin-filter-form" class="mb-4">
      <label>Date: <input type="date" name="date" id="admin-date" required></label>
      <label>Time: <input type="time" name="time" id="admin-time" required></label>
      <button type="submit" class="btn btn-primary">View Tables</button>
    </form>

    <div id="table-grid"></div>
  </div>

  <script src="../assets/tables.js"></script>
  <script>
    document.getElementById('admin-filter-form').addEventListener('submit', function (e) {
      e.preventDefault();
      const date = document.getElementById('admin-date').value;
      const time = document.getElementById('admin-time').value;

      const selectedDay = new Date(date).getDay(); // 0 = Sunday, 1 = Monday, etc.

      let minTime, maxTime;

      // Restrict time based on the selected day
      if (selectedDay >= 1 && selectedDay <= 5) {
        // Monday to Friday: 8 AM to 9 PM
        minTime = "08:00";
        maxTime = "21:00";
      } else if (selectedDay === 6) {
        // Saturday: 8 AM to 11 PM
        minTime = "08:00";
        maxTime = "23:00";
      } else if (selectedDay === 0) {
        // Sunday: 12 PM to 12 AM
        minTime = "12:00";
        maxTime = "23:59";
      }

      if (time < minTime || time > maxTime) {
        alert(`Please select a time between ${minTime} and ${maxTime} for the selected day.`);
        return; // Stop form submission if time is out of range
      }


      fetch(`fetch_booked_tables.php?date=${date}&time=${time}`)
        .then(res => res.json())
        .then(data => {
            
        console.log("Response from server:", data); // <--- add this line
          renderAdminTableGrid(data.tables, data.reservations);
        })
        .catch(err => console.error("Fetch error:", err));
    });
  </script>
</body>
</html>