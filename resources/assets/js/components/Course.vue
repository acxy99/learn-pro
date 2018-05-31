<template>
    <div class="container">
        <h3>{{ course.code }} {{ course.title }}</h3>
        <p>{{ course.description }}</p><hr>

        <b-button class="mb-3" variant="primary" :to="getCreatePageUrl()">Add New Page</b-button>
        
        <div v-if="course.pages.length">
            <div v-for="page in course.pages" v-bind:key="page.id">
                <div class="card mb-2">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <b-link :to="getPageUrl(page.id)">{{ page.title }}</b-link>
                        </h5>
                    </div>
                    <div v-if="hasChildren(page)">
                        <div class="card-body">
                            <li v-for="child in page.children" v-bind:key="child.id">{{ child.title }}</li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>No pages to display</div>
    </div>
</template>

<script>

    export default {
        props: {
            id: { type: String, required: true }
        },

        data() {
            return {
                course: {
                    id: '',
                    code: '',
                    title: '',
                    description: '',
                    pages: [],
                }
            }
        },

        created() {
            this.fetchCourse();
        },

        methods: {
            fetchCourse(page_url) {
                //let vm = this;
                page_url = page_url || ('/api/courses/' + this.id);
                fetch(page_url)
                    .then(res => res.json()) // map response to json
                    .then(res => {
                        this.course = res.data;
                        //vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            getPageUrl(page_id) {
                return '/courses/' + this.course.code + '/pages/' + page_id;
            },
            getCreatePageUrl() {
                return '/courses/' + this.course.code + '/pages/create';
            },
            isRoot(page) {
                return page.parent_id == null;
            },
            hasChildren(page) {
                return page.children.length;
            },
        }
    }
</script>