<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h3>Files Upload</h3><hr>

        <form enctype="multipart/form-data" @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="files">Files</label>
                <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()" class="form-control">
            </div>

            <table v-if="fileList.length" class="table">
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
                            <div class="invalid-feedback" v-if="file.name == ''">Please provide a file name</div>
                            <div class="invalid-feedback" v-if="errors['file_names.' + index]">{{ errors['file_names.' + index][0] }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
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
        }
    },
    methods: {
        getCourseUrl() {
            return '/courses/' + this.course.slug;
        },
        handleFiles() {
            this.errors = [];

            this.fileList = [];
            this.fileList = this.$refs.files.files;

            // convert filelist to array, extract file names
            var fileListArray = Array.from(this.fileList);
            this.fileNames = [];
            this.fileNames = fileListArray.map(function(a) {return a.name});

            // console.log(this.fileNames);
        },
        onSubmit() {
            this.errors = [];

            // create new files with new file names
            this.files = [];
            for (var i = 0; i < this.fileList.length; i++) {
                var file = new File([this.fileList[i]], this.fileNames[i] ? this.fileNames[i] : 'null', {type: this.fileList[i].type});
                this.files[i] = file;
            }
            
            // console.log(this.fileNames);
            // console.log(this.files);

            var formData = new FormData();
            formData.append('course_id', this.course.id);
            formData.append('course_slug', this.course.slug);
            for (var i = 0; i < this.files.length; i++) {
                formData.append('files[]', this.files[i]);
            }

            /*for (var pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }*/

            axios.post('/api/files', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                console.log(response);
                // window.location.href = '/courses/' + this.course.slug + '/files/' + response.data.file.slug;
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                console.log(this.errors);
            });
        },
    },
}
</script>
