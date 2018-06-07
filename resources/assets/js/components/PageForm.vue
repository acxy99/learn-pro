<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h3>{{ title }}</h3><hr>

        <form @submit.prevent="onSubmit">
            <div class="form-group" hidden>
                <label for="course_id">Course</label>
                <input type="text" class="form-control" id="course_id" :value="course.id" readonly>
            </div>

            <div class="form-group">
                <label for="parent_id">Parent</label>
                <select class="custom-select" v-model="page.parent_id">
                    <option selected value="">None</option>
                    <option v-for="parent in parents" v-bind:key="parent.id" :value="parent.id">{{ parent.title }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" v-model="page.title">
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" id="body"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
import tinymce from 'tinymce/tinymce.js';
import 'tinymce/themes/modern/theme';

export default {
    props: ['course', 'parents', 'page'],
    data() {
        return {
            title: '',
            errors: [],
        }
    },
    created() {
        this.setTitle();
        this.initEditor();
    },
    methods: {
        setTitle() {
            this.page.id ? this.title = 'Update Page' : this.title = 'Create Page';
        },
        initEditor() {
            let vm = this;

            tinymce.init({
                selector: '#body',
                plugins: 'link, codesample',
                height: '400',
                init_instance_callback : function(editor) {
                    if (vm.page.id) {
                        editor.setContent(vm.page.body);
                    }
                }
            });
        },
        getCourseUrl() {
            return '/courses/' + this.course.slug;
        },
        onSubmit() {
            var formData = new FormData();
            formData.append('title', this.page.title);
            formData.append('body', tinymce.get('body').getContent());
            formData.append('course_id', this.course.id);
            formData.append('parent_id', this.page.parent_id);

            if (this.page.id) {
                this.updatePage(formData);
            } else {
                this.createPage(formData);
            }
        },
        createPage(formData) {
            axios.post('/api/pages', formData)
                .then(response => {
                    window.location.href = '/courses/' + this.course.slug + '/pages/' + response.data.page.slug;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updatePage(formData) {
            formData.append('id', this.page.id);
            formData.append('_method', 'PUT');

            axios.post('/api/pages/' + this.page.id, formData, {
                _method: 'put',
            })
            .then(response => {
                window.location.href = '/courses/' + this.course.slug + '/pages/' + response.data.page.slug;
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
