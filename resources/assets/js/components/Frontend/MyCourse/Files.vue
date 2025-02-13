<template>
    <div class="container col-md-10">
        <input class="form-control br-0 mb-3" style="width: 40%" type="search" placeholder="Search" v-model="searchInput" @keyup="searchInputChanged()">

        <div v-if="files.length" dusk="files">
            <div class="list-group mb-3">
                <a class="list-group-item list-group-item-action br-0" v-for="file in files" :key="file.id" :href="getFileUrl(file)">
                    <div class="d-inline-flex align-items-center">                 
                        <i class="mdi mr-2" :class="getFileIconName(file.name)" style="font-size: 1.5rem"></i>
                        <span>{{ file.name }}</span>
                    </div>
                </a>
            </div>

            <ul class="pagination" style="display: flex; justify-content: center;">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getFiles(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getFiles(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
        <div v-else class="p-5 bg-light text-center text-muted">
            <i class="material-icons" style="font-size: 5rem">folder</i>
            <h5 class="font-weight-light">No files found.</h5><br>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course','topic'],
    data() {
        return {
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
            url = url || '/api/mycourses/topic/' + this.topic.id + '/files';
            axios.get(url, {
                    params: {
                        searchInput: this.searchInput,
                    }
                })
                .then(response => {
                    this.files = response.data.data;
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
        getFileUrl(file) {
            return file.file_path;
        },
        getFileExtension(filename) {
            return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
        },
        getFileIconName(filename) {
            let extension = this.getFileExtension(filename);
            var typeClass = '';

            switch(extension) {
                case 'ppt':
                case 'pptx':
                    typeClass = 'file-powerpoint-box';
                    break;
                case 'doc':
                case 'docx':
                    typeClass = 'file-word-box';
                    break;
                case 'xls':
                case 'xlsx':
                    typeClass = 'file-excel-box';
                    break;
                case 'pdf':
                    typeClass = 'file-pdf-box';
                    break;
                case 'zip':
                    typeClass = 'zip-box';
                    break;
                default:
                    typeClass = 'file-document-box';
            }

            return 'mdi-' + typeClass;
        },
        searchInputChanged() {
            this.getFiles();
        },
    }
}
</script>
