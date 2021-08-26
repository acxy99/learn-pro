
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Prism - syntax highlighting
import './prismjs/prism.js';
import './prismjs/prism.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import LayoutHeader from './components/Layout/Header.vue';
import HomePage from './components/Frontend/HomePage.vue';
import SuccessAlert from './components/Layout/SuccessAlert';

import Dashboard from './components/Admin/Dashboard.vue';

import AdminUsers from './components/Admin/User/Users.vue';
import AdminUserForm from './components/Admin/User/UserForm.vue';

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

import Profile from './components/Frontend/Profile/Profile';
import ProfileForm from './components/Frontend/Profile/ProfileForm';

import AdminLeap from './components/Admin/Leap/Questions.vue';
import AdminLeapQuestionForm from './components/Admin/Leap/QuestionForm.vue';

import AdminTopic from './components/Admin/Topic/Topic.vue';
import AdminTopicForm from './components/Admin/Topic/TopicForm.vue';
import AdminTopicView from './components/Admin/Topic/TopicView.vue';

import AdminPlaQuestions from './components/Admin/Pla/Questions.vue';
import AdminPlaQuestionForm from './components/Admin/Pla/QuestionForm.vue';

import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);
const router = new VueRouter({ 
    mode:'history' 
});

Vue.prototype.$user = window.user

Vue.prototype.$userIsAdmin = function() {
    return this.$user && this.$user.role.name == 'admin';
}

Vue.prototype.$userIsInstructor = function() {
    return this.$user && this.$user.role.name == 'instructor';
}

Vue.prototype.$userIsLearner = function() {
    return this.$user && this.$user.role.name == 'learner';
}

const app = new Vue({
    el: '#app',
    router,
    components: {
        LayoutHeader,
        HomePage,
        SuccessAlert,
        Dashboard,
        AdminUsers, AdminUserForm,
        AdminCategories, AdminCategory, AdminCategoryForm,
        AdminCourses, AdminCourse, AdminCourseForm,
        AdminPages, AdminPage, AdminPageForm,
        AdminFiles, AdminFilesUploadForm, AdminFileEditForm,
        Categories, Category,
        Courses, Course,
        Page,
        Profile, ProfileForm,
        AdminLeap,AdminLeapQuestionForm,
        AdminTopic,AdminTopicForm,AdminTopicView,
        AdminPlaQuestions,AdminPlaQuestionForm,
    }

});
