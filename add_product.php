<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "php/db.php";

// Security Check - only farmers can add products
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit();
}

$current_farmer_id = $_SESSION['user_id'];
$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $base_price = mysqli_real_escape_string($conn, $_POST['base_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Capture and format Bid End time
    // HTML5 datetime-local returns "YYYY-MM-DDTHH:MM". We replace 'T' with a space for SQL.
    $bid_end = mysqli_real_escape_string($conn, str_replace("T", " ", $_POST['bid_end']));

    // Calculate total value
    $total_value = $base_price * $quantity;

    // Handle image upload
    $image_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_types)) {
            $image_name = time() . '_' . uniqid() . '.' . $file_extension;
            $upload_path = "images/" . $image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Image uploaded successfully
            } else {
                $image_name = "default_product.jpg";
            }
        } else {
            $image_name = "default_product.jpg";
        }
    } else {
        $image_name = "default_product.jpg";
    }

    // Insert product into database with total_value AND bid_end
    $sql = "INSERT INTO products (name, description, base_price, quantity, total_value, category, bid_end, image, user_id, farmer_id, status, is_sold, created_at) 
            VALUES ('$name', '$description', '$base_price', '$quantity', '$total_value', '$category', '$bid_end', '$image_name', '$current_farmer_id', '$current_farmer_id', 'active', 0, NOW())";

    if (mysqli_query($conn, $sql)) {
        $success_message = "Product added successfully!";
        // Reset form or redirect
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'farmer_dashboard.php';
                }, 1500);
              </script>";
    } else {
        $error_message = "Error adding product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product | Harvest Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2e7d32;
            --dark: #1b5e20;
            --light: #f4f7f6;
            --text: #333;
            --accent: #fbc02d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .add-product-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .add-product-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .card-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .input-group-text {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            border: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .image-preview {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid #e0e0e0;
            display: none;
            margin-top: 10px;
        }

        .image-upload-label {
            display: block;
            padding: 15px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f9f9f9;
        }

        .image-upload-label:hover {
            border-color: var(--primary);
            background: #f0f9f0;
        }

        .image-upload-label i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.3);
        }

        .btn-back {
            background: #f5f5f5;
            color: var(--text);
            padding: 10px 25px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: #e0e0e0;
            color: var(--text);
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #e8f5e9;
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .alert-danger {
            background: #ffebee;
            color: #d32f2f;
            border-left: 4px solid #d32f2f;
        }

        .total-value-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            /* margin-top: 20px; removed margin top to align with input */
            height: 100%;
            /* Match height of input fields */
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 2px dashed #dee2e6;
            text-align: center;
        }

        .total-value-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .total-value-amount {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
        }

        .total-value-subtext {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .add-product-container {
                margin: 20px auto;
            }

            .card-header {
                padding: 20px;
            }

            .card-body {
                padding: 25px;
            }

            .btn-submit {
                padding: 12px 30px;
            }

            .total-value-amount {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 20px;
            }

            .form-control,
            .form-select {
                padding: 10px 12px;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="add-product-container">
        <a href="farmer_dashboard.php" class="btn-back mb-4">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="add-product-card">
            <div class="card-header">
                <h2><i class="fas fa-plus-circle me-2"></i>Add New Crop</h2>
                <p>Fill in the details below to add your crop to the marketplace</p>
            </div>

            <div class="card-body">
                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" id="addProductForm">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label">Crop Name *</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="e.g., Organic Tomatoes, Fresh Wheat" required>
                            <div class="form-text">Enter the name of your crop</div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" selected disabled>Select Category</option>
                                <option value="vegetables">Vegetables</option>
                                <option value="fruits">Fruits</option>
                                <option value="grains">Grains</option>
                                <option value="dairy">Dairy</option>
                                <option value="poultry">Poultry</option>
                                <option value="spices">Spices</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="base_price" class="form-label">Price per kg (₹) *</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="base_price" name="base_price"
                                    placeholder="e.g., 50" min="1" step="0.01" required>
                            </div>
                            <div class="form-text">Price for 1 kilogram</div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="quantity" class="form-label">Quantity (kg) *</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    placeholder="e.g., 100" min="0.1" step="0.1" required>
                                <span class="input-group-text">kg</span>
                            </div>
                            <div class="form-text">Total available quantity</div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-6 mb-4">
                            <label for="bid_end" class="form-label">Bid End Date & Time *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input type="datetime-local" class="form-control" id="bid_end" name="bid_end" required>
                            </div>
                            <div class="form-text">When will the bidding close?</div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="total-value-container">
                                <div class="total-value-label">Estimated Total Value</div>
                                <div class="total-value-amount" id="totalValueDisplay">₹0.00</div>
                                <div class="total-value-subtext">Price × Quantity</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description"
                            placeholder="Describe your crop (quality, farming method, harvest date, etc.)" rows="4"
                            required></textarea>
                        <div class="form-text">Detailed description helps attract better bids</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Crop Image *</label>
                        <label for="image" class="image-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span id="imageLabelText">Click to upload image</span>
                            <span class="form-text d-block mt-2">Recommended: 500x500px, JPG/PNG format</span>
                        </label>
                        <input type="file" class="form-control d-none" id="image" name="image" accept="image/*"
                            onchange="previewImage(event)" required>
                        <img id="imagePreview" class="image-preview" src="" alt="Preview">
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus me-2"></i>Add Crop to Marketplace
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const labelText = document.getElementById('imageLabelText');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    labelText.textContent = 'Image selected: ' + input.files[0].name;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Calculate and display total value in real-time
        function calculateTotalValue() {
            const price = parseFloat(document.getElementById('base_price').value) || 0;
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const totalValue = price * quantity;

            document.getElementById('totalValueDisplay').textContent =
                '₹' + totalValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Add event listeners for real-time calculation
        document.getElementById('base_price').addEventListener('input', calculateTotalValue);
        document.getElementById('quantity').addEventListener('input', calculateTotalValue);

        // Set minimum date for Bid End to Current Date/Time
        document.addEventListener('DOMContentLoaded', function () {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('bid_end').min = now.toISOString().slice(0, 16);
        });

        // Form validation
        document.getElementById('addProductForm').addEventListener('submit', function (e) {
            const price = parseFloat(document.getElementById('base_price').value);
            const quantity = parseFloat(document.getElementById('quantity').value);

            if (price <= 0 || isNaN(price)) {
                alert('Please enter a valid price per kg (greater than 0).');
                e.preventDefault();
                return false;
            }

            if (quantity <= 0 || isNaN(quantity)) {
                alert('Please enter a valid quantity (greater than 0 kg).');
                e.preventDefault();
                return false;
            }

            return true;
        });

        // Initial calculation
        calculateTotalValue();
    </script>

    <?php include "footer.php"; ?>

</body>

</html>