<?php
session_start();
include 'database.php';
$products = $conn->query("SELECT * FROM products LIMIT 8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Flower Shop</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="navbar">
  <div class="logo"><img src="assets/logo.png" alt=""></div>
  <div class="nav-menu-container">
    <nav class="nav-menu">
      <a href="index.php">Home</a>
      <a href="#">Shop</a>
      <a href="#">About us</a>
    </nav>
    <div class="cart">
      <a href="cart.php">Cart</a>
      <?php if (isset($_SESSION['user'])): ?>
        | Welcome, <?= $_SESSION['user']['name'] ?> (<a href="logout.php">Logout</a>)
      <?php else: ?>
        | <a href="login.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<section class="banner">
  <div class="banner-text">
    <h1>ALWAYS <span class="highlight">FRESH</span> FLOWERS</h1>
    <p>Indulge your senses with the beauty and fragrance of our fresh flower shop. From roses to orchids, perfect for every occasion.</p>
  </div>
  <div class="banner-image"><img src="assets/hero-flower.png"></div>
</section>

<main>
  <section class="product">
    <h2><span class="highlight">Our</span> Plants</h2>
    <p class="subtitle">Indulge your senses with the beauty and fragrance of our fresh flower shop.</p>
    <div class="product-grid">
      <?php while($p = $products->fetch_assoc()): ?>
      <div class="product-card">
        <img src="<?= $p['image_url'] ?>" alt="<?= $p['name'] ?>">
        <h3><?= $p['name'] ?></h3>
        <p class="price">$<?= $p['price'] ?></p>
        <form method="POST" action="add_to_cart.php">
          <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
          <button type="submit" class="add-cart">ADD TO CART</button>
        </form>
      </div>
      <?php endwhile; ?>
    </div>
  </section>
</main>

<section class="plant-lover">
  <div class="plant-lover-container">
    <div class="plant-lover-img">
      <img src="assets/flower-store.png" alt="">
      <img src="assets/trusted-badge.png" class="badge spin">
    </div>
    <div class="plant-lover-text">
      <h3>Why Plant Lovers Choose Us</h3>
      <ul>
        <li>Freshest blooms daily</li>
        <li>Eco-friendly packaging</li>
        <li>Trusted by thousands of happy customers</li>
      </ul>
    </div>
  </div>
</section>

<section class="deals-section">
  <div class="deals-header">
    <h2>Special <span class="highlight">Deals</span></h2>
    <p>Exclusive seasonal discounts</p>
  </div>
  <div class="deals-grid">
    <div class="deal-box large" style="background-image:url('assets/deal-bloom.png')">
      <div class="deal-info"><h3>Bloom Collection</h3><a href="#">Shop Now</a></div>
    </div>
    <div class="deal-box small" style="background-image:url('assets/deal-ana.png')">
      <div class="deal-info"><h3>Ana Roses</h3><a href="#">Shop Now</a></div>
    </div>
    <div class="deal-box small" style="background-image:url('assets/deal-zabo.png')">
      <div class="deal-info"><h3>Zabo Orchids</h3><a href="#">Shop Now</a></div>
    </div>
  </div>
</section>

<section class="join-section" style="background-image:url('assets/news-letter-bg.png')">
  <div class="join-container">
    <h2>Join the colorful Bunch</h2>
    <form class="join-form" action="subscribe.php" method="POST">
      <input type="email" name="email" placeholder="Write email" required>
      <button type="submit">Subscribe</button>
    </form>
  </div>
</section>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-a">
      <img src="assets/logo.png" class="footer-logo">
      <p>Your trusted flower shop for fresh, beautiful arrangements.</p>
    </div>
    <div class="footer-links">
      <ul><li><a href="#">Shop</a></li><li><a href="#">About Us</a></li></ul>
      <ul><li><a href="#">Contact</a></li><li><a href="#">Terms</a></li></ul>
    </div>
    <div class="footer-social">
      <a href="#"><img src="assets/icon-facebook.png"></a>
      <a href="#"><img src="assets/icon-twitter.png"></a>
      <a href="#"><img src="assets/icon-linkedin.png"></a>
      <a href="#"><img src="assets/icon-youtube.png"></a>
    </div>
  </div>
</footer>
</body>
</html>
