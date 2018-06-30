
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

// Prism - syntax highlighting
import 'prismjs/prism';
import 'prismjs/themes/prism.css';

// Vue-multiselect
import Multiselect from 'vue-multiselect/src/Multiselect.vue';
Vue.component('multiselect', Multiselect);
// import 'vue-multiselect/dist/vue-multiselect.min.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('layout-header', require('./components/Layout/Header.vue'));

Vue.component('dashboard', require('./components/Admin/Dashboard.vue'));

Vue.component('admin-categories', require('./components/Admin/Categories.vue'));
Vue.component('admin-category-form', require('./components/Admin/CategoryForm.vue'));
Vue.component('admin-category', require('./components/Admin/Category.vue'));

Vue.component('admin-courses', require('./components/Admin/Courses.vue'));
Vue.component('admin-course-form', require('./components/Admin/CourseForm.vue'));
Vue.component('admin-course', require('./components/Admin/Course.vue'));

Vue.component('admin-pages', require('./components/Admin/Pages.vue'));
Vue.component('admin-page-form', require('./components/Admin/PageForm.vue'));
Vue.component('admin-page', require('./components/Admin/Page.vue'));

Vue.component('admin-files', require('./components/Admin/Files.vue'));
Vue.component('admin-files-upload-form', require('./components/Admin/FilesUploadForm.vue'));
Vue.component('admin-file-edit-form', require('./components/Admin/FileEditForm.vue'));

Vue.component('categories', require('./components/Frontend/Categories.vue'));
Vue.component('category', require('./components/Frontend/Category.vue'));

Vue.component('courses', require('./components/Frontend/Courses.vue'));
Vue.component('course', require('./components/Frontend/Course.vue'));

Vue.component('page', require('./components/Frontend/Page.vue'));

const app = new Vue({
    el: '#app'
});
