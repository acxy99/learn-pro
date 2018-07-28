<template>
    <div>
        <div class="jumbotron" :style="jumbotronStyle">
            <div class="container">
                <h3 class="text-center mb-3">{{ category.title }}</h3>
                <p class="text-center font-weight-light">{{ category.description }}</p>
            </div>
        </div>

        <div class="container pb-5">
            <div v-if="courses.length">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3" v-for="course in courses" v-bind:key="course.id">
                            <course-card :course="course"></course-card>
                    </div>
                </div>

                <ul class="pagination" style="justify-content: center">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCourses(pagination.prev_page_url)">Previous</a></li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCourses(pagination.next_page_url)">Next</a></li>
                </ul>
            </div>
            
            <div v-else class="p-5 bg-light text-center">
                <h5 class="text-muted">Sorry, we could not find any matching courses under this category.</h5><br>
                <a :href="categoriesIndexUrl" role="button" class="btn btn-dark br-0">Back to categories</a>
            </div>
        </div>
    </div>
</template>

<script>
import CourseCard from '../CourseCard'

export default {
    components: { CourseCard },
    props: ['category'],
    data() {
        return {
            courses: [],
            pagination: {},
            jumbotronStyle: {
                'background-image': 'linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(' + this.category.image_path + ')'
            },
            categoriesIndexUrl: '/categories',
        }
    },
    created() {
        this.getCourses();
    },
    methods: {
        getCourses(url) {
            url = url || '/api/categories/' + this.category.id + '/courses';
            axios.get(url)
                .then(response => {
                    this.courses = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(error => {
                    console.log(error)
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
        getCourseUrl(course) {
            return '/courses/' + course.slug;
        }
    }
}
</script>

<style>
.jumbotron {
    opacity: 0.8;
    background-size: cover;
    background-position: center;
    height: 100%;
    color: white;
    border-radius: 0;
}

.jumbotron div {
    padding: 3rem 10rem;
}

.jumbotron p {
    font-size: 0.9rem;
}
</style>