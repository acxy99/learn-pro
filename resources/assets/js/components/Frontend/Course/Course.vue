<template>
    <div class="container">
        <div class="jumbotron" :style="jumbotronStyle">
            <div class="m-5">
                <div class="text-center"><small>{{ course.code }}</small></div>
                <h1 class="text-center">{{ course.title }}</h1>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3 nav-justified" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" style="color: #495057" id="overview-tab" data-toggle="tab" href="#overview" role="tab">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">info</i>
                        <span>Overview</span>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: #495057" id="pages-tab" data-toggle="tab" href="#pages" role="tab">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">notes</i>
                        <span>Pages</span>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: #495057" id="files-tab" data-toggle="tab" href="#files" role="tab">
                    <div class="d-inline-flex align-middle">
                        <i class="material-icons mr-3">link</i>
                        <span>Files</span>
                    </div>
                </a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane show active" id="overview" role="tabpanel">
                <overview :course="course"></overview>
            </div>
            <div class="tab-pane" id="pages" role="tabpanel">
                <pages :course="course"></pages>
            </div>
            <div class="tab-pane" id="files" role="tabpanel">
                <files :course="course"></files>
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
                'background-image': 'linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' + this.course.image_path + ')',
                'background-size': 'cover',
                'background-position': 'center',
                'height': '100%',
                'color': 'white',
                'border-radius': '0',
            },
        }
    },
}
</script>