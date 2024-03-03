
import 'bootstrap/dist/js/bootstrap'
import 'bootstrap/dist/css/bootstrap.css'

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

