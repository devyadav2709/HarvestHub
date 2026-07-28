<div align="center">

# Harvest Hub - A Direct Trade Marketplace

### A Full Stack Web Application for Agricultural Trading

<p>
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white">
  <img src="https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white">
</p>

<p>
A web-based agricultural trading platform that connects farmers directly with consumers through a transparent, bidding-based marketplace — eliminating middlemen and helping farmers realize fair prices for their produce.
</p>

</div>

---

# 📖 Overview

**Harvest Hub** is a web-based agricultural trading platform specifically designed to empower farmers, streamline supply chains, and significantly reduce post-harvest losses caused by middlemen-driven pricing. Instead of a fixed-price shopping cart, Harvest Hub replaces the traditional model with a live **bidding system**: farmers list their freshly harvested produce, consumers compete for it with real-time bids, and the farmer retains full control to accept the highest — or most suitable — offer.

Developed as a final semester academic project, it runs on a local server environment (`http://localhost/harvest_hub`) and demonstrates full-stack development, relational database design, and a 3-tier system architecture.

---

## ✨ Features

### 👨‍🌾 Farmer Management
* **Crop Listing Engine:** Upload crop type, quantity, base price, description, and product images.
* **Inventory Dashboard:** Real-time view of active, sold, and expired listings.
* **Bid Monitoring:** Live feed of incoming bids with bidder name, amount, and timestamp.
* **Trade Acceptance:** Accept the highest — or most preferred — bid to finalize a sale.
* **Auction Scheduling:** Set a bidding start/end date & time window for each listing.
* **Hold for Higher Offers:** Acknowledge a bid but keep the auction open to seek better offers.
* **Earnings Overview:** Track total farm earnings from all accepted/highest bids.
* **Farm Profile Management:** Maintain farm name, address, contact details, and preferred payment info.
* **Listing Lifecycle Control:** Edit or delete listings before bidding starts; auto-locked once bidding begins.

### 🛒 Consumer Marketplace
* **Search & Filter:** Browse crops by category, price range, or availability.
* **Real-Time Bidding:** Place bids above the current highest price within the active auction window.
* **Purchase History:** Track all winning bids and completed transactions.
* **Feedback:** Rate and review produce after purchase.
* **Product Detail View:** View comprehensive crop info, including farmer details and live bidding status.
* **Outbid Notifications:** Get notified when someone places a higher bid on a listing you're tracking.
* **Profile Management:** Update contact details, address, and password from a personal account page.
* **Contact & Support:** Reach out to the platform via a dedicated contact form for queries or issues.

### 🔐 Secure Authentication
* Role-based access control (RBAC) for Farmers, Consumers, and Admins.
* Secure password hashing and session management.
* CSRF-protected forms.
* Separate registration flows for Farmers and Consumers with role-specific onboarding.
* Automatic role-based redirection to the correct dashboard after login.
* Password reset / account recovery flow.

### 📊 Admin & Analytics
* Central admin panel to manage users, products, and platform-wide records.
* Chart.js-powered dashboard visualizing KPIs — revenue, user roles, top-selling products.
* Centralized feedback repository for quality monitoring.
* **User Verification:** Tools to verify farmer credentials and help prevent fraudulent listings.
* **Dispute Resolution:** Handle disagreements between buyers and sellers over quality or payment.
* **Market Analytics:** Reports on trending crops, average price points, and platform growth.
* **Admin Credential Utility:** Dedicated tool for managing/resetting administrator accounts.

### 🌦️ Additional Modules
* Automated bid validation (rejects bids below base price / current highest bid).
* Auction lifecycle control — listings auto-lock once bidding closes or a bid is accepted.
* Weather advisory integration (OpenWeatherMap) for real-time forecasts.
* Crop price information, government subsidy details, and farming equipment resources.
* Responsive, mobile-first design.
* Notification system for outbid alerts and auction closure updates.
* Privacy Policy and Terms of Service pages for platform transparency.
* About Us page detailing the platform's mission and story.

> **Note:** Due to the legal/technical compliance required for real banking APIs, the platform simulates the payment step rather than processing live monetary transfers — the actual settlement (Cash/UPI) happens offline between the two parties.

---

## 🛠 Tech Stack

| Technology | Role in Project |
|---|---|
| **PHP 8.x** | Server-side business logic — bid evaluation, sessions, auction rules |
| **MySQL / MariaDB** | Stores user profiles, product listings, and bid history |
| **HTML5 / CSS3** | Structure and styling |
| **Bootstrap 5** | Responsive, mobile-first UI |
| **JavaScript** | Client-side validation and dynamic UI updates (e.g. bid confirmations) |
| **Chart.js** | Admin & farmer dashboard analytics |
| **OpenWeatherMap API** | Live weather forecasts for farmers |

