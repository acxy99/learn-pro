<template>
    <div class="container p-3">
        <h5 class="mb-4">All pages</h5>

        <div v-if="pages.length">
            <tree :courseSlug="course.slug" :children="pages" :depth="(-1)"></tree>

            <ul class="pagination" style="display: flex; justify-content: center;">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getPages(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getPages(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
        <div v-else class="p-5 bg-light text-center text-muted">
            <i class="material-icons" style="font-size: 5rem">notes</i>
            <h5 class="font-weight-light">No pages found.</h5><br>
        </div>
    </div>
</template>

<script>
import Tree from './Tree'

export default {
    components: { Tree },
    props: ['course'],
    data() {
        return {
            pages: [],
            pagination: {},
        }
    },
    created() {
        this.getPages();
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
        makePagination(links, meta) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                prev_page_url: links.prev,
                next_page_url: links.next,
            };
            this.pagination = pagination;
        },
    },
}
</script>
