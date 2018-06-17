<template>
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col align-self-center">
                <h4 class="m-0">List of Courses</h4>
            </div>
            <div class="col text-right">
                <a class="btn btn-primary" style="border-radius: 0" :href="createCourseUrl" role="button">Create Course</a>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 10%">Code</th>
                    <th style="width: 20%">Title</th>
                    <th style="width: 40%">Description</th>
                    <th style="width: 10%">Image</th>
                    <th style="width: 8%">ID</th>
                    <th style="width: 12%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="course in courses" :key="course.id" @mouseover="active = course.id">
                    <td>{{ course.code }}</td>
                    <td>{{ course.title }}</td>
                    <td>{{ course.description }}</td>
                    <td><a style="text-decoration: none;" :href="course.image_path">{{ course.image }}</a></td>
                    <td>{{ course.id }}</td>
                    <td>
                        <div v-show="active == course.id">
                            <span><a class="btn btn-primary" :href="getEditCourseUrl(course)" role="button">E</a></span>
                            <span><button type="button" class="btn btn-danger" @click="deleteCourse(course)">D</button></span><br>
                            <small><a style="text-decoration: none;" :href="getManageCourseUrl(course)">Manage Course</a></small>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <ul class="pagination mb-5">
            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCourses(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCourses(pagination.next_page_url)">Next</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            createCourseUrl: '/admin/courses/create',
            courses: [],
            pagination: {},
            active: '',
        };
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
        getEditCourseUrl(course) {
            return '/admin/courses/' + course.slug + '/edit';
        },
        deleteCourse(course) {
            if(confirm('Are you sure you want to delete this course?')) {
                axios.delete('/api/admin/courses/' + course.id)
                    .then(response => {
                        window.location.href = '/admin/courses';
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getManageCourseUrl(course) {
            return '/admin/courses/' + course.slug;
        },
    },
}
</script>