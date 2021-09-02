<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="topicsUrl">Topics</a></li>
                <li v-if="topic.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="topicUrl">{{ topic.title }}</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">{{ title }}</li>
            </ol>
        </nav>
        
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>{{ title }}</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form enctype="multipart/form-data" @submit.prevent="onSubmit">
                <div class="form-group" hidden>
                    <label for="course_id">Course</label>
                    <input type="text" class="form-control" id="course_id" :value="course.id" readonly>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" v-model="topic.title" class="form-control" v-on:change="topicTitleChanged()"  :class="{'is-invalid': errors['title']}" maxlength="100">
                        <div class="invalid-feedback" v-if="errors['title']">{{ errors['title'][0] }}</div>
                    </div>
                    
                    

                    <div class="col-md-12 form-group">
                        <label for="difficulity">Difficulity</label>
                        <select id="difficulity" name="difficulity"  class="form-control" placeholder="Select Difficulity" v-model="topic.difficulity" v-on:change="topicDifficulityChanged()" :class="{'is-invalid': errors['difficulity']}">
                                <option value="easy">Easy</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                        </select>
                        <div class="invalid-feedback" v-if="errors['difficulity']">{{ errors['difficulity'][0] }}</div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-4 form-group">
                        <label for="custom_index">Custom Index</label>
                        <input type="number" id="custom_index" name="custom_index" v-model="topic.custom_index" class="form-control"  v-on:change="topicCustomIndexChanged()" :class="{'is-invalid': errors['custom_index']}" maxlength="100">
                        <div class="invalid-feedback" v-if="errors['custom_index']">{{ errors['custom_index'][0] }}</div>
                    </div>

                     <div class="col-md-4 form-group">
                        <label for="custom_index">Number of Question Answer</label>
                        <input type="number" id="num_ques" name="num_ques" v-model="topic.num_ques" class="form-control"   :class="{'is-invalid': errors['num_ques']}" maxlength="100">
                        <div class="invalid-feedback" v-if="errors['num_ques']">{{ errors['num_ques'][0] }}</div>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="custom_index">Passing mark PLA</label>
                        <input type="number" id="passing_mark" name="passing_mark" v-model="topic.passing_mark" class="form-control"   :class="{'is-invalid': errors['passing_mark']}" maxlength="100">
                        <div class="invalid-feedback" v-if="errors['passing_mark']">{{ errors['passing_mark'][0] }}</div>
                    </div>
                    </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-form br-0" dusk="save-button">Save</button>
                    <button type="button" class="btn btn-secondary btn-form br-0" @click="cancel()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect/src/Multiselect.vue';


export default {
    components: { Multiselect },

    props: ['course', 'topic'],
    data() {
        return {
            title: '',
            courseUrl: '/admin/courses/' + this.course.slug,
            topicsUrl: '/admin/courses/' + this.course.slug + '/topic',
            topicUrl: '',
            errors: [],
            cancelUrl: '',
            topicTitle: this.topic.title,
            topicCustomIndex: this.topic.custom_index,
            topicDifficulity: this.topic.difficulity,
        }
    },
    mounted(){
        window.console.log(this.topic.num_ques);
    },
    created() {
        this.setTitle();
    },
    methods: {
        setTitle() {
            if (this.topic.id) { 
                this.title = 'Update Topic';
                this.topicUrl = '/admin/courses/' + this.course.slug + '/topic/' + this.topic.id;
            } else {
                this.title = 'Create Topic';
            }
        },
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('title', this.topic.title);
            formData.append('custom_index', this.topic.custom_index);
            formData.append('passing_mark', this.topic.passing_mark);
            formData.append('num_ques',this.topic.num_ques);
            formData.append('difficulity', this.topic.difficulity);
            formData.append('course_id', this.course.id);

            if (!this.topic.id) {
                this.createTopic(formData);
            } else {
                this.updateTopic(formData);
            }
        },
        createTopic(formData) {
            axios.post('/api/admin/topic', formData)
                .then(response => {
                    window.location.href = '/admin/courses/' + this.course.slug + '/topic';
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        updateTopic(formData) {
            formData.append('id', this.topic.id);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/topic/' + this.topic.id, formData, {
                _method: 'put',
            })
            .then(response => {
                window.location.href = '/admin/courses/' + this.course.slug + '/topic';
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
        },
        topicTitleChanged() {
            this.topicTitle = this.topic.title
        },
        topicDifficulityChanged() {
            this.topicDifficulity = this.topic.difficulity;
        },
        topicCustomIndexChanged() {
            this.topicCustomIndex = this.topic.custom_index;
        },

    },
}
</script>

<style>
.mce-tinymce {
    box-shadow: none!important;
}

.modal-lg {
    max-width: 65%;
}
</style>