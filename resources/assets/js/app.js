
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import LayoutHeader from './components/Layout/Header.vue';

import Dashboard from './components/Admin/Dashboard.vue';

import AdminCategories from './components/Admin/Category/Categories.vue';
import AdminCategory from './components/Admin/Category/Category.vue';
import AdminCategoryForm from './components/Admin/Category/CategoryForm.vue';

import AdminCourses from './components/Admin/Course/Courses.vue';
import AdminCourse from './components/Admin/Course/Course.vue';
import AdminCourseForm from './components/Admin/Course/CourseForm.vue';

import AdminPages from './components/Admin/Page/Pages.vue';
import AdminPage from './components/Admin/Page/Page.vue';
import AdminPageForm from './components/Admin/Page/PageForm.vue';

import AdminFiles from './components/Admin/File/Files.vue';
import AdminFilesUploadForm from './components/Admin/File/FilesUploadForm.vue';
import AdminFileEditForm from './components/Admin/File/FileEditForm.vue';

import Categories from './components/Frontend/Category/Categories.vue';
import Category from './components/Frontend/Category/Category.vue';

import Courses from './components/Frontend/Course/Courses.vue';
import Course from './components/Frontend/Course/Course.vue';

import Page from './components/Frontend/Page/Page.vue';

const app = new Vue({
    el: '#app',
    components: {
        LayoutHeader,
        Dashboard,
        AdminCategories, AdminCategory, AdminCategoryForm,
        AdminCourses, AdminCourse, AdminCourseForm,
        AdminPages, AdminPage, AdminPageForm,
        AdminFiles, AdminFilesUploadForm, AdminFileEditForm,
        Categories, Category,
        Courses, Course,
        Page,
    }
});
