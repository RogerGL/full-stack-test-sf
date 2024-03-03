import './bootstrap';
import { createApp } from 'vue';


const app = createApp({});

import HomeComponent from './components/HomeComponent.vue';
import ProductForm from './components/product/ProductForm.vue';
import SupplierForm from './components/supplier/SupplierForm.vue';
import VueTelInput from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const VueTelInputOptions = {
  mode: "international",
  onlyCountries: ['NG', 'GH', "GB", "US", "CA", "BR"]
}

app.use(VueTelInput, VueTelInputOptions);
app.component('product-form', ProductForm);
app.component('supplier-form', SupplierForm);
app.component('home-component', HomeComponent);

app.mount('#app');
