<template>
    <div class="container">
        <h3>{{ title }}</h3><hr>

        <form enctype="multipart/form-data" @submit.prevent="onSubmit">
            <!-- course code -->
            <div class="form-group invalid">
                <label for="code">Code</label>
                <input type="text" id="code" v-model="course.code" class="form-control" :class="{'is-invalid': errors['code']}" maxlength="8" :readonly="course.id">
                <div class="invalid-feedback" v-if="errors['code']">{{ errors['code'][0] }}</div>
            </div>

            <!-- course title -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" v-model="course.title" class="form-control" :class="{'is-invalid': errors['title']}" maxlength="50">
                <div class="invalid-feedback" v-if="errors['title']">{{ errors['title'][0] }}</div>
            </div>

            <!-- course description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" v-model="course.description" class="form-control" :class="{'is-invalid': errors['description']}"></textarea>
                <div class="invalid-feedback" v-if="errors['description']">{{ errors['description'][0] }}</div>
            </div>

            <!-- course image -->
            <div class="form-group">
                <label for="image">Image</label>
                
                <div v-if="course.image" class="text-muted">
                    <span class="align-middle">Current image: </span>
                    <span class="align-middle mr-2">
                        <a role="button" class="border-0 p-0" style="text-decoration: none" :href="course.image_path">{{ currentImage }}</a>
                    </span>
                    <button class="btn border-0 p-0" @click="removeCurrentImage()" data-toggle="tooltip" data-placement="bottom" title="Remove">
                        <i class="material-icons align-middle" style="font-size: 1.2rem; color: #d82020;">cancel</i>
                    </button>
                </div>
                <div v-else class="text-muted">Current image: none</div>

                <input type="file" id="image" accept="image/*" class="form-control mt-2">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-light" @click="cancelUpdate()">Cancel</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            title: '',
            currentImage: this.course.image,
            errors: [],
        }
    },
    created() {
        if (this.course.id) {
            this.title = 'Edit Course';
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
            axios.post('/api/admin/courses', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/admin/courses/' + response.data.course.slug;
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
            formData.append('hasImage', this.course.image || document.querySelector('#image').files[0] ? true : false);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/courses/' + this.course.id, formData, {
                _method: 'put',
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/admin/courses/' + response.data.course.slug;
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        removeCurrentImage() {
            this.course.image = '';
            this.currentImage = '';
        },
        cancelUpdate() {
            window.history.back();
        },
    },
}
</script>

