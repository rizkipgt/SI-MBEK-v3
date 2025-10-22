import './bootstrap';
import 'preline'
import $ from 'jquery';
import Alpine from 'alpinejs';
import 'datatables.net-bs4';
import 'datatables.net-responsive-bs4';
// import AOS from 'aos';
import DataTable from 'datatables.net-dt';

let table = new DataTable('#myTable');
window.Alpine = Alpine;

Alpine.start();

window.$ = window.jQuery = $;
import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init();

