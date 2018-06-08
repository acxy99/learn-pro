<template>
    <div class="container">
        <h3>{{ course.code }} {{ course.title }}</h3>
        <p>{{ course.description }}</p><hr>

        <div class="mb-3">
            <a class="btn btn-primary" :href="editCourseUrl" role="button">Edit Course</a>
            <button type="button" @click="deleteCourse()" class="btn btn-danger">Delete Course</button>
            <a class="btn btn-primary" :href="addPageUrl" role="button">Add Page</a>
        </div>
        
        <div v-if="hasPages()">
            <div class="card mb-2" v-for="page in pages" v-bind:key="page.id">
                <div class="card-header">
                    <h5 class="mb-0">
                        <a :href="getPageUrl(page)" style="text-decoration: none">{{ page.title }}</a>
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
    props: ['course'],
    data() {
        return {
            pages: [],
            pagination: {},
            editCourseUrl: '/courses/' + this.course.slug + '/edit',
            addPageUrl: '/courses/' + this.course.slug + '/pages/create',
        }
    },
    created() {
        this.getPages(null);
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
        deleteCourse() {
            if(confirm('Are you sure you want to delete this course?')) {
                axios.delete('/api/courses/' + this.course.id)
                    .then(response => {
                        window.location.href = '/courses';
                    })
                    .catch(error => {
                        console.log(error);
                    });
                console.log('delete');
            }
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
    }
}
</script>