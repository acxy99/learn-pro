<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h3>{{ page.title }}</h3><hr>

        <div class="mb-3">
            <a class="btn btn-primary" :href="editPageUrl" role="button">Edit Page</a>
            <button type="button" @click="deletePage()" class="btn btn-danger">Delete Page</button>
        </div>

        <p v-html="page.body"></p><hr>
        <h5 v-for="child in page.children" v-bind:key="child.id">
            <a :href="getChildUrl(child)">{{ child.title }}</a>
        </h5>
    </div>
</template>

<script>
    // Prism - syntax highlighting
    import 'prismjs/prism';
    import 'prismjs/themes/prism.css';

    export default {
        props: ['course', 'page'],
        data() {
            return {
                editPageUrl: '/courses/' + this.course.slug + '/pages/' + this.page.slug + '/edit',
            }
        },
        methods: {
            getCourseUrl() {
                return '/courses/' + this.course.slug;
            },
            getChildUrl(child) {
                return '/courses/' + this.course.slug + '/pages/' + child.slug;
            },
            deletePage() {
                if(confirm('Are you sure you want to delete this page?')) {
                    axios.delete('/api/pages/' + this.page.id)
                        .then(response => {
                            window.location.href = this.getCourseUrl();
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    console.log('delete');
                }
            },
        },
        watch: {
            'page.body': function(value) {
                this.$nextTick(()=> Prism.highlightAll());
            }
        },
    }
</script>