**Architecture:** 3-tier (Presentation → Application/Business Logic → Data), separating the crop-browsing frontend, PHP business logic, and MySQL data layer.

---

## 📂 Project Structure

```text
HarvestHub/
├── css/
│   └── style.css
├── images/                     # Uploaded crop photos & UI assets
├── php/
│   └── db.php                  # MySQL connection, session bootstrap, CSRF helpers
├── sql/
│   └── harwest_hub.sql         # Database schema & seed data
│
├── index.php                   # Landing page — active auctions, search, successful bids
├── login.php / register.php / logout.php / reset.php
│                                # Authentication — role-based redirect (farmer/consumer)
├── navbar.php / footer.php     # Shared layout partials
│
├── add_product.php             # Farmer: create crop listing
├── farmer_dashboard.php        # Farmer: profits, pending bids, bid history charts
├── place_bid.php               # Consumer: enter per-kg bid rate
├── wait_bid.php                # Farmer: hold bid, keep auction open for higher offers
├── accept_bid.php              # Farmer: finalize auction on accepted bid
├── payment.php                 # Winning bidder checkout flow
├── my_purchases.php            # Consumer: purchase history
├── feedback.php / all_feedback.php
│                                # Consumer reviews & centralized feedback log
│
├── admin_panel.php             # Admin: manage users, products, records
├── admin_dashboard.php         # Admin: Chart.js KPI visualizations
├── fix_admin.php               # Admin credential utility
│
├── weather-api.php             # OpenWeatherMap proxy endpoint
├── weather-forecast.php        # Weather forecast UI
├── crop-prices.php             # Crop price information
├── farming-equipment.php       # Farming equipment information
├── government-subsidy.php      # Government subsidy information
│
├── contact.php / about.php / privacy-policy.php / term-service.php
└── README.md
```

---

## 📸 Screenshots

