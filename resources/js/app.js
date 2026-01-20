// resources/js/app.js

import './bootstrap';
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Dynamic import to ensure jQuery is ready
import('owl.carousel');
import Splide from '@splidejs/splide';
import '@splidejs/splide/css'; // Default theme
// import '@splidejs/splide/css/skyblue'; // Optional: alternative themes

window.Splide = Splide;
import flatpickr from "flatpickr";
window.flatpickr = flatpickr;
import Chart from 'chart.js/auto'
window.Chart = Chart
