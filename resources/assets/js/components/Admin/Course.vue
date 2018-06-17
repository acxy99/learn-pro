<template>
    <div class="container">

        <small>Course Details</small>
        <div class="row">
            <div class="col align-self-center">
                <h4 class="m-0">{{ course.code }} {{ course.title }}</h4>
            </div>
            <div class="col text-right">
                <a class="btn btn-primary" style="border-radius: 0" :href="editCourseUrl" role="button">Edit Course Details</a>
            </div>
        </div>
        <hr>
        
        <table class="table table-sm table-borderless">
            <tbody>
                <tr>
                    <td style="width: 15%">Code:</td>
                    <td style="width: 85%">{{ course.code }}</td>
                </tr>
                <tr>
                    <td>Title:</td>
                    <td>{{ course.title }}</td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>{{ course.description }}</td>
                </tr>
                <tr>
                    <td>ID:</td>
                    <td>{{ course.id }}</td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><a :href="course.image_path" style="text-decoration: none">{{ course.image }}</a></td>
                    <!-- <td><img class="img-fluid" style="width: 500px" :src="course.image_path"></td> -->
                </tr>
                <tr>
                    <td>Created at:</td>
                    <td>{{ course.created_at }}</td>
                </tr>
                <tr>
                    <td>Updated at:</td>
                    <td>{{ course.updated_at }}</td>
                </tr>
            </tbody>
        </table>
        <hr>

        <div class="card-group">
            <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-sm-4 p-3 align-self-center text-center">
                            <i class="material-icons p-1 bg-white" style="font-size: 80px; color: #004ecc;">format_align_left</i><br>
                        </div>
                        <div class="col-sm-8 p-3 align-self-center text-right">
                            <p class="mb-1" style="font-size: 20;">Pages</p>
                            <h1>{{ course.pages_count }}</h1>
                            <small v-if="lastUpdatedPage" class="text-muted">Last updated at {{ lastUpdatedPage }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light" style="border-radius: 0" :href="managePagesUrl" role="button">Manage Pages</a>
                </div>
            </div>
            <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-sm-4 p-3 align-self-center text-center">
                            <i class="material-icons p-1" style="font-size: 100px; color: #ffc800;">folder_open</i><br>
                        </div>
                        <div class="col-sm-8 p-3 align-self-center text-right">
                            <p class="m-0" style="font-size: 20;">Files</p>
                            <h1>{{ course.files_count }}</h1>
                            <small v-if="lastUpdatedFile" class="text-muted">Last updated at {{ lastUpdatedFile }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light" style="border-radius: 0" :href="manageFilesUrl" role="button">Manage Files</a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['course', 'lastUpdatedPage', 'lastUpdatedFile'],
    data() {
        return {
            editCourseUrl: '/admin/courses/' + this.course.slug + '/edit',
            managePagesUrl: '#',
            manageFilesUrl: '#',
        }
    },
    created() {
        
    },
    methods: {

    },
}
</script>