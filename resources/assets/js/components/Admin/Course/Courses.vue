<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Courses</li>
            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">settings</i>
            <span>Manage Courses</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <div class="row mb-3">
                <div class="col-7 align-self-center">
                    <input class="form-control br-0" style="max-width: 320px" type="search" placeholder="Search by code or title" v-model="searchInput" @keyup="searchInputChanged()">
                </div>
                <div class="col-5 text-right">
                    <a class="btn btn-primary br-0" :href="createCourseUrl" role="button">Create Course</a>
                </div>
            </div>

            <div style="overflow-x:auto">
                <table class="bg-white table table-hover table-bordered mb-3">
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
                        <tr v-for="course in courses" :key="course.id" @mouseover="active = course.id" @mouseout="active = ''" style="height: 75px">
                            <td style="width: 10%">{{ course.code }}</td>
                            <td style="width: 20%">
                                <a class="anchor-custom" :href="getManageCourseUrl(course)">{{ course.title }}</a>
                            </td>
                            <td style="width: 40%">{{ course.description }}</td>
                            <td style="width: 10%">
                                <div v-if="course.image">
                                    <a class="anchor-custom" :href="course.image_path">{{ course.image }}</a>
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
            </div>

            <ul class="pagination m-0" style="justify-content: center;">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCourses(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCourses(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
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
            searchInput: '',
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
                        user_id: this.$user.id,
                        searchInput: this.searchInput,
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
        searchInputChanged() {
            this.getCourses();
        }
    },
}
</script>