<?php
session_start();

// Handle removal of items from the cart
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_to_remove = $_GET['id'];
    unset($_SESSION["shopping_cart"][$id_to_remove]);
    header("Location: details.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* General Styles */
        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        h3.title2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .table-responsive {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover td {
            background-color: #f9f9f9;
        }

        .text-danger {
            color: red;
            cursor: pointer;
        }

        /* Button Styles */
        .cart-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .cart-buttons button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            color: white;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .cart-buttons .continue-shopping {
            background-color: #4CAF50; /* Green */
        }

        .cart-buttons .continue-shopping:hover {
            background-color: #45a049; /* Darker green */
        }

        .cart-buttons .buy-now {
            background-color: #FF0000; /* Red */
        }

        .cart-buttons .buy-now:hover {
            background-color: #cc0000; /* Darker red */
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 10px;
            }

            h3.title2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div style="clear: both"></div>
<h3 class="title2">Shopping Cart Details</h3>
<div class="table-responsive">
<table class="table table-bordered">
    <tr>
        <th width="30%">Product Description</th>
        <th width="10%">Quantity</th>
        <th width="13%">Price Details</th>
        <th width="10%">Total Price</th>
        <th width="17%">Remove Item</th>
    </tr>
    <?php
    if (!empty($_SESSION["shopping_cart"])) {
        $total = 0;
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($value["name"]); ?></td>
                <td><?php echo htmlspecialchars($value["quantity"]); ?></td>
                <td><?php echo (strpos($value["price"], '$') === false ? '$' : '') . htmlspecialchars($value["price"]); ?></td> <!-- Modified this line -->
                <td><?php echo '$' . number_format(intval($value["quantity"]) * floatval(str_replace('$', '', $value["price"])), 2); ?></td>
                <td><a href="details.php?action=delete&id=<?php echo $key; ?>" class="text-danger">Remove Item</a></td>
            </tr>
            <?php
            $total += intval($value["quantity"]) * floatval(str_replace('$', '', $value["price"]));
        }
        ?>
        <tr>
            <td colspan="3" align="right"><strong>Total</strong></td>
            <td align="right"><?php echo '$' . number_format($total, 2); ?></td>
            <td></td>
        </tr>
        <?php
    } else {
        echo '<tr><td colspan="5" align="center">Your cart is empty!</td></tr>';
    }
    ?>
</table>

</div>

<div class="cart-buttons">
    <button class="continue-shopping" onclick="window.location.href='shop.php'">Continue Shopping</button>
    <button class="buy-now" onclick="window.location.href='Checkout.html'">Buy Now</button>
</div>

</body>
</html>
