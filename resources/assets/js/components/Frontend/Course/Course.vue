<template>
    <div class="container">
        <div class="jumbotron" :style="jumbotronStyle">
            <div class="m-5">
                <div class="text-center"><small>{{ course.code }}</small></div>
                <h1 class="text-center">{{ course.title }}</h1>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3 nav-justified" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" style="color: #495057" id="overview-tab" data-toggle="tab" href="#overview" role="tab">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">info</i>
                        <span>Overview</span>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: #495057" id="pages-tab" data-toggle="tab" href="#pages" role="tab">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">notes</i>
                        <span>Pages</span>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: #495057" id="files-tab" data-toggle="tab" href="#files" role="tab">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">link</i>
                        <span>Files</span>
                    </div>
                </a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane show active" id="overview" role="tabpanel">
                <overview :course="course"></overview>
            </div>
            <div class="tab-pane" id="pages" role="tabpanel">
                <div v-if="hasPages()">
                    <tree :courseSlug="course.slug" :children="pages" :depth="(-1)"></tree>

                    <ul class="pagination" style="display: flex; justify-content: center;">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getPages(pagination.prev_page_url)">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getPages(pagination.next_page_url)">Next</a></li>
                    </ul>
                </div>
                <div v-else>No pages to display</div>
            </div>
            <div class="tab-pane" id="files" role="tabpanel">
                <div v-if="hasFiles()">
                    <div v-for="file in files" :key="file.id" class="m-2">
                        <a :href="getFileUrl(file)" style="text-decoration: none;">
                            <span class="icon ion-ios-document pr-3"></span>{{ file.name }}<br>
                        </a>
                    </div>
                </div>
                <div v-else>No files uploaded</div>
            </div>
        </div>
        
    </div>
</template>

<script>
import Overview from './Overview'
import Tree from './Tree'

export default {
    components: { Overview, Tree },
    props: ['course'],
    data() {
        return {
            pages: [],
            files: [],
            pagination: {},
            editCourseUrl: '/courses/' + this.course.slug + '/edit',
            addPageUrl: '/courses/' + this.course.slug + '/pages/create',
            uploadFilesUrl: '/courses/' + this.course.slug + '/files/create',
            jumbotronStyle: {
                'background-image': 'linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' + this.course.image_path + ')',
                'background-size': 'cover',
                'background-position': 'center',
                'height': '100%',
                'color': 'white',
                'border-radius': '0',
            },
        }
    },
    created() {
        this.getPages(null);
        this.getFiles();
    },
    methods: {
        getPages(url) {
            url = url || '/api/courses/' + this.course.id + '/pages';
            axios.get(url)
                .then(response => {
                    this.pages = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getFiles() {
            axios.get('/api/courses/' + this.course.id + '/files')
                .then(response => {
                    this.files = response.data.data;
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
        hasPages() {
            return this.pages.length;
        },
        hasFiles() {
            return this.files.length;
        },
        getFileUrl(file) {
            return file.file_path;
        }
    }
}
</script>