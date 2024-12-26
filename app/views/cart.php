<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/homepage.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <style>
        .cart-wrapper {
            font-family: "Inter", sans-serif;
            background-color: #F9F5EE;
            margin-top: 60px;
            margin-bottom: 186px;
        }

        .cart {
            width: 80%;
            margin: 20px auto;
            background-color: #F9F5EE;
            padding: 20px;
        }

        #title {
            text-align: center;
            color: #5c3d2e;
            margin-bottom: 10px;
        }

        .cart-subtitle {
            text-align: center;
            color: #815C5C;
            margin-bottom: 20px;
        }

        .cart-table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .cart-table, th{
            border: 1px solid black;
            border-collapse: collapse;
        }

        #cart th,
        #cart td {
            padding: 12px;
            text-align: center;
        }

        #cart th {
            background-color: #f4f4f4;
            color: #815C5C;
        }

        #cart tr {
            padding: 12px;
            text-align: center;
        }

        .cart-item-name {
            display: flex;
            align-items: center;
        }

        .cart-item-name img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-quantity button {
            background-color: #ddd;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .cart-item-quantity input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 0 5px;
        }

        .cart-item-remove {
            color: #d9534f;
            font-size: 20px;
            border: none;
            background: none;
            padding-top: 40px;
        }

        .cart-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .continue-shopping-btn {
            background-color: #ddd;
            color: #333;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .continue-shopping-btn:hover {
            background-color: #bbb;
            color: #000;
        }

        .payment-btn {
            background-color: #5c3d2e;
            color: #fff;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .payment-btn:hover {
            background-color: #7d5240;
            transform: scale(1.05);
        }

        #cart td:nth-child(2),
        #cart td:nth-child(4),
        #cart td:nth-child(1) {
            vertical-align: baseline;
        }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 40px;
    }

    .quantity-buttons {
        display: flex;
        padding-right: 30px;
        gap: 2px;
    }

    .quantity-input {
        width: 40px;
        text-align: center;
        padding: 5px;
        border: 1px solid #CCC;
        border-radius: 3px;
    }

    /* Nút bấm */
    .button-wrapper {
        display: flex;
        gap: 80px;
    }

    .btn-increment, .btn-decrement {
        width: 30px;
        height: 30px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, color 0.3s;
    }
    </style>
