/* Tiko Iko On - Neon Party Theme */
/* Color Palette:
   Primary: #FF2E63 (Neon Pink)
   Secondary: #08D9D6 (Aqua) 
   Background: #252A34 (Charcoal)
   Text: #FFFFFF (White)
   Accent: #F9ED69 (Bright Yellow)
*/

@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

/* Custom Fonts */
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap');

/* ========================================
   CSS Variables for Consistent Theming
======================================== */
:root {
  --primary-pink: #FF2E63;
  --secondary-aqua: #08D9D6;
  --background-charcoal: #252A34;
  --text-white: #FFFFFF;
  --accent-yellow: #F9ED69;
  --dark-overlay: rgba(37, 42, 52, 0.9);
  --glow-pink: 0 0 20px rgba(255, 46, 99, 0.5);
  --glow-aqua: 0 0 20px rgba(8, 217, 214, 0.5);
  --glow-yellow: 0 0 20px rgba(249, 237, 105, 0.5);
  
  /* Additional semantic colors */
  --success-green: #4CAF50;
  --success-green-hover: #45a049;
  --light-gray: #f8f8f8;
  --border-light: #eee;
  --text-dark: #333;
  --text-muted: #666;
}

/* ========================================
   Global Styles & Reset
======================================== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  color: var(--text-dark);
  min-height: 100vh;
  overflow-x: hidden;
}

body.party-theme {
  background: linear-gradient(135deg, var(--background-charcoal) 0%, #1a1e28 50%, var(--background-charcoal) 100%);
  color: var(--text-white);
}

body.pricing-theme {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: var(--light-gray);
  flex-direction: column;
}

/* ========================================
   Custom Scrollbar
======================================== */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: var(--background-charcoal);
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(var(--primary-pink), var(--secondary-aqua));
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(var(--secondary-aqua), var(--primary-pink));
}

/* ========================================
   Navigation Styles
======================================== */
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
  background: rgba(37, 42, 52, 0.95);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(255, 46, 99, 0.2);
  padding: 0;
  transition: all 0.3s ease;
}

.navbar.scrolled {
  background: rgba(0, 0, 0, 0.9);
  backdrop-filter: blur(20px);
}

.nav-container {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
}

.nav-brand h1 {
  font-family: 'Orbitron', monospace;
  font-size: 1.8rem;
  font-weight: 900;
  background: linear-gradient(45deg, var(--primary-pink), var(--accent-yellow), var(--secondary-aqua));
  background-size: 200% 200%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: gradientShift 3s ease-in-out infinite;
  text-shadow: var(--glow-pink);
}

.brand-tagline {
  font-size: 0.8rem;
  color: var(--secondary-aqua);
  display: block;
  margin-top: -0.2rem;
  font-weight: 300;
}

.nav-links {
  display: flex;
  gap: 2rem;
}

.nav-link {
  color: var(--text-white);
  text-decoration: none;
  font-weight: 500;
  padding: 0.5rem 1rem;
  border-radius: 25px;
  transition: all 0.3s ease;
  position: relative;
}

.nav-link:hover,
.nav-link.active {
  color: var(--primary-pink);
  background: rgba(255, 46, 99, 0.1);
  box-shadow: var(--glow-pink);
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -6px;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, #ec4899, #a855f7);
  transition: width 0.3s ease;
}

.nav-link:hover::after,
.nav-link.active::after {
  width: 100%;
}

.nav-toggle {
  display: none;
  flex-direction: column;
  gap: 4px;
  cursor: pointer;
}

.nav-toggle span {
  width: 25px;
  height: 3px;
  background: var(--primary-pink);
  border-radius: 2px;
  transition: all 0.3s ease;
}

/* ========================================
   Hero Section
======================================== */
.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  padding-top: 80px;
}

.hero-background {
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 20% 80%, rgba(255, 46, 99, 0.3) 0%, transparent 50%),
              radial-gradient(circle at 80% 20%, rgba(8, 217, 214, 0.3) 0%, transparent 50%),
              radial-gradient(circle at 40% 40%, rgba(249, 237, 105, 0.2) 0%, transparent 50%);
}

/* ========================================
   Animated Elements
======================================== */
.neon-circle {
  position: absolute;
  border-radius: 50%;
  filter: blur(1px);
  animation: float 6s ease-in-out infinite;
}

.circle-1 {
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, var(--primary-pink), transparent);
  top: 20%;
  left: 10%;
  animation-delay: 0s;
}

.circle-2 {
  width: 200px;
  height: 200px;
  background: radial-gradient(circle, var(--secondary-aqua), transparent);
  top: 60%;
  right: 20%;
  animation-delay: 2s;
}

