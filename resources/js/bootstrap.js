import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios.defaults.withCredentials = true;

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}