<template>
    <div class="container pt-4 col-lg-6 col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/categories">Categories</a></li>
                <li v-if="category.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="categoryUrl">{{ category.title }}</a></li>
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
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="category.title" class="form-control" :class="{'is-invalid': errors['title']}" maxlength="100">
                    <div class="invalid-feedback" v-if="errors['title']">{{ errors['title'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <small class="text-muted">(maximum 500 characters)</small>
                    <textarea id="description" v-model="category.description" class="form-control" :class="{'is-invalid': errors['description']}" maxlength="500" rows="3"></textarea>
                    <div class="invalid-feedback" v-if="errors['description']">{{ errors['description'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    
                    <div v-if="category.id">
                        <div v-if="category.image" class="text-muted">
                            <span class="align-middle">Current image: </span>
                            <span class="align-middle mr-2">
                                <a role="button" class="anchor-custom border-0 p-0" :href="category.image_path">{{ currentImage }}</a>
                            </span>
                            <button type="button" class="btn border-0 p-0" @click="removeCurrentImage()" data-toggle="tooltip" data-placement="bottom" title="Remove">
                                <i class="material-icons align-middle" style="font-size: 1.2rem; color: #d82020;">cancel</i>
                            </button>
                        </div>
                        <div v-else class="text-muted">Current image: none</div>
                    </div>

                    <input type="file" id="image" accept="image/*" class="form-control mt-1">
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
export default {
    props: ['category'],
    data() {
        return {
            title: '',
            categoryUrl: '',
            currentImage: this.category.image,
            errors: [],
        }
    },
    created() {
        if (this.category.id) {
            this.title = 'Edit Category';
            this.categoryUrl = '/admin/categories/' + this.category.slug;
        } else {
            this.title = 'Create Category';
            this.category.title = '';
            this.category.description = '';
            this.category.image = '';
        }
    },
    methods: {
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('title', this.category.title);
            formData.append('description', this.category.description);
            formData.append('image', document.querySelector('#image').files[0]);

            if (!this.category.id) {
                this.createCategory(formData);
            } else {
                this.updateCategory(formData);
            }
        },
        createCategory(formData) {
            axios.post('/api/admin/categories', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/admin/categories/' + response.data.category.slug;
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },
        updateCategory(formData) {
            formData.append('id', this.category.id);
            formData.append('hasImage', this.category.image || document.querySelector('#image').files[0] ? true : false);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/categories/' + this.category.id, formData, {
                _method: 'put',
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                window.location.href = '/admin/categories/' + response.data.category.slug;
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        removeCurrentImage() {
            this.category.image = '';
            this.currentImage = '';
        },
        cancel() {
            window.history.back();
        }
    }
}
</script>
