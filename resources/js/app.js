import $ from 'jquery';
import './bootstrap';
import App from './App.vue';
import { createApp } from 'vue';
import {router} from './router.js';
import 'bootstrap/dist/css/bootstrap.css';
import moment from 'moment';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const app = createApp(App);
app.use(router);
// app.use(moment);
app.use(Toast);
app.use($);
app.mount('#app');

