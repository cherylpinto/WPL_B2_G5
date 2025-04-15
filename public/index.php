<?php
session_start();
$isAuthenticated = isset($_SESSION['user_id']); 

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$initial = !empty($firstName) ? strtoupper($firstName[0]) : ''; 
if (!$isAuthenticated) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurelia's Restaurant</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/menu.css">
    <link rel="stylesheet" href="../assets/chefsection.css">
    <link rel="stylesheet" href="../assets/feedback.css">
    <link rel="stylesheet" href="../assets/reservation.css">
    <link rel="stylesheet" href="../assets/footer.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Aurelia's Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="#menu-section">Menu</a></li>
                <li><a href="#chefs-section">Chefs</a></li>
                <li><a href="#feedback">Feedback</a></li>
                <li><a href="#reservation">Reserve a Table</a></li>
                <li><a href="../public/reservation/fetch_reservations.php">My reservations</a></li>
                <li><a href="#footer">Contact Us</a></li>
            </ul>
        </nav>

        <?php if ($isAuthenticated): ?>
            <div class="user-info" style="display: flex; flex-direction: row; align-items: center; gap: 20px;">
                <div class="user-circle" style=" width: 40px; height: 40px; background-color: #666; color: white; font-weight: bold; font-size: 20px; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-transform: uppercase;"><?php echo htmlspecialchars($initial); ?></div>
                <a href="logout.php" class="btn-login">Logout</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-login">Sign Up/Login</a>
        <?php endif; ?>


    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>We provide the <br> best food for you</h1>
            <p>Exquisite cuisine, fresh ingredients, inviting ambiance, and unforgettable flavors—crafted with passion for every occasion.</p>
            <div class="buttons">
                <a href="#menu-section" class="btn-menu">Menu</a>
                <a href="#reservation" class="btn-book">Book a table</a>
            </div>
            <div class="social-icons">
                <div class="facebook">
                    <a href="#"><img src="../images/facebook.png" alt="Facebook"></a>
                </div>
                <div class="instagram">
                    <a href="#"><img src="../images/insta.jpg" alt="Instagram"></a>
                </div>
                <div class="twitter">
                    <a href="#"><img src="../images/twitter.jpg" alt="Twitter"></a>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <img src="../images/restaurant-image.jpg" class="img1" alt="Restaurant Interior">
            <img src="../images/main.png" class="img2" alt="Restaurant Interior">
        </div>
    </section>
    <section id="menu-section" class="menu-section">
        <h2><span>Aurelia’s</span> Classics</h2>
        <p>Discover the timeless flavors of Aurelia’s!<br> Explore Aurelia’s signature dishes, made with the finest ingredients and culinary expertise.</p>

        <div class="menu-grid">
            <div class="menu-item">
                <div class="price-tag">₹500</div>
                <img src="../images/lumpia-bowl.png" alt="Lumpia Bowl">
                <h3>Lumpia Bowl</h3>
                <p>A delicious mix of crispy lumpia rolls served with a tangy dipping sauce and fresh veggies.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹550</div>
                <img src="../images/fish-veggie.png" alt="Fish and Veggie">
                <h3>Fish and Veggie</h3>
                <p>Grilled fish fillet served with sautéed seasonal vegetables and a light lemon butter sauce.
                <p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹600</div>
                <img src="../images/tofu-chili.png" alt="Tofu Chili">
                <h3>Tofu Chili</h3>
                <p>Spicy stir-fried tofu with bell peppers, onions, and a rich chili garlic sauce.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹200</div>
                <img src="../images/sunny-side-up.png" alt="Sunny Side Up">
                <h3>Sunny Side Up</h3>
                <p>A classic breakfast plate with sunny-side-up eggs, toast, and fresh greens.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹325</div>
                <img src="../images/masala-dosa.png" alt="Mini Masala Dosa">

                <h3>Mini Masala Dosa</h3>
                <p>Crispy South Indian dosa stuffed with a flavorful potato masala, served with chutneys.
                <p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹400</div>
                <img src="../images/mini-pizza.png" alt="Mini Pizzas">
                <h3>Mini Pizzas</h3>
                <p>Bite-sized pizzas topped with mozzarella, fresh basil, and a variety of toppings.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹450</div>
                <img src="../images/french-toast.png" alt="French Toast">
                <h3>French Toast</h3>
                <p>Golden brown French toast topped with berries, maple syrup, and a dusting of powdered sugar.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹500</div>
                <img src="../images/pav-bhaji-fondue.png" alt="Pav Bhaji Fondue">
                <h3>Pav Bhaji Fondue</h3>
                <p>A fusion twist on the classic Mumbai dish, with a rich bhaji served as a fondue.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹250</div>
                <img src="../images/rasmalai.png" alt="Rasmalai">
                <h3>Rasmalai</h3>
                <p>Soft and spongy paneer dumplings soaked in saffron-infused sweet milk.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹260</div>
                <img src="../images/creme-brulee.png" alt="Creme Brulee">
                <h3>Creme Brulee</h3>
                <p>A creamy vanilla custard topped with a perfectly caramelized sugar crust.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹345</div>
                <img src="../images/spaghetti.png" alt="Spaghetti">

                <h3>Spaghetti</h3>
                <p>Classic Italian spaghetti tossed in a rich tomato basil sauce with parmesan cheese.</p>
            </div>

            <div class="menu-item">
                <div class="price-tag">₹345</div>
                <img src="../images/cheesecake.png" alt="New York Style Cheesecake">
                <h3>New York Style Cheesecake</h3>
                <p>Creamy and decadent cheesecake with a graham cracker crust and fresh berry topping.</p>
            </div>
        </div>
    </section>
    <section class="chefs-section" id="chefs-section">
        <h2 class="section-title">Our Expert Chefs</h2>
        <div class="chefs-container">
            <div class="chef-card">
                <img src="../images/chef1.png" alt="Chef 1">
                <h2>Chef Isabella Rossi</h2>
                <p>A world-class pastry chef with a passion for creating stunning desserts. Isabella specializes in French patisserie and modern cake decorating techniques</p>
            </div>
            <div class="chef-card">
                <img src="../images/chef2.png" alt="Chef 2">
                <h2>Chef Marco Fernandez</h2>
                <p>A seasoned culinary artist with over 20 years of experience in Mediterranean and fusion cuisine. Marco brings creativity and bold flavors to every dish.</p>
            </div>
            <div class="chef-card">
                <img src="../images/chef3.png" alt="Chef 3">
                <h2>Chef Daniel Laurent</h2>
                <p>A master of classic French cuisine, Daniel has worked in Michelin-starred restaurants and is known for his precise techniques and gourmet presentations.</p>
            </div>
        </div>
    </section>
    <section class="testimonials" id="feedback">
        <h2>Our Happy Customers</h2>
        <button class="slider-btn prev">&#10094;</button>
        <div class="testimonial-slider">
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>Absolutely fantastic experience! The food was delicious, and the service was top-notch. Highly recommend!</p>
                <h4>Ama Ampomah</h4>
                <span>CEO & Founder Inc</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>A delightful dining experience! The flavors were authentic, and the presentation was stunning. Will definitely visit again.</p>
                <h4>Kweku Annan</h4>
                <span>CEO & Founder Inc</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐</div>
                <p>Exceptional food quality and friendly staff. Every dish was a masterpiece! A must-visit for food lovers.</p>
                <h4>Sarah Johnson</h4>
                <span>CTO, Tech Solutions</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐</div>
                <p>Incredible food and great service! A perfect place for a delicious meal</p>
                <h4>John Paterson</h4>
                <span>CEO, Caltech Solutions</span>
            </div>
        </div>
        <button class="slider-btn next">&#10095;</button>
    </section>

    <section class="reservation" id="reservation">
    <div class="reservation-container">
        <div class="reservation-image">
            <img src="../images/reservation.png" alt="Restaurant Interior">
        </div>
        <div class="reservation-form">
            <h2>Reserve a table</h2>
            <form id="reservation-form">
                <input type="hidden" id="selectedTable" name="table_id" value="">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?? ''; ?>">

                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your number" required>

                <label for="email">Email ID</label>
                <input type="email" id="email" name="email" placeholder="Enter your email id" required>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time</label>
                <input type="time" id="time" name="time" required>

                <label for="people">Number of people</label>
                <input type="number" id="people" name="people" placeholder="Number of people" required min="1" max="10">

                <label for="requests">Special Requests</label>
                <textarea id="requests" name="requests" placeholder="Any special requests..."></textarea>

                <button type="submit" class="btn-reserve">Reserve</button>
            </form>

            <script>
                const dateInput = document.getElementById("date");
                const timeInput = document.getElementById("time");
                const form = document.getElementById("reservation-form");

                const now = new Date();
                const todayStr = now.toISOString().split('T')[0];
                const maxDate = new Date();
                maxDate.setDate(now.getDate() + 30);
                const maxDateStr = maxDate.toISOString().split('T')[0];

                dateInput.min = todayStr;
                dateInput.max = maxDateStr;

                let currentMinTime = "00:00";
                let currentMaxTime = "23:59";

                dateInput.addEventListener('change', function () {
                    const selectedDate = new Date(this.value);
                    const selectedDateStr = this.value;
                    const day = selectedDate.getDay();

                    let minTime, maxTime;

                    switch (day) {
                        case 0:
                            minTime = '12:00';
                            maxTime = '23:59';
                            break;
                        case 6:
                            minTime = '08:00';
                            maxTime = '23:00';
                            break;
                        default:
                            minTime = '08:00';
                            maxTime = '21:00';
                    }

                    if (selectedDateStr === todayStr) {
                        const nowHours = now.getHours().toString().padStart(2, '0');
                        const nowMinutes = now.getMinutes().toString().padStart(2, '0');
                        const currentTime = `${nowHours}:${nowMinutes}`;
                        minTime = currentTime > minTime ? currentTime : minTime;
                    }

                    currentMinTime = minTime;
                    currentMaxTime = maxTime;
                });

                form.addEventListener("submit", function (event) {
                    event.preventDefault();

                    const name = document.getElementById("name").value;
                    const phone = document.getElementById("phone").value;
                    const email = document.getElementById("email").value;
                    const date = document.getElementById("date").value;
                    const time = document.getElementById("time").value;
                    const people = document.getElementById("people").value;
                    const requests = document.getElementById("requests").value;

                    if (time < currentMinTime || time > currentMaxTime) {
                        alert(`⛔ Please select a time between ${currentMinTime} and ${currentMaxTime}.`);
                        return;
                    }

                    window.location.href = `book_page.php?name=${encodeURIComponent(name)}&phone=${encodeURIComponent(phone)}&email=${encodeURIComponent(email)}&date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}&people=${encodeURIComponent(people)}&requests=${encodeURIComponent(requests)}`;
                });
            </script>
        </div>
    </div>
