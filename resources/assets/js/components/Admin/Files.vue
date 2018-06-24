<template>
    <div class="container">

        <small class="text-muted">List of Files</small>
        <div class="row mb-3">
            <div class="col-md-9 align-self-center">
                <h5 class="m-0">{{ course.code }} {{ course.title }}</h5>
            </div>
            <div class="col-md-3 text-right">
                <a class="btn btn-primary" style="border-radius: 0" :href="uploadFilesUrl" role="button">Upload Files</a>
            </div>
        </div>

        <table class="table table-hover">
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
                        <a style="text-decoration: none" :href="getFileUrl(file)" download>{{ file.name }}</a>
                    </td>
                    <td style="width: 10%">{{ file.id }}</td>
                    <td style="width: 20%">
                        <div v-show="active == file.id">
                            <a class="btn p-1" :href="getEditFileUrl(file)">
                                <i class="material-icons">create</i>
                            </a>
                            <button class="btn p-1" style="background-color: transparent" @click="deleteFile(file)">
                                <i class="material-icons" style="color: red;">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <ul class="pagination mb-5">
            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getFiles(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getFiles(pagination.next_page_url)">Next</a></li>
        </ul>

    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            active: '',
            uploadFilesUrl: '/admin/courses/' + this.course.slug + '/files/create',
            files: [],
            pagination: {},
        }
    },
    created() {
        this.getFiles();
    },
    methods: {
        getFiles(url) {
            url = url || '/api/admin/courses/' + this.course.id + '/files'

            axios.get(url)
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
                axios.delete('/api/admin/files/' + file.id)
                    .then(response => {
                        this.getFiles();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    },
}
</script>
