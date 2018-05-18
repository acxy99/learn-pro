<template>
    <div class="container">
        <h1>Courses</h1>
        <div class="card card-body mb-2" v-for="course in courses" v-bind:key="course.id">
            <h4>{{ course.code }} {{ course.title }}</h4>
            <p>{{ course.description }}</p>
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
                    description: ''
                },
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