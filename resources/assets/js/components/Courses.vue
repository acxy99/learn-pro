<template>
    <div class="container">
        <h2>Courses</h2><hr>

        <!-- <b-card-group columns>
            <b-card 
                v-for="course in courses" 
                v-bind:key="course.id"
                v-bind:title="course.title">
                    <b-card-img :src="getImageUrl(course)" top/>
                    <p class="card-text">{{ course.description }}</p>
            </b-card>
        </b-card-group> -->

        <div class="card-columns">
            <div class="card" v-for="course in courses" v-bind:key="course.id">
                <img class="card-img-top" :src="getImageUrl(course)" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{ course.title }}</h5>
                    <p class="card-text">{{ course.description }}</p>
                </div>
            </div>
        </div>

        <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="fetchCourses(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="fetchCourses(pagination.next_page_url)">Next</a></li>
        </ul>
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
                    image: ''
                },
                default_image: 'storage/courses/placeholder-image.png',
                course_id: '',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchCourses();
        },

        methods: {
            fetchCourses(page_url) {
                let vm = this;
                page_url = page_url || '/api/course';
                fetch(page_url)
                    .then(res => res.json()) // map response to json
                    .then(res => {
                        this.courses = res.data;
                        vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            getImageUrl(course) {
                return course.image ? course.image : this.default_image;
            },
            makePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    prev_page_url: res.prev_page_url,
                    next_page_url: res.next_page_url,
                };
                this.pagination = pagination;
            }
        }
    }
</script>