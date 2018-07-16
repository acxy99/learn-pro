<template>
    <div class="container">
        <div v-if="files.length">
            <div v-for="file in files" :key="file.id" class="m-2">
                <a :href="getFileUrl(file)" style="text-decoration: none;">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">link</i>
                        <span>{{ file.name }}</span>
                    </div>
                </a>
            </div>
        </div>
        <div v-else>No files uploaded</div>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            files: [],
            pagination: {},
        }
    },
    created() {
        this.getFiles();
    },
    methods: {
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
        getFileUrl(file) {
            return file.file_path;
        },
    }
}
</script>
