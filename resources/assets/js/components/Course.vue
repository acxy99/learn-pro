<template>
    <div class="container">
        <h3>{{ course.code }} {{ course.title }}</h3><hr>
        <!-- <div v-for="page in course.pages" v-bind:key="page.id">
            <h4>{{ page.title }}</h4>
        </div> -->
        <div class="card mb-2" v-for="page in course.pages" v-bind:key="page.id">
            <div class="card-body">
                <h5 class="card-title">{{ page.title }} [{{ page.id }}]</h5>
            </div>
        </div>
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
                    pages: []
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
            }
        }
    }
</script>