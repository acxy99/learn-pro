<template>
    <div class="container mt-3">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ page.course.code }} {{ page.course.title }}</a>
        </small>
        <h3>{{ page.title }}</h3><hr>
        <p v-html="page.body"></p>
        <!-- <p id="content">{{ page.body }}</p> -->
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
                },
                // content: '<pre class="language-python"><code>#!/usr/bin/env python import socket import subprocess import sys from datetime import datetime</code></pre>'
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
                return '/courses/' + this.page.course.code;
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