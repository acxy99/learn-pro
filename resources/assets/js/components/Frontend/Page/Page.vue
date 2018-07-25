<template>
    <div class="container-fluid" style="height: 100%;">
        <div class="row" style="height: 100%">
            <nav class="col-sm-2 col-md-3 p-4" style="background-color: #F7F7F7; min-height: calc(100vh - 56px)">
                <h6>COURSE CONTENT</h6>
                <hr>
                <sidebar :course="course" :currentPage="page.title"></sidebar>
            </nav>

            <div class="col-sm-10 col-md-9 d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 pt-5">
                     <div class="row">
                        <div class="col-md-8 align-self-center">
                            <h4 class="d-inline-flex align-items-center m-0">
                                <span>{{ page.title }}</span>
                            </h4>
                        </div>
                        <div class="col-md-4 align-self-center text-right">
                            <a :href="getCourseUrl()" class="anchor-custom">
                                <i class="material-icons align-middle">keyboard_arrow_left</i>
                                <span class="align-middle">Back to course</span>
                            </a>
                        </div>
                    </div>
                    <hr>
        
                    <p v-html="page.body"></p><hr>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from './Sidebar'

export default {
    components: { Sidebar },
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
    },
}
</script>