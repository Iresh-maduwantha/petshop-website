<?php
session_start();


if (!isset($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = [];
}


if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $product_id = $_GET['id'];
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

  
    $productsData = [
        1 => ['name' => 'Premium Dog Food', 'price' => '$18'],
        2 => ['name' => 'Catnip Toys', 'price' => '$20'],
        3 => ['name' => 'Organic Cat Treats', 'price' => '$50'],
        4 => ['name' => 'Pet Training Pads', 'price' => '$42'],
        5 => ['name' => 'Eco-Friendly Litter Boxes', 'price' => '$30'],
        6 => ['name' => 'Comfortable Pet Beds', 'price' => '$50'],
        7 => ['name' => 'Stylish Pet Collars', 'price' => '$20'],
        8 => ['name' => 'Natural Chicken Jerky Treats', 'price' => '$50'],
      
   
      
        // Add other products as necessary
    ];

    // Add product to the shopping cart
    if (array_key_exists($product_id, $productsData)) {
        $product = $productsData[$product_id];
        $product["id"] = $product_id;
        $product["quantity"] = $quantity;

        // Check if product is already in the cart
        $found = false;
        foreach ($_SESSION["shopping_cart"] as &$cart_item) {
            if ($cart_item["id"] == $product_id) {
                $cart_item["quantity"] += $quantity; // Update quantity
                $found = true;
                break;
            }
        }

        // If not found, add new item to cart
        if (!$found) {
            $_SESSION["shopping_cart"][] = $product;
        }
    }

    // Redirect to the cart page
    header("Location: details.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industrial Shop</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
  font-family: 'DM Sans', sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  background-color: #f0f4f8;
  color: #333;
}

/* Filters Section */
.filters {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 15px 20px;
  background: #ffffff;
  border-bottom: 1px solid #ddd;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.filters button, .filters select {
  padding: 10px 15px;
  cursor: pointer;
  margin: 5px 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background: #e7f7ff;
  color: #007bff;
  font-weight: bold;
  transition: background-color 0.3s, border-color 0.3s;
}

.filters button:hover, .filters select:hover {
  background-color: #cceeff;
  border-color: #66bbff;
}

/* Products Grid */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 25px;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 10px;
  margin: 0 15px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Product Card */
.product-card {
  background: #ffffff;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  text-align: center;
  position: relative;
  transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.product-card img {
  border-radius: 10px;
  width: 100%;
  height: auto;
  max-height: 180px;
  object-fit: cover;
  margin-bottom: 15px;
}

/* Product Price */
.product-price {
  background-color: #ff5722;
  color: #fff;
  padding: 8px 12px;
  font-size: 1.1rem;
  border-radius: 10px;
  position: absolute;
  top: 15px;
  right: 15px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

/* Quantity Input */
.product-quantity {
  width: 70px;
  padding: 8px;
  font-size: 1rem;
  border-radius: 6px;
  border: 1px solid #ccc;
  margin-top: 15px;
  transition: border-color 0.3s;
}

.product-quantity:focus {
  border-color: #007bff;
  outline: none;
}

/* Add to Cart Button */
.add-to-cart-btn {
  background-color: #4caf50;
  color: #ffffff;
  padding: 10px 16px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  transition: background-color 0.3s, transform 0.2s;
  margin-top: 15px;
  cursor: pointer;
}

.add-to-cart-btn:hover {
  background-color: #388e3c;
  transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
  .products-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
}

@media (max-width: 480px) {
  .products-grid {
    grid-template-columns: 1fr;
  }
}



    </style>
</head>
<body>

<div class="header">
        <a href="#" class="logo">
          <i class="fas fa-paw">&nbsp;</i>Welcome Pet Shop
        </a>
      
        <nav class="navbar">
          <div class="menu-toggle" id="mobile-menu">
            <i class="fas fa-bars"></i> <!-- Hamburger icon for mobile view -->
          </div>
          <div class="nav-menu" id="nav-links">
            <a href="home.html">Home</a>
           
            <a href="services.html">Services</a>
          </div>
          <div class="icons">
            <a href="details.php" class="fas fa-shopping-cart"></a>
            <a href="login.html" class="fas fa-user"></a>
          </div>
        </nav>
      </div>

<br><br>

    <div id="products-section" class="products-grid">
        <div class="product-card">
            <img src="https://i.ibb.co/W3NZntG/3-D-20kg-puppy-chicken-brown-rice-small-min-1000x1603.png" alt="Premium Dog Food">
            <h3>Premium Dog Food </h3>
            <div class="product-price">$18</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="1">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/BfQP5zH/91-RWl-V1-Trg-L.jpg" alt="Catnip Toys">
            <h3>Catnip Toys</h3>
            <div class="product-price">$20</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="2">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/GnFQfPL/2096330-31790.jpg" alt="Organic Cat Treats">
            <h3>Organic Cat Treats</h3>
            <div class="product-price">$50</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="3">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/SRKZYDM/images-2.jpg" alt="Pet Training Pads">
            <h3>Pet Training Pads</h3>
            <div class="product-price">$10</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="4">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/cD6gYYq/images-3.jpg" alt="Eco-Friendly Litter Boxes">
            <h3>Eco-Friendly Litter Boxes</h3>
            <div class="product-price">$30</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="5">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/RzyF9V6/images-4.jpg" alt="Comfortable Pet Beds">
            <h3>Comfortable Pet Beds</h3>
            <div class="product-price">$50</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="6">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/1L5DkYt/images-5.jpg" alt="Stylish Pet Collars">
            <h3>Stylish Pet Collars</h3>
            <div class="product-price">$20</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="7">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="https://i.ibb.co/Lv5Tz1X/images-6.jpg" alt="Natural Chicken Jerky Treats">
            <h3>Natural Chicken Jerky Treats</h3>
            <div class="product-price">$50</div>
            <input type="number" class="product-quantity" value="1" min="1">
            <button class="add-to-cart-btn" data-product-id="8">Add to Cart</button>
        </div>
    </div>

    

    <script>
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                const productId = event.target.getAttribute('data-product-id');
                const quantityInput = event.target.previousElementSibling; 
                const quantity = quantityInput.value; 

               
                window.location.href = `?action=add&id=${productId}&quantity=${quantity}`;
            });
        });
    </script>
    <script src="script.js" defer></script>

</body>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-logo">
                <a href="homepage.html">
                    <img src="img/logo.png" alt="Traveller Logo">
                </a>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="aboutus.html">About Us</a></li>
                <li><a href="contact.html">Contact Us</a></li>
        
                <li><a href="signup.html">Sign Up</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h3>Contact Information</h3>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i> 41/B, Colombo, Sri Lanka</li>
                <li><i class="fas fa-phone-alt"></i> +94 4528 0526 </li>
                <li><i class="fas fa-envelope"></i> support@petshop.com</li>
                
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 Pertshop. All rights reserved.</p>
    </div>
</footer>
</html>