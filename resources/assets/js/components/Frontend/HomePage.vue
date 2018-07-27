<template>
    <div class="container pt-5 pb-5">
        <div class="jumbotron">
            <div class="m-5">
                <h3 class="text-center">Welcome to LEARN<b>PRO</b></h3>
                <p class="text-center font-weight-light">A web based learning content management system for programming</p>
            </div>
        </div>
        <hr>

        <h5 class="mt-4 mb-3">Popular Categories</h5>
        <div v-if="categories.length">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-3" v-for="category in categories" v-bind:key="category.id">
                    <category-card :category="category" :homepage="true"></category-card>
                </div>
            </div>
        </div>
        <div v-else class="p-5 bg-light text-center text-muted">
            <i class="material-icons" style="font-size: 5rem">apps</i>
            <h5 class="font-weight-light">No categories found.</h5>
        </div>
        <hr>

        <h5 class="mt-4 mb-3">New Courses</h5>
        <div v-if="courses.length">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-3" v-for="course in courses" v-bind:key="course.id">
                    <course-card :course="course" :homepage="true"></course-card>
                </div>
            </div>
        </div>
        <div v-else class="p-5 bg-light text-center text-muted">
            <i class="material-icons" style="font-size: 5rem">school</i>
            <h5 class="font-weight-light">No courses found.</h5>
        </div>
    </div>
</template>

<script>
import CategoryCard from './CategoryCard'
import CourseCard from './CourseCard'

export default {
    components: { CategoryCard, CourseCard },
    data() {
        return {
            categories: [],
            courses: [],
        }
    },
    created() {
        this.getCategories();
        this.getCourses();
    },
    methods: {
        getCategories() {
            axios.get('/api/categories/popular')
                .then(response => {
                    this.categories = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getCourses() {
            axios.get('/api/courses/new')
                .then(response => {
                    this.courses = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getCourseUrl(course) {
            return '/courses/' + course.slug;
        },
    }
}
</script>