</head>
    <?php if (isset($_SESSION['flash_message'])): ?>
        <script>
            Swal.fire({
                title: "<?php echo $_SESSION['flash_message']['type'] === 'success' ? 'Thành công!' : 'Thất bại!'; ?>",
                text: "<?php echo $_SESSION['flash_message']['message']; ?>",
                icon: "<?php echo $_SESSION['flash_message']['type']; ?>",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
<body>
    <!-- Header -->
    <header class="header">
    <div class="logo-brand">
        <img src="../public/img/image.png" alt="BookNest Logo" class="logo">
        <h1 class="brand-name"><a href="/booknest_website/">BookNest</a></h1>
    </div>
    <ul class="navigation">
        <li class="nav-link active"><a href="/booknest_website/">Home</a></li>
        <li class="nav-link"><a href="#">Search</a></li>
    </ul>
    <div class="right-header">
        <?php if (isset($_SESSION['is_logged_in'])): ?>
            <div class="iconCart"><i class="fa-solid fa-cart-shopping icon-cart"></i></div>
            <div class="iconUser"><i class="fa-solid fa-user icon-user"></i></div>
            <div class="username"><?php echo $_SESSION['current_user']['username'] ?></div>
            <div class="sign-up"><a href="<?php echo BASE_URL; ?>userController/logout">Log Out</a></div>
        <?php else: ?>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/registerForm">Sign up</a></button>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/loginForm">Log In</a></button>
        <?php endif; ?>
    </div>
    </header>
    <!-- body -->
    <div class="cart-wrapper">
        <div class="cart" id="cart">
            <h1 id="title">Your shopping cart</h1>
            <p class="cart-subtitle">There are 3 items in your cart</p>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_cart as $key => $value) {
                    ?>
                    <tr class="cart-item" data-book-id="<?php echo $value['book_id']; ?>" data-order-id="<?php echo $value['order_id']; ?>">
                        <td class="cart-item-name">
                            <img src="../public/img/<?php echo $value['image_path'] ?>" alt="Book Image">
                            <p><?php echo $value['title'] ?></p>
                        </td>
                        <td class="cart-item-price original-price"><?php echo $value['price'] ?></td>
                        <td class="cart-item-quantity">
                            <button class="btn-decrement">-</button>
                            <span class="quantity-input" id="quantity"><?php echo $value['quantity'] ?></span>
                            <button class="btn-increment">+</button>
                        </td>
                        <td class="cart-item-total or"><?php echo $value['price'] * $value['quantity'] ?></td>
                        <td><a href="<?php echo BASE_URL; ?>cartController/deleteItemFromCart?order_item_id=<?php echo $value['order_item_id'] ?>" class="cart-item-remove">&times;</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div id="cart-total" style="text-align: right; font-weight: bold; margin-top: 20px;"></div>
            <div class="cart-actions">
                <button class="continue-shopping-btn">Continue shopping</button>
                <button class="payment-btn">Payment</button>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="footer">
        <div class="columns">
            <div class="columnone">
                <h4>SERVICES</h4>
                <a class="link" href="#">Terms of Service</a>
                <a class="link" href="#">Privacy Policy</a>
                <a class="link" href="#">Contact</a>
                <a class="link" href="#">Bookstore System</a>
                <a class="link" href="#">Order Tracking</a>
            </div>
            <div class="columntwo">
                <h4>SUPPORT</h4>
                <a class="link" href="#">Order Guide</a>
                <a class="link" href="#">Return and Refund Policy</a>
                <a class="link" href="#">Shipping Policy</a>
                <a class="link" href="#">Payment Methods</a>
                <a class="link" href="#">Customer Policy</a>
            </div>
            <div class="columnthree">
                <h4>ADDRESS</h4>
                <br>
                <p>Phuoc My - Son Tra - Da Nang</p>
                <br>
                <p>booknest_shd@gmail.com</p>
                <br>
                <p>0762 778 450</p>
            </div>
        </div>
        <div class="footer-line"></div>
        <div class="footer-content">
            <div class="footer-left">
                BookNest.com.vn © 2024. All Rights Reserved.
            </div>
            <div class="footer-right">
                Follow us:
                <img src="../public/img/facebook.png" alt="Facebook">
                <img src="../public/img/instagram.png" alt="Instagram">
                <img src="../public/img/twitter.png" alt="Twitter">
                <img src="../public/img/mail.png" alt="Mail">
            </div>
        </div>
    </div>
    <script>
        const cartItems = document.querySelectorAll(".cart-item");

        cartItems.forEach((item) => {
    const decrementButton = item.querySelector(".btn-decrement");
    const incrementButton = item.querySelector(".btn-increment");
    const quantityInput = item.querySelector(".quantity-input");
    const bookId = item.dataset.bookId; // Đảm bảo thêm thuộc tính data-book-id vào HTML
    const orderId = item.dataset.orderId; // Đảm bảo thêm thuộc tính data-order-id vào HTML

    const updateQuantity = (newQuantity) => {
        fetch('/booknest_website/cartController/updateQuantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                book_id: bookId,
                quantity: newQuantity,
            }),
        })
        .then((response) => response.json())  // Chuyển dữ liệu trả về thành JSON
        .then((data) => {
            console.log("Dữ liệu trả về từ server:", data);  // Kiểm tra dữ liệu
            if (data.success) {
                console.log("Cập nhật số lượng thành công!");
            } else {
                // alert("Có lỗi xảy ra khi cập nhật số lượng: " + data.message);
            }
        })
        .catch((error) => {
            console.error("Lỗi:", error);
            // alert("Có lỗi khi cập nhật số lượng.");
        });
    };

    decrementButton.addEventListener("click", () => {
        console.log("Giam");
        let quantity = parseInt(quantityInput.textContent || quantityInput.value);
        if (quantity > 1) {
            quantity--;
            quantityInput.textContent = quantity;
            updateQuantity(quantity); // Gọi hàm cập nhật số lượng
        }
    });

    incrementButton.addEventListener("click", () => {
        console.log("Tang");
        let quantity = parseInt(quantityInput.textContent || quantityInput.value);
        quantity++;
        quantityInput.textContent = quantity;
        updateQuantity(quantity); // Gọi hàm cập nhật số lượng
    });
});

    </script>
</body>
</html>