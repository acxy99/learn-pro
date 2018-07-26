<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/categories">Categories</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Category Details</li>
            </ol>
        </nav>

        <div class="row mb-3">
            <div class="col-md-6 col-xl-7 align-self-center">
                <h4 class="m-0 font-weight-light">{{ category.title }}</h4>
            </div>
            <div class="col-md-6 col-xl-5  align-self-center text-right">
                <a class="btn btn-primary d-inline-flex align-items-center br-0" :href="editCategoryUrl" role="button">
                    <i class="material-icons mr-1">create</i>
                    <span>Edit Category</span>
                </a>
                <button class="btn btn-danger d-inline-flex align-items-center br-0" @click="deleteCategory()">
                    <i class="material-icons mr-1">delete</i>
                    <span>Delete Category</span>
                </button>
            </div>
        </div>
        <hr>

        <small class="text-muted">ID</small>
        <p>{{ category.id }}</p>

        <small class="text-muted">Title</small>
        <p>{{ category.title }}</p>

        <small class="text-muted">Description</small>
        <p>{{ category.description }}</p>

        <small class="text-muted">Image</small>
        <p>
            <a role="button" class="border-0 p-0" :href="category.image_path" data-toggle="tooltip" data-placement="bottom" title="View">
                <i class="material-icons align-middle" style="font-size: 1.2em; color: #888;">visibility</i>
            </a>
            <span v-if="category.image">{{ category.image }}</span>
            <span v-else>none</span>
        </p>
        
        <small class="text-muted">Related Courses</small>
            <div class="border p-2 mt-2">
            <table class="table table-bordered table-hover mb-2">
                <thead>
                    <tr>
                        <th style="width: 20%">Course Code</th>
                        <th style="width: 60%">Course Title</th>
                        <th style="width: 20%">Course ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="courses.length > 0" v-for="course in courses" :key="course.id" @mouseover="active = course.id" @mouseout="active = ''">
                        <td style="width: 20%">{{ course.code }}</td>
                        <td style="width: 60%">{{ course.title }}</td>
                        <td style="width: 20%">{{ course.id }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center">No courses found.</td>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination mb-0 justify-content-center">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCourses(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCourses(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ['category'],
    data() {
        return {
            editCategoryUrl: '/admin/categories/' + this.category.slug + '/edit',
            courses: [],
            pagination: {},
            active: '',
        }
    },
    created() {
        this.getCourses();
    },
    methods: {
        getCourses(url) {
            url = url || '/api/admin/categories/' + this.category.id + '/courses';
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
        deleteCategory() {
            if(confirm('Are you sure you want to delete this category?')) {
                axios.delete('/admin/categories/' + this.category.id)
                    .then(response => {
                        window.location.href = '/admin/categories';
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
    },
}
</script>
