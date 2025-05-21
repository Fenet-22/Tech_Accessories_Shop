<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Techcessoré - Luxe Tech Store</title>
  <link rel="stylesheet" href="style.css"/>
 
  <style>
    .modal-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(20, 20, 20, 0.41);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(10px);
    
    
  }

  .modal {
    background: #111;
    border-radius: 12px;
    padding: 2rem 2.5rem;
    width: 100%;
    max-width: 400px;
    color: #fff;
    box-shadow: 0 0 15px rgba(255, 0, 150, 0.3);
    font-family: 'Poppins', sans-serif;
  }

  .modal h2 {
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
    font-weight: 600;
    color: #ff66b2;
    text-align: center;
  }

  .input-group {
    margin-bottom: 1rem;
  }

  .input-group input {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    background: transparent;
    border: none;
    border-bottom: 2px solid #ff66b2;
    color: #fff;
    outline: none;
  }

  .submit-btn {
    width: 100%;
    padding: 12px;
    background: #ff66b2;
    border: none;
    color: white;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    margin-top: 1rem;
    border-radius: 8px;
    transition: background 0.3s ease;
  }

  .submit-btn:hover {
    background: #e055a5;
  }

  .signup-link {
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #ccc;
  }

  .signup-link a {
    color: #ff66b2;
    text-decoration: none;
    font-weight: 500;
  }

  #loginMessage {
    margin-top: 0.5rem;
    color: #f55;
    font-size: 0.9rem;
  }
 
.signup-message {
  margin-top: 1rem;
  font-size: 0.9rem;
  color: #ccc;
  text-align: center;
}

.signup-message a {
  color: #ff66b2;
  text-decoration: none;
  font-weight: 500;
}

.signup-message a:hover {
  text-decoration: underline;
}
</style>

  </style>
</head>
<body>

<?php if (!$isLoggedIn): ?>
<div class="modal-bg" id="loginModal">
  <div class="modal">
    <h2>Login</h2>
    <form id="ajaxLoginForm">
      <div class="input-group"><input type="email" name="email" placeholder="Email" required></div>
      <div class="input-group"><input type="password" name="password" placeholder="Password" required></div>
      <button type="submit" class="submit-btn">Login</button>
      <p id="loginMessage" style="color:red;"></p>
      <p class="signup-message">
  Don’t have an account yet?
  <a href="signup.php">Sign up</a>
</p>

    </form>
  </div>
</div>
<script>
  // Blur everything except the modal
  window.onload = () => {
    document.querySelectorAll('body > *:not(#loginModal)').forEach(el => {
      el.classList.add('blurred-bg');
    });
  };

  document.getElementById('ajaxLoginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('ajax-login.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      if (data === 'success') {
        location.reload();
      } else {
        document.getElementById('loginMessage').innerText = data;
      }
    });
  });
</script>
<?php endif; ?>

<header class="top-nav">
  <div class="logo">Techcessoré</div>
  <nav>
    <?php if ($isLoggedIn): ?>
  <span>Welcome <?php if (isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } else { echo "User"; } ?>!</span>
  <a href="logout.php">Logout</a>
<?php else: ?>
  <a href="login.php">Login</a>
  <a href="signup.php">Sign Up</a>
<?php endif; ?>
    
  </nav>
</header>

<section class="hero-scroll-wrapper">
  <div class="hero-section">
    <div class="hero-text">
      <h1>Luxury <br><span>Wireless Headphones</span></h1>
      <p>Immersive sound with premium design. Switch between 3 EQ modes for the ultimate audio experience.</p></br>$149.99</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      

    </div>
    <div class="hero-img">
      <img src="assets/images/headphones.jpg" alt="Luxury Wireless Headphones" />
    </div>
  </div>

  <div class="hero-section alt-hero">
    <div class="hero-text">
      <h1>Wireless Charger <br><span>Reimagined</span></h1>
      <p>Fast, sleek, and cord-free. A charging experience designed to match your premium lifestyle.</p></br>$170.65</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/wireless-charger.jpg" alt="Luxury Wireless Charger" />
    </div>
  </div>

  <div class="hero-section alt-hero">
    <div class="hero-text">
      <h1>Desk Lamp<br><span>Reimagined</span></h1>
      <p>Sleek and smart lighting crafted for productivity and style. Touch controls, adjustable brightness, and a minimalist design make it the perfect companion for luxury workspaces.</p></br>$200</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/desk-lamp.jpg" alt="Luxury Desk Lamp" />
    </div>
  </div>

  <div class="hero-section">
    <div class="hero-text">
      <h1>Luxury <br><span>Bluetooth Speaker</span></h1>
      <p>Crystal-clear sound meets refined design. This compact speaker delivers deep bass and balanced audio, wrapped in a premium finish that looks as good as it sounds.</p></br>$120.00</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/bluetooth-speaker.jpg" alt="Luxury Bluetooth Speaker" />
    </div>
  </div>

  <div class="hero-section">
    <div class="hero-text">
      <h1>Luxury <br><span>Laptop Stand</span></h1>
      <p>Ergonomic elevation with a touch of elegance. Crafted from lightweight, durable materials, it enhances posture and cools your device in sophisticated style.</p></br>$130.43</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/laptop-stand.jpg" alt="Luxury Laptop Stand" />
    </div>
  </div>

  <div class="hero-section alt-hero">
    <div class="hero-text">
      <h1>Mouse <br><span>Reimagined</span></h1>
      <p>Precision, comfort, and beauty in every click. Designed for professionals who demand smooth control and a modern aesthetic to match their workspace.</p></br>$50.00</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/mouse.jpg" alt="Luxury Mouse" />
    </div>
  </div>

  <div class="hero-section alt-hero">
    <div class="hero-text">
      <h1>Power Bank <br><span>Reimagined</span></h1>
      <p>Ultra-slim, ultra-powerful. This high-capacity power bank keeps your devices charged on the go, with a premium metallic build that fits your luxury lifestyle.</p></br>$180.00</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/power-bank.jpg" alt="Luxury Power Bank" />
    </div>
  </div>

  <div class="hero-section alt-hero">
    <div class="hero-text">
      <h1>Smartwatch <br><span>Reimagined</span></h1>
      <p>Where innovation meets fashion. Track health, stay connected, and elevate your look with a smartwatch that blends advanced features and timeless design.</p></br>$350.00</br>
      <a href="cart.php" class="hero-button">Shop Now</a>
      
    </div>
    <div class="hero-img">
      <img src="assets/images/smartwatch.jpg" alt="Luxury Smartwatch" />
    </div>
  </div>
</section>

</body>
</html>
