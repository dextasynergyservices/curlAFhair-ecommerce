<<<<<<< HEAD
import './bootstrap';

shopButton.addEventListener('mouseenter', () => {
    shopButton.classList.add('animate-bounce');

    setTimeout(() =>{
        shopButton.classList.remove('animate-bounce');
      }, 500)
  });

  
=======
import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Alpine.js component for sidebar toggling and dark mode
document.addEventListener("alpine:init", () => {
    Alpine.data("sidebar", () => ({
        open: false,
        darkMode: localStorage.getItem("darkMode") === "true",

        toggleSidebar() {
            this.open = !this.open;
        },

        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem("darkMode", this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        },
    }));
});
>>>>>>> develop
