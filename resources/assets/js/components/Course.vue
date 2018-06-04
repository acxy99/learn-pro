<template>
    <div class="container">
        <h3>{{ course.code }} {{ course.title }}</h3>
        <p>{{ course.description }}</p><hr>

        <b-button class="mb-3" variant="primary" :to="getEditCourseUrl()">Edit Course</b-button>
        <b-button class="mb-3" variant="primary" :to="getCreatePageUrl()">Add New Page</b-button>
        
        <div v-if="course.pages.length">
            <div class="card mb-2" v-for="page in course.pages" v-bind:key="page.id">
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
        </div>
        <div v-else>No pages to display</div>
    </div>
</template>

<script>
export default {
    props: ['slug'],
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
            page_url = page_url || ('/api/courses/' + this.slug);
            fetch(page_url)
                .then(res => res.json()) // map response to json
                .then(res => {
                    this.course = res.data;
                    //vm.makePagination(res);
                })
                .catch(err => console.log(err));
        },
        getEditCourseUrl() {
            return '/courses/' + this.course.slug + '/edit';
        },
        getPageUrl(page) {
            return '/courses/' + this.course.slug + '/pages/' + page.slug;
        },
        getCreatePageUrl() {
            return '/courses/' + this.course.slug + '/pages/create';
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