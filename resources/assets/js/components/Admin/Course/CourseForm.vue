<template>
    <div class="container">
        <h4>{{ title }}</h4><hr>

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
                    <button type="button" class="btn border-0 p-0" @click="removeCurrentImage()" data-toggle="tooltip" data-placement="bottom" title="Remove">
                        <i class="material-icons align-middle" style="font-size: 1.2rem; color: #d82020;">cancel</i>
                    </button>
                </div>
                <div v-else class="text-muted">Current image: none</div>

                <input type="file" id="image" accept="image/*" class="form-control mt-2">
            </div>

            <div class="form-group">
                <label for="categories">Categories</label>
                <multiselect
                    id="categories"
                    v-model="selectedCategories"
                    :options="categoryOptions"
                    :multiple="true"
                    :hide-selected="true"
                    track-by="title"
                    :custom-label="customCategoryLabel"
                    placeholder="Select categories">
                </multiselect>
                <!-- <pre class="language-json"><code>{{ selectedCategories }}</code></pre> -->
            </div>

            <div class="form-group">
                <label for="instructors">Instructors</label>
                <multiselect
                    id="instructors"
                    v-model="selectedInstructors"
                    :options="instructorsOptions"
                    :multiple="true"
                    :hide-selected="true"
                    track-by="id"
                    :custom-label="customInstructorLabel"
                    placeholder="Select instructors">
                </multiselect>
                <!-- <pre class="language-json"><code>{{ selectedInstructors }}</code></pre> -->
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-light" @click="cancel()">Cancel</button>
        </form>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect/src/Multiselect.vue';
// import 'vue-multiselect/dist/vue-multiselect.min.css';

export default {
    components: { Multiselect },
    props: ['course', 'categories', 'instructors'],
    data() {
        return {
            title: '',
            currentImage: this.course.image,
            selectedCategories: [],
            categoryOptions: this.categories,
            selectedInstructors: [],
            instructorsOptions: this.instructors,
            errors: [],
        }
    },
    created() {
        if (this.course.id) {
            this.title = 'Edit Course';
            this.selectedCategories = this.course.categories;
            this.selectedInstructors = this.course.instructors;
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
            formData.append('categories', this.selectedCategories.map(category => (category.id)));
            formData.append('instructors', this.selectedInstructors.map(instructor => (instructor.id)));

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
        customCategoryLabel(category) {
            return category.title;
        },
        customInstructorLabel(instructor) {
            return instructor.username;
        },
        cancel() {
            window.history.back();
        },
    },
}
</script>

