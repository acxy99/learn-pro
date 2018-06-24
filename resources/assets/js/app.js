
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

Vue.component('dashboard', require('./components/Admin/Dashboard.vue'));

Vue.component('admin-courses', require('./components/Admin/Courses.vue'));
Vue.component('admin-course-form', require('./components/Admin/CourseForm.vue'));
Vue.component('admin-course', require('./components/Admin/Course.vue'));

Vue.component('admin-pages', require('./components/Admin/Pages.vue'));
Vue.component('admin-page-form', require('./components/Admin/PageForm.vue'));
Vue.component('admin-page', require('./components/Admin/Page.vue'));

Vue.component('tree', require('./components/Tree.vue'));
Vue.component('sidebar-tree', require('./components/SidebarTree.vue'));

Vue.component('courses', require('./components/Courses.vue'));
Vue.component('course', require('./components/Course.vue'));

Vue.component('page', require('./components/Page.vue'));

Vue.component('files-upload-form', require('./components/FilesUploadForm.vue'));

const app = new Vue({
    el: '#app'
});
