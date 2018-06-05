<template>
    <div class="container">
        <h3>{{ course.code }} {{ course.title }}</h3>
        <p>{{ course.description }}</p><hr>

        <b-button class="mb-3" variant="primary" :to="getEditCourseUrl()">Edit Course</b-button>
        <b-button class="mb-3" variant="primary" :to="getCreatePageUrl()">Add New Page</b-button>
        
        <div v-if="hasPages()">
            <div class="card mb-2" v-for="page in pages" v-bind:key="page.id">
                <div class="card-header">
                    <h5 class="mb-0">
                        <b-link :to="getPageUrl(page)">{{ page.title }}</b-link>
                    </h5>
                </div>
                <div v-if="hasChildren(page)">
                    <div class="card-body">
                        <h6 v-for="child in page.children" v-bind:key="child.id">
                            <a :href="getChildUrl(child)" style="text-decoration: none">{{ child.title }}</a>
                        </h6>
                    </div>
                </div>
            </div>

            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getPages(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getPages(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
        <div v-else>No pages to display</div>
    </div>
</template>

<script>
export default {
    props: ['slug'],
    data() {
        return {
            course: {},
            pages: [],
            pagination: {},
        }
    },
    created() {
        this.getCourse();
    },
    methods: {
        getCourse() {
            let vm = this;
            let course_id = '';

            axios.get('/api/courses/' + vm.slug)
                .then(response => {
                    vm.course = response.data.data;
                    course_id = response.data.data.id;
                })
                .then(function() {
                    vm.getPages(null, course_id);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getPages(url, course_id) {
            url = url || '/api/courses/' + course_id + '/pages';
            axios.get(url)
                .then(response => {
                    this.pages = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getEditCourseUrl() {
            return '/courses/' + this.course.slug + '/edit';
        },
        getCreatePageUrl() {
            return '/courses/' + this.course.slug + '/pages/create';
        },
        hasPages() {
            return this.pages.length;
        },
        getPageUrl(page) {
            return '/courses/' + this.course.slug + '/pages/' + page.slug;
        },
        hasChildren(page) {
            return page.children.length;
        },
        getChildUrl(child) {
            return '/courses/' + this.course.slug + '/pages/' + child.slug;
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
    }
}
</script>