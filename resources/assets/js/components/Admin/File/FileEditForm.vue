<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h5>Update File Details</h5><hr>

        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="course_id">Course ID</label>
                <input type="text" id="course_id" v-model="file.course_id" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="name">File Name</label>
                <input type="text" id="name" v-model="file.name" class="form-control" :class="{'is-invalid': errors['name']}">
                <div class="invalid-feedback" v-if="errors['name']">{{ errors['name'][0] }}</div>
            </div><br>

            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-light" @click="cancel()">Cancel</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['course', 'file'],
    data() {
        return {
            errors: [],
            cancelUrl: '#',
        }
    },
    methods: {
        getCourseUrl() {
            return '/admin/courses/' + this.course.slug;
        },
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
                window.location.href = this.getCourseUrl() + '/files';
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

