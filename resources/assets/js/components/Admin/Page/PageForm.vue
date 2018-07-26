<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="pagesUrl">Pages</a></li>
                <li v-if="page.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="pageUrl">{{ page.title }}</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">{{ title }}</li>
            </ol>
        </nav>
        
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>{{ title }}</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form @submit.prevent="onSubmit">
                <div class="form-group" hidden>
                    <label for="course_id">Course</label>
                    <input type="text" class="form-control" id="course_id" :value="course.id" readonly>
                </div>

                <div class="row">
                    <div class="col-md-7 form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" v-model="page.title" v-on:change="pageTitleChanged()" :class="{'is-invalid': errors['title']}">
                        <div class="invalid-feedback" v-if="errors['title']">{{ errors['title'][0] }}</div>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="parent_id">Parent</label>
                        <multiselect 
                            v-model="parent"
                            select-label="Click to select"
                            deselect-label="Click to deselect"
                            :options="parentOptions"
                            track-by="id"
                            :custom-label="customParentLabel"
                            :searchable="true"
                            :allow-empty="true"
                            placeholder="Select parent">
                        </multiselect>
                    </div>
                </div>

                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea class="form-control" id="body" :class="{'is-invalid': errors['body']}"></textarea>
                    <div class="invalid-feedback" v-if="errors['body']">{{ errors['body'][0] }}</div>
                </div>

                <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content br-0">
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

                <div class="text-center">
                    <button type="button" class="btn btn-dark btn-form br-0" data-toggle="modal" data-target="#preview">Preview</button>
                    <button type="submit" class="btn btn-primary btn-form br-0">Save</button>
                    <button type="button" class="btn btn-secondary btn-form br-0" @click="cancel()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect/src/Multiselect.vue';
import tinymce from 'tinymce/tinymce.js';
import 'tinymce/themes/modern/theme';

export default {
    components: { Multiselect },
    props: ['course', 'parents', 'files', 'page'],
    data() {
        return {
            title: '',
            courseUrl: '/admin/courses/' + this.course.slug,
            pagesUrl: '/admin/courses/' + this.course.slug + '/pages',
            pageUrl: '',
            fileList: [],
            errors: [],
            cancelUrl: '',
            pageTitle: this.page.title,
            pageBody: this.page.body,
            parent: this.parents.find(parent => parent.id === this.page.parent_id),
            parentOptions: this.parents,
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
                this.pageUrl = '/admin/courses/' + this.course.slug + '/pages/' + this.page.slug;
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
        customParentLabel(parent) {
            return parent.id + ': ' + parent.title;
        },
        initEditor() {
            let vm = this;

            tinymce.init({
                selector: '#body',
                plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools colorpicker textpattern editattributes help',
                toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | codesample link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | editattributes | removeformat',
                height: '450',
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
                },
                file_browser_callback_types: 'file image media',
                images_upload_base_path: window.location.origin,
                images_upload_handler: function (blobInfo, success, failure) {
                    var formData = new FormData();
                    formData.append('course_slug', vm.course.slug);
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    axios.post('/admin/courses/' + vm.course.slug + '/pages/uploadImage', formData)
                        .then(response => {
                            success(response.data.path);
                        })
                        .catch(error => {
                            console.log(error);
                            if (error.response.status == 422) {
                                console.log(error.response.data.errors);
                            }
                        });
                }
            });
        },
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('title', this.page.title);
            formData.append('body', tinymce.get('body').getContent());
            formData.append('course_id', this.course.id);
            formData.append('parent_id', this.parent ? this.parent.id : '');

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

<style>
.mce-tinymce {
    box-shadow: none!important;
}

.modal-lg {
    max-width: 65%;
}
</style>