<template>
    <b-container>
        <h3>{{ course.code }} {{ course.title }}</h3>
        <p>{{ course.description }}</p>
        <hr>

        <b-button class="mb-3" variant="primary" :to="getCreatePageUrl()">Add New Page</b-button>
        
        <div v-if="course.pages.length">
            <div class="card mb-2" v-for="page in course.pages" v-bind:key="page.id">
                <div class="card-body">
                    <h5 class="card-title">
                        <b-link :to="getPageUrl(page.id)">{{ page.title }} [{{ page.id }}]</b-link>
                    </h5>
                </div>
            </div>
        </div>
        <div v-else>No pages to display</div>
    </b-container>
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
                return '/courses/' + this.course.id + '/pages/' + page_id;
            },
            getCreatePageUrl() {
                return '/courses/' + this.course.id + '/pages/create';
            }
        }
    }
</script>