<template>
    <div class="container pt-4 col-lg-6 col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li v-if="course.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">{{ title }}</li>
            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>{{ title }}</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form enctype="multipart/form-data" @submit.prevent="onSubmit">
                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" id="code" v-model="course.code" class="form-control" :class="{'is-invalid': errors['code']}" maxlength="8" :readonly="course.id">
                    <div class="invalid-feedback" v-if="errors['code']">{{ errors['code'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="course.title" class="form-control" :class="{'is-invalid': errors['title']}" maxlength="100">
                    <div class="invalid-feedback" v-if="errors['title']">{{ errors['title'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" v-model="course.description" class="form-control" :class="{'is-invalid': errors['description']}"></textarea>
                    <div class="invalid-feedback" v-if="errors['description']">{{ errors['description'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="owner">Primary instructor (owner)</label>
                    <multiselect 
                        :class="{'is-danger': selectedOwner == null || errors['owner_id']}"
                        v-model="selectedOwner"
                        deselect-label="Selected"
                        :options="ownerOptions"
                        track-by="id"
                        :custom-label="customInstructorLabel"
                        :searchable="true"
                        :allow-empty="false"
                        placeholder="Select primary instructor"
                        :disabled="$userIsInstructor() || course.id != null">
                    </multiselect>
                    <div class="invalid-feedback" style="display: block" v-if="errors['owner_id']">{{ errors['owner_id'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="co-instructors">Co-instructors</label>
                    <multiselect
                        v-model="selectedCoInstructors"
                        :options="coInstructorsOptions"
                        :multiple="true"
                        :hide-selected="true"
                        track-by="id"
                        :custom-label="customInstructorLabel"
                        placeholder="Select co-instructors"
                        :disabled="!$userIsAdmin() && (course.id != null && !userIsCourseOwner())">
                    </multiselect>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    
                    <div v-if="course.image" class="text-muted">
                        <span class="align-middle">Current image: </span>
                        <span class="align-middle mr-2">
                            <a role="button" class="anchor-custom border-0 p-0" :href="course.image_path">{{ currentImage }}</a>
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
import Multiselect from 'vue-multiselect/src/Multiselect.vue';
// import 'vue-multiselect/dist/vue-multiselect.min.css';

export default {
    components: { Multiselect },
    props: ['course', 'categories', 'instructors'],
    data() {
        return {
            title: '',
            courseUrl: '',
            currentImage: this.course.image,
            selectedOwner: [],
            ownerOptions: this.instructors,
            selectedCoInstructors: [],
            coInstructorsOptions: this.instructors,
            selectedCategories: [],
            categoryOptions: this.categories,
            errors: [],
        }
    },
    created() {
        if (this.course.id) {
            this.title = 'Edit Course';
            this.courseUrl = '/admin/courses/' + this.course.slug;
            this.selectedOwner = this.course.owner;
            this.selectedCategories = this.course.categories;
            this.selectedCoInstructors = this.course.co_instructors;
        } else {
            this.title = 'Create Course';
            this.selectedOwner = this.$userIsInstructor() ? this.$user : '';
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
            formData.append('owner_id', this.selectedOwner.id || '');
            for (var i = 0; i < this.selectedCoInstructors.length; i++) {
                formData.append('co_instructors_id[]', this.selectedCoInstructors[i].id);
            }
            formData.append('categories', this.selectedCategories.map(category => (category.id)));

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
        userIsCourseOwner() {
            return this.course.owner_id == this.$user.id;
        },
        cancel() {
            window.history.back();
        },
    },
    watch: {
        selectedOwner: function(val) {
            var vm = this;
            if (vm.selectedOwner) {
                vm.coInstructorsOptions = vm.instructors.filter(function(el) {
                    return el.id !== vm.selectedOwner.id;
                })
            } else {
                vm.coInstructorsOptions = vm.instructors;
                vm.selectedOwner = '';
            }
        },
        selectedCoInstructors: function(val) {
            var vm = this;
            if (vm.selectedCoInstructors.length) {
                vm.ownerOptions = vm.instructors.filter(function(el) {
                    return !(vm.selectedCoInstructors.map(instructor => instructor.id)).includes(el.id);
                })
            } else {
                vm.ownerOptions = vm.instructors;
            }
        }
    }
}
</script>

<style>
.is-danger .multiselect__tags {
    border-color: #dc3545;
}
</style>
