<template>
    <div>
        <div class="jumbotron" :style="jumbotronStyle">
            <div class="p-5">
                <div class="text-center"><small>{{ course.code }}</small></div>
                <h3 class="text-center">{{ course.title }}</h3>
            </div>
        </div>

        <div class="container pb-5">
            <ul class="nav nav-tabs mb-3 nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" style="color: #495057" id="overview-tab" data-toggle="tab" href="#overview" role="tab" dusk="overview-tab">
                        <div class="d-inline-flex align-middle">
                            <i class="material-icons mr-3">info</i>
                            <span>Overview</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #495057" id="pages-tab" data-toggle="tab" href="#pages" role="tab" dusk="pages-tab">
                        <div class="d-inline-flex align-middle">
                            <i class="material-icons mr-3">notes</i>
                            <span>Pages</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #495057" id="files-tab" data-toggle="tab" href="#files" role="tab" dusk="files-tab">
                        <div class="d-inline-flex align-middle">
                            <i class="material-icons mr-3">folder</i>
                            <span>Files</span>
                        </div>
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane show active" id="overview" role="tabpanel">
                    <overview :course="course" dusk="overview-tab-content"></overview>
                </div>
                <div class="tab-pane" id="pages" role="tabpanel">
                    <pages :course="course" dusk="pages-tab-content"></pages>
                </div>
                <div class="tab-pane" id="files" role="tabpanel">
                    <files :course="course" dusk="files-tab-content"></files>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Overview from './Overview'
import Pages from './Pages'
import Files from './Files'

export default {
    components: { Overview, Pages, Files },
    props: ['course'],
    data() {
        return {
            jumbotronStyle: {
                'background-image': 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(' + this.course.image_path + ')',
            },
        }
    },
}
</script>

<style>
.jumbotron {
    opacity: 0.8;
    background-size: cover;
    background-position: center;
    height: 100%;
    color: white;
    border-radius: 0;
}
</style>