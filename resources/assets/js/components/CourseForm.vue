<template>
    <div class="container">
        <h3>{{ title }}</h3><hr>

        <form enctype="multipart/form-data" @submit.prevent="onSubmit">
            <!-- course code -->
            <div class="form-group invalid">
                <label for="code">Code</label>
                <input type="text" id="code" v-model="course.code" class="form-control" maxlength="8" :readonly="course.id">
                <span class="form-text text-muted" v-if="errors.code">{{ errors.code[0] }}</span>
            </div>

            <!-- course title -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" v-model="course.title" class="form-control" maxlength="50">
                <span class="form-text text-muted" v-if="errors.title">{{ errors.title[0] }}</span>
            </div>

            <!-- course description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" v-model="course.description" class="form-control"></textarea>
                <span class="form-text text-muted" v-if="errors.description">{{ errors.description[0] }}</span>
            </div>

            <!-- course image -->
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" accept="image/*" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            title: '',
            errors: [],
        }
    },
    created() {
        if (this.course.id) {
            this.title = 'Update Course';
        } else {
            this.title = 'Create Course';
            this.course.code = '';
            this.course.title = '';
            this.course.description = '';
            this.course.image = '';
        }
    },
    methods: {
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('code', this.course.code);
            formData.append('title', this.course.title);
            formData.append('description', this.course.description);
            formData.append('image', document.querySelector('#image').files[0]);

            if (!this.course.id) {
                this.createCourse(formData);
            } else {
                this.updateCourse(formData);
            }
        },
        createCourse(formData) {
            axios.post('/api/courses', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/courses/' + response.data.course.slug;
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },
        updateCourse(formData) {
            formData.append('id', this.course.id);
            formData.append('_method', 'PUT');

            axios.post('/api/courses/' + this.course.id, formData, {
                _method: 'put',
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/courses/' + response.data.course.slug;
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
    },
}
</script>

