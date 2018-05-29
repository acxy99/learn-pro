<template>
    <div class="container">
        <h2>Courses</h2><hr>
        <b-button class="mb-3" variant="primary" href="/courses/create">Add New Course</b-button>

        <!-- <b-card-group columns>
            <b-card 
                v-for="course in courses" 
                v-bind:key="course.id"
                v-bind:title="course.title">
                    <b-card-img :src="getImageUrl(course)" top/>
                    <p class="card-text">{{ course.description }}</p>
            </b-card>
        </b-card-group> -->
        
        <div v-if="courses.length">
            <div class="card-columns">
                <div class="card" v-for="course in courses" v-bind:key="course.id">
                    <img class="card-img-top" :src="getImageUrl(course)">
                    <div class="card-body">
                        <h5 class="card-title"><a :href="getCourseUrl(course)">{{ course.title }}</a></h5>
                        <p class="card-text">{{ course.description }}</p>
                    </div>
                </div>
            </div>

            <!-- <div style="padding: 15px">
                <div class="row mb-2" style="border: 1px solid #ccc;" v-for="(course, i) in courses" v-bind:key="course.id">
                    <div class="col-md-4" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
                        <img class="img-fluid" :src="getImageUrl(i)"/>
                    </div>
                    <div class="col-md-8" style="padding: 1.25rem">
                        <h5><a :href="getCourseUrl(course)">{{ course.title }}</a></h5>
                        <p>{{ course.description }}</p>
                    </div>
                </div>
            </div> -->

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
                    image: '',
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
            getImageUrl(course) {
                return course.image;
            },
            getCourseUrl(course) {
                return 'courses/' + course.code;
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