<template>
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-8 align-self-center">
                <h3 class="d-inline-flex align-items-center font-weight-light m-0">
                    <i class="material-icons mr-2" style="font-size: 2rem">school</i>
                    <span>Courses</span>
                </h3>
            </div>
            <div class="col-md-4 align-self-center">
                <input class="form-control" type="search" placeholder="Search by code or title" v-model="searchInput" @keyup="searchInputChanged()">
            </div>
        </div>
        <hr>
        
        <div v-if="courses.length" dusk="courses">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3" v-for="course in courses" v-bind:key="course.id">
                    <my-course-card :course="course" :dusk="course.slug"></my-course-card>
                </div>
            </div>

            <ul class="pagination" style="justify-content: center">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCourses(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCourses(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
        <div v-else class="p-5 bg-light text-center text-muted">
            <i class="material-icons" style="font-size: 5rem">school</i>
            <h5 class="font-weight-light">No courses found.</h5>
        </div>
    </div>
</template>

<script>
import MyCourseCard from '../MyCourseCard'

export default{
    components: { MyCourseCard },
    data() {
        return {
            courses: [],
            pagination: {},
            searchInput: '',
        }
    },
    mounted(){
        console.log(this.courses);
    },
    created() {
        this.getCourses();
    },
    methods: {
        getCourses(url) {
            url = url || '/api/mycourses/'+this.$user.id;
            axios.get(url, {
                    params: {
                        searchInput: this.searchInput
                    }
                })
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
        searchInputChanged() {
            this.getCourses();
        },
    }
}
</script>