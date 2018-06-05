<template>
    <div class="container">
        <h2>Courses</h2><hr>
        <b-button class="mb-3" variant="primary" href="/courses/create">Add New Course</b-button>
        
        <div v-if="courses.length">
            <div class="card-columns">
                <div class="card" v-for="course in courses" v-bind:key="course.id">
                    <div class="wrapper">
                        <img class="card-img-top img" :src="getImagePath(course)">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate"><a :href="getCourseUrl(course)">{{ course.title }}</a></h5>
                        <p class="card-text text-truncate">{{ course.description }}</p>
                    </div>
                </div>
            </div>

            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="fetchCourses(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="fetchCourses(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
        <div v-else>No courses to display</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                courses: [],
                course: {
                    id: '',
                    code: '',
                    title: '',
                    description: '',
                    image_path: '',
                },
                course_id: '',
                pagination: {},
                edit: false,
            }
        },

        created() {
            this.fetchCourses();
        },

        methods: {
            fetchCourses(page_url) {
                let vm = this;
                page_url = page_url || '/api/courses';
                fetch(page_url)
                    .then(res => res.json()) // map response to json
                    .then(res => {
                        this.courses = res.data;
                        vm.makePagination(res.links, res.meta);
                    })
                    .catch(err => console.log(err));
            },
            getImagePath(course) {
                return course.image_path;
            },
            getCourseUrl(course) {
                return '/courses/' + course.slug;
            },
            makePagination(links, meta) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    prev_page_url: links.prev,
                    next_page_url: links.next,
                };
                this.pagination = pagination;
            }
        }
    }
</script>