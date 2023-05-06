// import Vue, { createApp } from 'vue'
// import { i18nVue } from 'laravel-vue-i18n'
// import i18n from "i18n";
import vuetify from "vuetify";

window.Vue = require("vue").default;
require("./Firebase");
import login from "./components/loginWithFirebase.vue";
import Register from "./components/Auth/Register.vue";
Vue.component("App", require("./components/loginWithFirebase.vue").default);

Vue.use(vuetify);
const app2 = new Vue({
    // resolve: lang => import(`../../lang/${lang}.json`),
    // i18n,
    el: "#login-container",
    render: (h) => h(login),
});

const app3 = new Vue({
    el: "#register-container",
    render: (h) => h(Register),
});
