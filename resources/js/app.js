
require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
//Main pages
import App from './app.vue'



import Login from './components/login';
import Search from './components/search';
import History from './components/history';

Vue.component('login', Login);
Vue.component('search', Search);
Vue.component('history', History);

const router = new VueRouter({
    routes: [
        { path: "/history", component: History },
        { path: "/", component: Search }
    ],
    mode: 'history'
})
const app = new Vue({
    router,
    el: '#app',
    components: { App, Login, Search, History},
    render: h => h(App),
});
