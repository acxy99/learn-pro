<template>
    <div class="container">
        <h3>{{ title }}</h3><hr>

        <form enctype="multipart/form-data" @submit.prevent="onSubmit">
            <!-- course code -->
            <div class="form-group invalid">
                <label for="code">Code</label>
                <input type="text" id="code" v-model="course.code" class="form-control" maxlength="8" :readonly="slug">
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
    props: ['slug'],
    data() {
        return {
            title: '',
            course: {
                id: '',
                code: '',
                title: '',
                description: '',
                image: '',
            },
            errors: [],
        }
    },
    created() {
        if (!this.slug) {
            this.title = 'Create Course';
        } else {
            this.title = 'Update Course';

            axios.get('/api/courses/' + this.slug)
                .then(response => {
                    console.log(response.data.data);
                    this.course = response.data.data;
                    console.log(this.course);
                })
                .catch(error => {
                    console.log(error);
                });
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

            if (!this.slug) {
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

            axios.post('/api/courses/' + this.slug, formData, {
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

