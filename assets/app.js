/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';


const dropdownMenu = document.querySelector('.navbar__menu-item--dropdown');
const dropdown = document.querySelector('.navbar__dropdown');

dropdownMenu.addEventListener('mouseenter', () => {
  dropdown.style.display = 'block';
});

dropdownMenu.addEventListener('mouseleave', () => {
  dropdown.style.display = 'none';
});
