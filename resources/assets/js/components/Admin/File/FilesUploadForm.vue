<template>
    <div class="container col-lg-7 col-md-9">
        <small class="d-block mb-2">
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">cloud_upload</i>
            <span>Upload Files</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form enctype="multipart/form-data" @submit.prevent="onSubmit">
                <div class="form-group">
                    <label for="files">Files</label>
                    <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()" class="form-control">
                </div>

                <table v-if="fileList.length" class="bg-white table table-hover table-bordered">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-1">#</th>
                            <th class="col-5">Original file name</th>
                            <th class="col-6">New file name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(file, index) in fileList" :key="index" class="d-flex">
                            <th class="col-1">{{ index }}</th>
                            <td class="col-5">{{ file.name }}</td>
                            <td class="col-6">
                                <input type="text" id="name" v-model="fileNames[index]" class="form-control" :class="{'is-invalid': errors['file_names.' + index]}">
                                <div class="invalid-feedback" v-if="errors['file_names.' + index]">{{ errors['file_names.' + index][0] }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-form br-0">Upload</button>
                    <a class="btn btn-secondary btn-form br-0" :href="cancelUrl" role="button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            fileList: [],
            fileNames: [],
            files: [],
            errors: {},
            cancelUrl: this.getCourseUrl() + '/files',
        }
    },
    methods: {
        getCourseUrl() {
            return '/admin/courses/' + this.course.slug;
        },
        handleFiles() {
            this.errors = [];

            this.fileList = [];
            this.fileList = this.$refs.files.files;

            // convert filelist to array, extract file names
            var fileListArray = Array.from(this.fileList);
            this.fileNames = [];
            this.fileNames = fileListArray.map(function(a) {return a.name});
        },
        onSubmit() {
            this.errors = [];

            // create new files with new file names
            this.files = [];
            for (var i = 0; i < this.fileList.length; i++) {
                var file = new File([this.fileList[i]], this.fileNames[i] ? this.fileNames[i] : 'null', {type: this.fileList[i].type});
                this.files[i] = file;
            }

            var formData = new FormData();
            formData.append('course_id', this.course.id);
            formData.append('course_slug', this.course.slug);
            for (var i = 0; i < this.files.length; i++) {
                formData.append('files[]', this.files[i]);
            }

            axios.post('/api/admin/files', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/admin/courses/' + this.course.slug + '/files';
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },
    },
}
</script>
