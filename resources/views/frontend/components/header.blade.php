
<!-- TOP BAR -->
<div class="top-bar">
  <div class="social">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
    <a href="#"><i class="fab fa-vimeo-v"></i></a>
  </div>
  <div class="contact">
    <i class="fas fa-phone-alt"></i> <span class="call">+1 256 451 868</span>
  </div>
  <div class="right-icons">
    <a href="{{ route('login') }}"><i class="fa-solid fa-user"></i></a>
    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
  </div>
</div>

<!-- NAVBAR -->
<div class="navbar">
  <div class="logo"><span>🛒</span> MARKET</div>
  <div class="hamburger" id="hamburger">
    <i class="fas fa-bars"></i>
  </div>
  <ul class="nav-links" id="navLinks">
    <li><a href="#">Home</a></li>
    <li><a href="#">Features</a></li>
    <li><a href="#">Under $100</a></li>
    <li><a href="#">New Arrivals</a></li>
    <li><a href="#">Deals</a></li>
    <li><a href="#">About Us</a></li>
    <li><a href="#">Contact Us</a></li>
  </ul>
  <div class="nav-right">
    <input type="text" class="search" placeholder="Search...">
  </div>
</div>

<script>
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    hamburger.innerHTML = navLinks.classList.contains('active') ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
});
</script>
