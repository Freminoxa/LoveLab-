<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3 style="display:flex; align-items:center; gap:10px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Tiko Iko On Logo" style="height:50px; margin-right:0;">
                    Tiko Iko On
                </h3>
                <p>Creating unforgettable party experiences for the next generation.</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/tikoikoon?igsh=NzRrZ2ZiNWcwZ3V1" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://vm.tiktok.com/ZMHWQpWn6vRKS-F0AOP/" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://x.com/tikoikoon?t=BqY3ioCzYJklNcRpRux2jw&s=08" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61581473345918&mibextid=rS40aB7S9Ucbxw6v" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/#events">Events</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="/#contact">Contact</a></li>
                    <li><a href="/#faq">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Info</h4>
                <ul>
                    <li><i class="fas fa-phone"></i> +254 745 825 239</li>
                    <li><i class="fas fa-envelope"></i> tikoikoon@gmail.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Meru, Kenya</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Tiko Iko On. All rights reserved. | Built for GenZ by GenZ #code_spectre</p>
        </div>
    </div>
</footer>
