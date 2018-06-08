
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Bootstrap Vue
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('layoutheader', require('./components/LayoutHeader.vue'));
// Vue.component('categories', require('./components/Categories.vue'));
// Vue.component('category', require('./components/Category.vue'));
Vue.component('courses', require('./components/Courses.vue'));
Vue.component('course-form', require('./components/CourseForm.vue'));
Vue.component('course', require('./components/Course.vue'));
Vue.component('page', require('./components/Page.vue'));
Vue.component('page-form', require('./components/PageForm.vue'));

const app = new Vue({
    el: '#app'
});
