import './bootstrap';
import 'tom-select/dist/css/tom-select.bootstrap5.css';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

window.Alpine = Alpine;

Alpine.start();
