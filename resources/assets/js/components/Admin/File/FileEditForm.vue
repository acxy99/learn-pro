<template>
    <div class="container pt-4 col-lg-6 col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="filesUrl">Files</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Edit</li>
            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>Edit File Name</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form @submit.prevent="onSubmit">
                <div class="form-group">
                    <label for="ori_name">Original File Name</label>
                    <input type="text" id="ori_name" v-model="file.name" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="name">New File Name</label>
                    <input type="text" id="name" v-model="file.name" class="form-control" :class="{'is-invalid': errors['name']}">
                    <div class="invalid-feedback" v-if="errors['name']">{{ errors['name'][0] }}</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-form br-0">Save</button>
                    <button type="button" class="btn btn-secondary btn-form br-0" @click="cancel()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course', 'file'],
    data() {
        return {
            errors: [],
            courseUrl: '/admin/courses/' + this.course.slug,
            filesUrl: '/admin/courses/' + this.course.slug + '/files',
        }
    },
    methods: {
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('id', this.file.id);
            formData.append('name', this.file.name);
            formData.append('course_id', this.file.course_id);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/files/' + this.file.id, formData, {
                _method: 'put',
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = this.courseUrl + '/files';
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        cancel() {
            window.history.back();
        }
    }
}
</script>

