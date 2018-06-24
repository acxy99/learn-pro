<template>
    <div class="container">
        <div class="row m-0">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light mb-3">
                <sidebar :course="course" :currentPage="page.title"></sidebar>
            </div>

            <!-- Page Content -->
            <div class="col-md-9">
                <small>
                    <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
                </small>
                <h3>{{ page.title }}</h3>
                <hr>
      
                <p v-html="page.body"></p><hr>

                <small v-if="page.children.length"><em>Related sections</em></small>
                <div class="m-2">
                    <li v-for="child in page.children" v-bind:key="child.id">
                        <a :href="getChildUrl(child)">{{ child.title }}</a>
                    </li>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // Prism - syntax highlighting
    import 'prismjs/prism';
    import 'prismjs/themes/prism.css';

    import Sidebar from '../../components/Sidebar'

    export default {
        props: ['course', 'page'],
        data() {
            return {
                editPageUrl: '/courses/' + this.course.slug + '/pages/' + this.page.slug + '/edit',
            }
        },
        components: {
            'sidebar': Sidebar
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