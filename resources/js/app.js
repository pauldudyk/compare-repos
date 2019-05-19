import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import Vuetify from 'vuetify';
import axios from 'axios';

Vue.component('comparator', require('@/js/components/Comparator.vue').default);

Vue.use(Vuetify);
Vue.use(axios, Vuex);

axios.defaults.baseURL = window.location.origin + '/api'; 

const app = new Vue({
    el: '#app',
    //store,
    //router: Routes,
});

export default app;
