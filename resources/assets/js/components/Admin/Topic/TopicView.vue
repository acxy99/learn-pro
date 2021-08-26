<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="topicUrl">Topic</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">{{topic.id}}</li>
                
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6 col-xl-7 align-self-center">
                <h5 class="m-0">{{ course.code }} {{ course.title }}</h5>
            </div>
            
        </div>
        <hr>

        <div class="row">
            <div class="col-md-1">
                <small class="text-muted">ID</small>
                <p>{{ topic.id }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Title</small>
                <p>{{ topic.title }}</p>
            </div>
            <div class="col-md-8">
                <small class="text-muted">Difficulity</small>
                <p>{{ topic.difficulity }}</p>
            </div>
        </div>

        <small class="text-muted">Passing Mark For PLA</small>
        <p>{{ topic.passing_mark }}</p>

        <small class="text-muted">Number of Question to Answer </small>
        <p>{{ topic.num_ques }}</p>

        <hr>
    
        <!-- enhancement_v1 -->
        <div class="card-group mb-5">
        
            <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons p-1" style="font-size: 100px; color: #02b1f7;">article</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <p class="m-0" style="font-size: 20;">PLA</p>
                            <h1>{{ topic.pla_count }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light br-0" :href="managePlaUrl" role="button" dusk="manage-pla-button">Manage PLA</a>
                </div>
            </div>

             <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons p-1" style="font-size: 100px; color: #004ecc;">note_add</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <p class="mb-1" style="font-size: 20;">Pages</p>
                            <h1>{{ topic.pages_count }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light br-0" :href="managePagesUrl" role="button" dusk="manage-pages-button">Manage Pages</a>
                </div>
            </div>
            <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons p-1" style="font-size: 100px; color: #ffc800;">folder_open</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <p class="m-0" style="font-size: 20;">Files</p>
                            <h1>{{ topic.files_count }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light br-0" :href="manageFilesUrl" role="button" dusk="manage-files-button">Manage Files</a>
                </div>
            </div>



        </div>
    </div>
</template>

<script>
export default {
    props: ['course', 'topic'],
    data() {
        return {
            indexUrl: '/admin/courses',
            courseUrl:'/admin/courses/'+this.course.slug ,
            topicUrl:'/admin/courses/'+this.course.slug+'/topic',
            editTopicUrl: '/admin/courses/' + this.course.slug + '/topic/'+this.topic.id+ '/edit',
            managePagesUrl: '/admin/courses/' + this.course.slug + '/topic/'+this.topic.id+'/pages',
            manageFilesUrl: '/admin/courses/' + this.course.slug +'/topic/'+this.topic.id+'/files',
            managePlaUrl: '/admin/courses/'+ this.course.slug + '/topic/'+this.topic.id  +'/pla',
            managePaUrl: '/admin/courses/'+ this.course.slug + '/topic/'+this.topic.id  +'/pa',
        }
    },
    methods: {
    },
}
</script>