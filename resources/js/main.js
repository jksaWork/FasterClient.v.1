window.Vue = require('vue').default;
require('./Firebase');
import login from  './components/loginWithFirebase.vue';
Vue.component('App', require('./components/loginWithFirebase.vue').default);
// import Notifications from 'vue-notification'

// import Snackbar from 'vuejs-snackbar';

// Global register
// Vue.component('snackbar', Snackbar);

// Vue.use(Notifications);
const app2 = new Vue({
    el: '#login-container',
    render: h => h(login),
});
