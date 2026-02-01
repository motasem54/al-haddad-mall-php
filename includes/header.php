<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - متجر سوبرماركت فخم</title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> +970 599 123456</span>
                    <span><i class="fas fa-envelope"></i> info@alhaddadmall.com</span>
                </div>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>نابلس، فلسطين</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="<?php echo SITE_URL; ?>">
                        <h1><?php echo SITE_NAME; ?></h1>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="search-bar">
                    <form action="products.php" method="GET">
                        <input type="text" name="search" placeholder="ابحث عن المنتجات..." value="<?php echo isset($_GET['search']) ? escape($_GET['search']) : ''; ?>">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <!-- Header Actions -->
                <div class="header-actions">
                    <a href="#" class="header-icon">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="cart.php" class="header-icon cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo getCartCount(); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container">
            <ul>
                <li><a href="<?php echo SITE_URL; ?>">الرئيسية</a></li>
                <li><a href="<?php echo SITE_URL; ?>/products.php">المنتجات</a></li>
                <li><a href="#">العروض</a></li>
                <li><a href="#">الأقسام</a></li>
                <li><a href="#">عن المتجر</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
        </div>
    </nav>

    <main>