</section>


    <footer>
        <div class="footer-container" id="footer">
            <div class="footer-logo">
                <img src="../images/logo.png">
                <p>Savor delicious flavors, relax in a warm ambiance, and create lasting memories. Come dine with us!!</p>
            </div>

            <div class="footer-hours">
                <h3>OPENING HOURS</h3>
                <p>Monday - Friday <br> 8:00 am to 9:00 pm</p>
                <p>Saturday <br> 8:00 am to 11:00 pm</p>
                <p>Sunday <br> 12:00 pm to 12:00 am</p>
            </div>

            <div class="footer-nav">
                <h3>NAVIGATION</h3>
                <ul>
                    <li><a href="index.html">Home Page</a></li>
                    <li><a href="#menu-section">Menu</a></li>
                    <li><a href="#chefs-section">Chefs</a></li>
                    <li><a href="#feedback">Feedback</a></li>
                    <li><a href="#reservation">Reserve a Table</a></li>
                    <li><a href="#footer">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-social">
                <h3>FOLLOW US</h3>
                <div class="social-icons">
                    <a href="#"><img src="../images/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="../images/insta.jpg" alt="Instagram"></a>
                    <a href="#"><img src="../images/twitter.jpg" alt="X"></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 Aurelia's. All Rights Reserved. Designed by Cheryl and Dhiti</p>
            <div class="footer-links">
                <a href="#">Terms of Service</a>
                <a href="#">Privacy Policy</a>
            </div>
        </div>
    </footer>



    <script src="../assets/feedback.js"></script>

</body>

</html>