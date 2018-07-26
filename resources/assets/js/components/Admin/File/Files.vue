<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Files</li>
            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">settings</i>
            <span>Manage Files</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <div class="row mb-3">
                <div class="col-md-9 align-self-center">
                    <input class="form-control br-0" style="width: 40%" type="search" placeholder="Search by file name" v-model="searchInput" @keyup="searchInputChanged()">
                </div>
                <div class="col-md-3 text-right">
                    <a class="btn btn-primary btn-form br-0" :href="uploadFilesUrl" role="button">Upload Files</a>
                </div>
            </div>

            <table class="bg-white table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 70%">File Name</th>
                        <th style="width: 10%">ID</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="file in files" :key="file.id" @mouseover="active = file.id" style="height: 65px">
                        <td style="width: 70%">
                            <a class="anchor-custom" :href="getFileUrl(file)">{{ file.name }}</a>
                        </td>
                        <td style="width: 10%">{{ file.id }}</td>
                        <td style="width: 20%">
                            <div v-show="active == file.id">
                                <a class="btn p-1" :href="getEditFileUrl(file)">
                                    <i class="material-icons">create</i>
                                </a>
                                <button class="btn p-1 bg-transparent" @click="deleteFile(file)">
                                    <i class="material-icons" style="color: red;">delete</i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination m-0" style="justify-content: center">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getFiles(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getFiles(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            courseUrl: '/admin/courses/' + this.course.slug,
            active: '',
            uploadFilesUrl: '/admin/courses/' + this.course.slug + '/files/create',
            files: [],
            pagination: {},
            searchInput: '',
        }
    },
    created() {
        this.getFiles();
    },
    methods: {
        getFiles(url) {
            url = url || '/api/admin/courses/' + this.course.id + '/files'

            axios.get(url, {
                    params: {
                        searchInput: this.searchInput,
                    }
                })
                .then(response => {
                    this.files = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(response => {
                    console.log(error);
                })
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
        getFileUrl(file) {
            return file.file_path;
        },
        getEditFileUrl(file) {
            return '/admin/courses/' + this.course.slug + '/files/' + file.id + '/edit';
        },
        deleteFile(file) {
            if(confirm('Are you sure you want to delete this file?')) {
                axios.delete('/admin/files/' + file.id)
                    .then(response => {
                        this.getFiles();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        searchInputChanged() {
            this.getFiles();
        }
    },
}
</script>
