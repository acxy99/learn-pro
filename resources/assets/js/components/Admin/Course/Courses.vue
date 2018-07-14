<template>
    <div class="container">

        <div class="row mb-3">
            <div class="col-md-9 align-self-center">
                <h4 class="m-0">List of Courses</h4>
            </div>
            <div class="col-md-3 text-right">
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
                    <th style="width: 5%">ID</th>
                    <th style="width: 15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="course in courses" :key="course.id" @mouseover="active = course.id" style="height: 75px">
                    <td style="width: 10%">{{ course.code }}</td>
                    <td style="width: 20%">
                        <a style="text-decoration: none" :href="getManageCourseUrl(course)">{{ course.title }}</a>
                    </td>
                    <td style="width: 40%">{{ course.description }}</td>
                    <td style="width: 10%">
                        <div v-if="course.image">
                            <a style="text-decoration: none;" :href="course.image_path">{{ course.image }}</a>
                        </div>
                        <div v-else class="text-muted">none</div>
                    </td>
                    <td style="width: 5%">{{ course.id }}</td>
                    <td style="width: 15%">
                        <div v-show="active == course.id">
                            <a class="btn p-1" :href="getViewCourseUrl(course)" data-toggle="tooltip" data-placement="bottom" title="View">
                                <i class="material-icons">visibility</i>
                            </a>
                            <a class="btn p-1" :href="getEditCourseUrl(course)" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                <i class="material-icons">create</i>
                            </a>
                            <button v-if="userCanDeleteCourse(course)" class="btn p-1" style="background-color: transparent" @click="deleteCourse(course)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                <i class="material-icons" style="color: red;">delete</i>
                            </button>
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
            url = url || '/api/admin/courses';

            axios.get(url, {
                    params: {
                        user_id: this.$user.id
                    }
                })
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
        getManageCourseUrl(course) {
            return '/admin/courses/' + course.slug;
        },
        getViewCourseUrl(course) {
            return '/courses/' + course.slug;
        },
        getEditCourseUrl(course) {
            return '/admin/courses/' + course.slug + '/edit';
        },
        userCanDeleteCourse(course) {
            return this.$userIsAdmin() || course.owner_id == this.$user.id;
        },
        deleteCourse(course) {
            if(confirm('Are you sure you want to delete this course?')) {
                axios.delete('/admin/courses/' + course.id)
                    .then(response => {
                        this.getCourses();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
    },
}
</script>