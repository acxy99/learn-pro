<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h3>{{ page.title }}</h3><hr>
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
        methods: {
            getCourseUrl() {
                return '/courses/' + this.course.slug;
            },
            getChildUrl(child) {
                return '/courses/' + this.course.slug + '/pages/' + child.slug;
            },
        },
        watch: {
            'page.body': function(value) {
                this.$nextTick(()=> Prism.highlightAll());
            }
        },
    }
</script>