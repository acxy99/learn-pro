<template>
    <div class="container">
        <h2>Courses</h2><hr>
        
        <div v-if="courses.length">
            <div class="card-columns">
                <div class="card" v-for="course in courses" v-bind:key="course.id">
                    <div class="wrapper">
                        <img class="card-img-top img" :src="getImagePath(course)">
                    </div>
                    <div class="card-body">
                        <a :href="getCourseUrl(course)" style="text-decoration: none">
                            <small>{{ course.code }}</small>
                            <h5 class="card-title text-truncate">{{ course.title }}</h5>
                        </a>
                        <p class="card-text text-truncate">{{ course.description }}</p>
                    </div>
                </div>
            </div>

            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCourses(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCourses(pagination.next_page_url)">Next</a></li>
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
                pagination: {},
            }
        },
        created() {
            this.getCourses();
        },
        methods: {
            getCourses(url) {
                url = url || '/api/courses';
                axios.get(url)
                    .then(response => {
                        this.courses = response.data.data;
                        this.makePagination(response.data.links, response.data.meta);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            makePagination(links, meta) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    prev_page_url: links.prev,
                    next_page_url: links.next,
                };
                this.pagination = pagination;
            },
            getImagePath(course) {
                return course.image_path;
            },
            getCourseUrl(course) {
                return '/courses/' + course.slug;
            },
        }
    }
</script>