<template>
    <div>
        <div class="jumbotron" :style="jumbotronStyle">
            <div class="p-5">
                <h1 class="text-center" style="text-decoration:overline underline;">  Overview   </h1>
                <div class="text-center"><small>{{ course.code }}</small></div>
                <h3 class="text-center">{{ course.title }}</h3>
            </div>
        </div>


            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane show active" id="overview" role="tabpanel">
                    <overview :course="course" dusk="overview-tab-content"></overview>
                </div>
                <!-- <div class="tab-pane" id="pages" role="tabpanel">
                    <pages :course="course" dusk="pages-tab-content"></pages>
                </div>
                <div class="tab-pane" id="files" role="tabpanel">
                    <files :course="course" dusk="files-tab-content"></files>
                </div> -->
            
        </div>

        
    </div>
</template>

<script>
import Overview from './Overview'


export default {
    components: { Overview},
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