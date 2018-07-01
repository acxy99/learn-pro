<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h4>{{ title }}</h4><hr>

        <form @submit.prevent="onSubmit">
            <div class="form-group" hidden>
                <label for="course_id">Course</label>
                <input type="text" class="form-control" id="course_id" :value="course.id" readonly>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" v-model="page.title" v-on:change="pageTitleChanged()" :class="{'is-invalid': errors['title']}">
                <div class="invalid-feedback" v-if="errors['title']">{{ errors['title'][0] }}</div>
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" id="body" :class="{'is-invalid': errors['body']}"></textarea>
                <div class="invalid-feedback" v-if="errors['body']">{{ errors['body'][0] }}</div>
            </div>

            <div class="form-group">
                <label for="parent_id">Parent</label>
                <select class="custom-select" v-model="page.parent_id">
                    <option selected value="">None</option>
                    <option v-for="parent in parents" v-bind:key="parent.id" :value="parent.id">{{ parent.title }}</option>
                </select>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="border-radius: 0px">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-label">{{ pageTitle }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p v-html="pageBody"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Preview</button>
                <a role="button" class="btn btn-light" @click="cancel">Cancel</a>
            </div>
        </form>

    </div>
</template>

<script>
import tinymce from 'tinymce/tinymce.js';
import 'tinymce/themes/modern/theme';

export default {
    props: ['course', 'parents', 'files', 'page'],
    data() {
        return {
            title: '',
            fileList: [],
            errors: [],
            cancelUrl: '',
            pageTitle: this.page.title,
            pageBody: this.page.body,
        }
    },
    created() {
        this.setTitle();
        this.setFileList();
        this.initEditor();
    },
    methods: {
        setTitle() {
            if (this.page.id) { 
                this.title = 'Update Page';
            } else {
                this.title = 'Create Page';
            }
        },
        setFileList() {
            for (var i = 0; i < this.files.length; i++) {
                var obj = { title: this.files[i].name, value: this.files[i].file_path }
                this.fileList[i] = obj;
            }
        },
        initEditor() {
            let vm = this;

            tinymce.init({
                selector: '#body',
                plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools colorpicker textpattern editattributes help',
                toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | codesample link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | editattributes | removeformat',
                height: '400',
                link_list: this.fileList,
                init_instance_callback : function(editor) {
                    if (vm.page.id) {
                        editor.setContent(vm.page.body);
                        vm.pageBody = tinymce.get('body').getContent();
                    }
                },
                setup: function (editor) {
                    editor.on('Change', function (e) {
                        vm.pageBodyChanged();
                    })
                }
            });
        },
        getCourseUrl() {
            return '/admin/courses/' + this.course.slug;
        },
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('title', this.page.title);
            formData.append('body', tinymce.get('body').getContent());
            formData.append('course_id', this.course.id);
            this.page.parent_id ? formData.append('parent_id', this.page.parent_id) : formData.append('parent_id', '');

            if (this.page.id) {
                this.updatePage(formData);
            } else {
                this.createPage(formData);
            }
        },
        createPage(formData) {
            axios.post('/api/admin/pages', formData)
                .then(response => {
                    window.location.href = '/admin/courses/' + this.course.slug + '/pages/' + response.data.page.slug;
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        updatePage(formData) {
            formData.append('id', this.page.id);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/pages/' + this.page.id, formData, {
                _method: 'put',
            })
            .then(response => {
                window.location.href = '/admin/courses/' + this.course.slug + '/pages/' + response.data.page.slug;
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
        pageTitleChanged() {
            this.pageTitle = this.page.title
        },
        pageBodyChanged() {
            this.pageBody = tinymce.get('body').getContent();
        },
    },
    watch: {
        'pageBody': function(value) {
            this.$nextTick(()=> Prism.highlightAll());
        }
    },
}
</script>
