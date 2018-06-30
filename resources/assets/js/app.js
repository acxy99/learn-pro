
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

Vue.component('admin-categories', require('./components/Admin/Category/Categories.vue'));
Vue.component('admin-category-form', require('./components/Admin/Category/CategoryForm.vue'));
Vue.component('admin-category', require('./components/Admin/Category/Category.vue'));

Vue.component('admin-courses', require('./components/Admin/Course/Courses.vue'));
Vue.component('admin-course-form', require('./components/Admin/Course/CourseForm.vue'));
Vue.component('admin-course', require('./components/Admin/Course/Course.vue'));

Vue.component('admin-pages', require('./components/Admin/Page/Pages.vue'));
Vue.component('admin-page-form', require('./components/Admin/Page/PageForm.vue'));
Vue.component('admin-page', require('./components/Admin/Page/Page.vue'));

Vue.component('admin-files', require('./components/Admin/File/Files.vue'));
Vue.component('admin-files-upload-form', require('./components/Admin/File/FilesUploadForm.vue'));
Vue.component('admin-file-edit-form', require('./components/Admin/File/FileEditForm.vue'));

Vue.component('categories', require('./components/Frontend/Category/Categories.vue'));
Vue.component('category', require('./components/Frontend/Category/Category.vue'));

Vue.component('courses', require('./components/Frontend/Course/Courses.vue'));
Vue.component('course', require('./components/Frontend/Course/Course.vue'));

Vue.component('page', require('./components/Frontend/Page/Page.vue'));

const app = new Vue({
    el: '#app'
});