.circle-3 {
  width: 150px;
  height: 150px;
  background: radial-gradient(circle, var(--accent-yellow), transparent);
  bottom: 30%;
  left: 60%;
  animation-delay: 4s;
}

/* ========================================
   Pricing Table Styles
======================================== */
.pricing-table {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  background-color: white;
  padding: 20px;
  width: 100%;
  max-width: 1200px;
}

.plan {
  flex: 1;
  padding: 20px;
  text-align: center;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  border: 2px solid transparent;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.plan:hover {
  transform: translateY(-10px) scale(1.02);
  border-color: var(--primary-pink);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.plan.featured {
  background-image: linear-gradient(to bottom, #ff8080, #ff5050);
  color: white;
  transform: scale(1.05);
  z-index: 1;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.plan.featured h3,
.plan.featured p {
  color: white;
}

/* Most Popular Tag */
.most-popular {
  background-color: white;
  color: #ff5050;
  padding: 6px 12px;
  border-radius: 5px;
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 0.9em;
  font-weight: bold;
  text-transform: uppercase;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.check-mark {
  margin-top: 15px;
  display: flex;
  justify-content: center;
}

.check-mark svg {
  width: 24px;
  height: 24px;
  stroke: white;
}

/* Pricing Category Styling */
.pricing-category {
  text-align: center;
  margin: 10px 0;
  padding: 18px;
  border-radius: 8px;
  background-color: #000;
  color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out;
  width: 80%;
}

.pricing-category:hover {
  background-color: #222;
  transform: scale(1.05);
}

.pricing-category h4 {
  margin-bottom: 8px;
  color: #fff;
  font-size: 1.2em;
  font-weight: bold;
}

.pricing-category p {
  font-size: 0.95em;
  color: #ddd;
}

/* Plan type variations */
.ip, .vip, .vvip {
  background-color: #fff;
  border: 1px solid var(--border-light);
}

.ip h3, .vip h3, .vvip h3 {
  color: var(--text-dark);
}

.ip p, .vip p, .vvip p {
  color: var(--text-muted);
}

/* ========================================
   Modal Styles
======================================== */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  border-radius: 8px;
  position: relative;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.modal-header {
  padding: 1rem 2rem;
  border-bottom: 1px solid var(--border-light);
  position: sticky;
  top: 0;
  background: white;
  z-index: 1;
  border-radius: 8px 8px 0 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-body {
  padding: 2rem;
  overflow-y: auto;
  flex: 1;
}

.close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  font-size: 1.5rem;
  cursor: pointer;
  color: var(--text-muted);
  z-index: 2;
  transition: color 0.3s ease;
}

.close:hover {
  color: var(--text-dark);
}

/* ========================================
   Form Styles
======================================== */
.form-group {
  margin: 1.5rem 0;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: var(--text-dark);
}

.form-group input,
.form-input {
  display: block;
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-input {
  background: rgba(255, 255, 255, 0.05);
  color: white;
}

.form-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.form-input:focus {
  border-color: var(--primary-pink);
  outline: none;
  box-shadow: 0 0 0 2px rgba(255, 46, 99, 0.2);
  background: rgba(255, 255, 255, 0.1);
}

.form-group input:focus {
  border-color: var(--primary-pink);
  outline: none;
  box-shadow: 0 0 0 2px rgba(255, 46, 99, 0.1);
}

.members-container {
  margin-top: 1rem;
  border-top: 1px solid var(--border-light);
  padding-top: 1rem;
}

.member {
  padding: 1rem;
  border: 1px solid var(--border-light);
  border-radius: 4px;
  margin-bottom: 1rem;
  background-color: #f9f9f9;
}

/* ========================================
   Button Styles
======================================== */
button[type="submit"],
.confirm-button {
  width: 100%;
  padding: 1rem 2rem;
  background-color: var(--success-green);
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 4px;
  font-size: 1rem;
  font-weight: 600;
  margin-top: 1rem;
  transition: all 0.3s ease;
}

button[type="submit"]:hover,
.confirm-button:hover {
  background-color: var(--success-green-hover);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  font-weight: 600;
  padding: 0.75rem 2rem;
  border-radius: 25px;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  transform: translateY(0);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
  background: rgba(255, 255, 255, 0.1);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.2);
  font-weight: 600;
  padding: 0.75rem 2rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.btn-secondary:hover {
  background: rgba(255, 255, 255, 0.2);
  border-color: rgba(255, 255, 255, 0.4);
}

/* ========================================
   Payment & Pricing Info
======================================== */
.price-info {
  background-color: var(--light-gray);
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
  border: 1px solid var(--border-light);
  font-size: 1.1em;
}

.price-info strong {
  color: var(--text-dark);
}

.payment-container {
  max-width: 800px;
  margin: 2rem auto;
  padding: 2rem;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.payment-details {
  margin-top: 1.5rem;
}

.guidelines {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 6px;
  margin: 1.5rem 0;
  border-left: 4px solid var(--primary-pink);
}

.guidelines ol {
  margin-left: 1.5rem;
  line-height: 1.6;
  color: var(--text-dark);
}

/* ========================================
   Animations & Keyframes
======================================== */
@keyframes gradientShift {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

@keyframes float-delayed {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-15px);
  }
}

@keyframes pulse-glow {
  0%, 100% {
    box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
  }
  50% {
    box-shadow: 0 0 40px rgba(168, 85, 247, 0.8);
  }
}

@keyframes slide-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes bounce-in {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  50% {
    opacity: 1;
    transform: scale(1.05);
  }
  70% {
    transform: scale(0.9);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@keyframes slide-in-right {
  from {
    transform: translateX(100%);
  }
  to {
    transform: translateX(0);
  }
}

/* Animation Classes */
.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 4s ease-in-out infinite;
  animation-delay: 2s;
}

.animate-pulse-glow {
  animation: pulse-glow 2s ease-in-out infinite;
}

.animate-slide-up {
  animation: slide-up 0.6s ease-out;
}

.animate-bounce-in {
  animation: bounce-in 0.8s ease-out;
}

/* ========================================
   Utility Classes
======================================== */
.hover-lift {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.text-gradient {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.text-gradient-pink {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.backdrop-blur-xl {
  backdrop-filter: blur(24px);
}

.border-glow {
  border: 1px solid;
  border-image: linear-gradient(45deg, #a855f7, #ec4899) 1;
}

.loading {
  position: relative;
  color: transparent;
}

.loading::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  margin: -10px 0 0 -10px;
  border: 2px solid transparent;
  border-top: 2px solid #ffffff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

/* ========================================
   Mobile Navigation
======================================== */
.mobile-menu {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease;
  transform: translateX(100%);
  transition: transform 0.3s ease;
}

.mobile-menu.open {
  max-height: 400px;
  transform: translateX(0);
}

.mobile-nav-link {
  display: block;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 500;
  padding: 0.75rem 0;
  transition: all 0.3s ease;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.mobile-nav-link:last-child {
  border-bottom: none;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
  color: white;
}

.mobile-nav-link.active {
  color: #ec4899;
}

/* ========================================
   Social Links & Footer
======================================== */
.social-link {
  width: 2.5rem;
  height: 2.5rem;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  text-decoration: none;
}

.social-link:hover {
  background: linear-gradient(135deg, #ec4899, #a855f7);
  transform: scale(1.1);
}

.footer-link {
  color: rgba(255, 255, 255, 0.6);
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: white;
}

/* ========================================
   Modal Transitions
======================================== */
.modal-enter {
  opacity: 0;
  transform: scale(0.9);
}

.modal-enter-active {
  opacity: 1;
  transform: scale(1);
  transition: all 0.3s ease;
}

.modal-exit {
  opacity: 1;
  transform: scale(1);
}

.modal-exit-active {
  opacity: 0;
  transform: scale(0.9);
  transition: all 0.3s ease;
}

/* Success Toast */
#success-toast {
  animation: slide-in-right 0.5s ease-out;
}

/* ========================================
   Responsive Design
======================================== */
@media (max-width: 768px) {
  .pricing-table {
    flex-direction: column;
    gap: 15px;
  }
  
  .pricing-card,
  .plan {
    margin-bottom: 2rem;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-subtitle {
    font-size: 1.125rem;
  }
  
  .nav-container {
    padding: 1rem;
  }
  
  .nav-links {
    display: none;
  }
  
  .nav-toggle {
    display: flex;
  }
  
  .modal-content {
    width: 95%;
    margin: 1rem;
  }
  
  .modal-body {
    padding: 1rem;
  }
}

@media (max-width: 480px) {
  .pricing-category {
    width: 90%;
    padding: 12px;
  }
  
  .plan {
    padding: 15px;
  }
  
  .nav-brand h1 {
    font-size: 1.5rem;
  }
}

/* ========================================
   Dark Mode Support
======================================== */
@media (prefers-color-scheme: dark) {
  .pricing-card:not(.party-theme *) {
    background: rgba(15, 23, 42, 0.8);
    color: white;
  }
  
  .modal-content:not(.party-theme *) {
    background: #1a202c;
    color: white;
  }
  
  .form-group input:not(.party-theme *) {
    background: #2d3748;
    border-color: #4a5568;
    color: white;
  }
}