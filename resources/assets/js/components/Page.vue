<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ page.course.code }} {{ page.course.title }}</a>
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
    // window.Prism = require('prismjs');
    import 'prismjs/prism';
    import 'prismjs/themes/prism.css';

    export default {
        props: {
            id: { type: String, required: true }
        },

        data() {
            return {
                page: {
                    id: '',
                    title: '',
                    body: '',
                    course_id: '',
                    course: {},
                    children: [],
                },
            }
        },

        // components: {
        //     Prism
        // },

        created() {
            this.fetchPage();
            // this.highlightCode();
        },

        methods: {
            fetchPage: function() {
                fetch('/api/pages/' + this.id)
                    .then(res => res.json())
                    .then(res => {
                        this.page = res.data;
                    })
                    .catch(err => console.log(err));
            },
            getCourseUrl() {
                return '/courses/' + this.page.course.slug;
            },
            getChildUrl(child) {
                return '/courses/' + this.page.course.slug + '/pages/' + child.slug;
            },
            // highlightCode: function() {
            //     this.$nextTick(()=> Prism.highlightAll());
            // }
        },

        watch: {
            // Note : page.body is declared as string and assume page is defined in Vue data
            'page.body': function(value) {
                // let content = document.querySelector('#content');
                // content.innerHTML = value;
                this.$nextTick(()=> Prism.highlightAll());
                // console.log('watched');
            }
        }
        // mounted() {
        //     Prism.highlightAll();
        //     this.$nextTick(function () {
        //         Prism.highlightElement();
        //     })
        // },

        // ready () {
        //     Prism.highlightAll()
        // }
    }
</script>