### Loading Animation
![Loading Animation](https://github.com/user-attachments/assets/c74bb012-cb38-4b2c-a94e-2eccfdd1e548)

### Home Page
![Home Page](https://github.com/user-attachments/assets/13b3fa19-5040-45c0-943c-048b0d8b8eff)

*(More screenshots — farmer dashboard, bidding flow, payment — coming soon.)*

---

## ⚙ Installation & Setup Guide

### ✅ Prerequisites

Make sure you have the following installed before you begin:

| Requirement | Version | Notes |
|---|---|---|
| [XAMPP](https://www.apachefriends.org/download.html) (or WAMP/MAMP) | PHP 8.x bundle | Provides Apache, MySQL/MariaDB & PHP together |
| PHP | 8.0+ | `mysqli`, `curl`, `gd`/`fileinfo` extensions enabled (default in XAMPP) |
| MySQL / MariaDB | 8.0 / 10.4+ | Bundled with XAMPP |
| Git | Latest | Only needed if cloning via command line |
| A code editor | — | VS Code recommended |
| Web Browser | Latest | Chrome, Firefox, or Edge |

---

### 1️⃣ Get the Project

**Option A — Clone with Git:**
```bash
git clone https://github.com/yourusername/HarvestHub.git
```

**Option B — Download ZIP:**
Download the repository as a ZIP from GitHub and extract it.

---

### 2️⃣ Move the Project into the Server Root

Copy (or extract) the project folder into your XAMPP `htdocs` directory:

```
# Windows
C:\xampp\htdocs\HarvestHub

# macOS
/Applications/XAMPP/htdocs/HarvestHub

# Linux
/opt/lampp/htdocs/HarvestHub
```

---

### 3️⃣ Start the Server

Open the **XAMPP Control Panel** and start:
- ✅ Apache
- ✅ MySQL

Confirm both show a green "Running" status.

---

### 4️⃣ Create the Database

1. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin) in your browser.
2. Click **New**, and create a database named `harwest_hub` (or a name of your choice) with collation `utf8mb4_general_ci`.
3. Select the new database, go to the **Import** tab.
4. Choose the SQL file from the project's `sql/` folder (e.g. `sql/harwest_hub.sql`) and click **Go**.

**Or import via command line:**
```bash
mysql -u root -p harwest_hub < sql/harwest_hub.sql
```

This creates and seeds all required tables: `admin`, `users`, `products`, `bids`, `purchases`, `feedbacks`, `contact_messages`, `notifications`.

---

### 5️⃣ Configure the Database Connection

Open `php/db.php` and update the credentials to match your local setup:

```php
$servername = "localhost";
$username   = "root";
$password   = "";        // default is blank on XAMPP
$dbname     = "harwest_hub";
```

> If you changed the database name in Step 4, make sure `$dbname` matches it exactly.

---

### 6️⃣ Configure the Weather API Key

`weather-api.php` ships with a shared demo OpenWeatherMap key for local testing:

```php
$API_KEY = 'b6907d289e10d714a6e88b30761fae22'; // demo key
```

For anything beyond local testing, get your own free key from [openweathermap.org/api](https://openweathermap.org/api) and replace it here.

---

### 7️⃣ Set Folder Permissions (image uploads)

Make sure the `images/` folder (and any `uploads/` folders) are writable by the server, so farmers can upload product photos:

```bash
# macOS/Linux
chmod -R 755 images/

# Windows: right-click the folder → Properties → Security → ensure Write access
```

---

### 8️⃣ Run the Project

Open your browser and go to:

```
http://localhost/HarvestHub/
```

You should see the Harvest Hub home page with active auctions.

---

### 9️⃣ Log In

- **Admin login:** seeded in the `admin` table inside `sql/harwest_hub.sql` — open the table in phpMyAdmin to find the email, then change the password immediately after first login.
- **Farmer / Consumer:** register a new account from the site's **Register** page.

---

### 🛠 Troubleshooting

| Issue | Likely Fix |
|---|---|
| "Connection failed" error | Check `php/db.php` credentials and confirm MySQL is running |
| Blank page / 500 error | Enable PHP error display, or check Apache's `error.log` in `xampp/apache/logs/` |
| Images not uploading | Verify folder permissions on `images/` (Step 7) |
| Weather forecast not loading | Confirm your OpenWeatherMap key is valid and not rate-limited |
| Port 80/3306 already in use | Change Apache/MySQL ports in XAMPP config, or stop the conflicting service (e.g. Skype, another MySQL instance) |

---

## 💻 Main Modules

| Module | Description |
|---|---|
| User Authentication & Profile | Registration, login, role-based redirection, profile/bank detail management |
| Farmer Management | Crop listing engine, inventory dashboard, bid monitoring |
| Bidding & Auction | Real-time bidding, auction timer logic, outbid notifications |
| Consumer Marketplace | Search & filter, product detail view, purchase history |
| Administration & Reporting | User verification, dispute resolution, market analytics |

---

## 📊 Database

Built on **MySQL**, with a data dictionary covering:

| Table | Purpose |
|---|---|
| `admin` | Admin login credentials |
| `users` | Farmer and consumer accounts, login credentials & profile info |
| `products` | Crop listings — category, base price, current bid price, quantity, image path |
| `bids` | All bids placed against a product, with amount and timestamp |
| `purchases` | Completed purchases |
| `feedbacks` | User feedback / product reviews |
| `contact_messages` | Contact form submissions |
| `notifications` | User notifications (outbid alerts, auction closed, etc.) |

---

## 🔒 Security Features

- Role-based access control (Farmer / Consumer / Admin)
- Secure password hashing
- CSRF-protected forms and session management
- Server-side bid validation (rejects bids below base price / current highest)
- Auction lifecycle locking (no edits once bidding starts)
- File upload validation for product images

---

## 🧪 Testing

The platform was validated using **Unit Testing (white box & black box)** across the SDLC, with documented test cases including:

- Farmer registration & consumer login functionality
- Adding a new crop from the farmer dashboard
- Bid validation (rejecting below-base-price bids)
- Bid acceptance and auction closure logic

---

## 🚀 Future Enhancements

- 📱 Native mobile app (Flutter / React Native) with push notifications & camera crop uploads
- 💳 Real payment gateway integration (Razorpay / Stripe / UPI) with escrow holding
- 🌐 Multi-lingual support (Gujarati, Hindi) & voice-to-text search
- 🚚 Third-party logistics integration for automated delivery booking
- 🤖 AI/ML-based price prediction and visual crop quality grading
- ⛅ Smart weather alerts to guide early harvesting
- 🤝 B2B subscription contracts for recurring bulk supply
- ⛓️ Blockchain-based supply chain transparency (origin, quality, transaction record)
- 🛰️ Drone services directory for field mapping & crop health assessment

---

## 🖥️ System Requirements

**Server (Production):** Apache 2.4+/Nginx, PHP 8.x, MySQL 8.0/MariaDB, SSL certificate for secure bidding transactions.

**Development:** VS Code, XAMPP/WAMP, phpMyAdmin or MySQL Workbench.

**Client:** Any modern browser (Chrome, Firefox, Edge, Safari) on desktop or mobile.

---

## 🤝 Contributing

Contributions are welcome.

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to GitHub
5. Open a Pull Request

---

## 👨‍💻 Author

**Dev Yadav**

📧 Email: [ydevm27@gmail.com](mailto:ydevm27@gmail.com)

🔗 LinkedIn: https://linkedin.com/in/dev-yadav-05471a31b

🐙 GitHub: https://github.com/devyadav2709

---

## ⭐ Support

If you found this project useful,

⭐ Star this repository

🍴 Fork it

📢 Share it with others

---

<div align="center">

Made with ❤️ using PHP, MySQL, HTML, CSS, JavaScript & Bootstrap

</div>
