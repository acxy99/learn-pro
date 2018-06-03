<template>
    <div class="container">
        <h3>{{ title }}</h3><hr>

        <form enctype="multipart/form-data" @submit.prevent="onSubmit">
            <!-- course code -->
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" v-model="course.code" class="form-control" maxlength="8">
            </div>

            <!-- course title -->
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" v-model="course.title" class="form-control" maxlength="50">
            </div>

            <!-- course description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" v-model="course.description" class="form-control"></textarea>
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
    props: ['id'],
    data() {
        return {
            title: '',
            course: {
                code: '',
                title: '',
                description: '',
                image: '',
            },
        }
    },
    created() {
        this.id ? this.title = 'Update Course' : this.title = 'Create Course';
    },
    methods: {
        onSubmit() {
            var formData = new FormData();
            formData.append('code', this.course.code);
            formData.append('title', this.course.title);
            formData.append('description', this.course.description);
            formData.append('image', document.querySelector('#image').files[0]);

            if(!this.id) {
                this.createCourse(formData);
            } else {
                this.updateCourse(formData);
            }
        },
        createCourse(formData) {
            axios.post('/api/course', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': Laravel.csrfToken,
                }
            })
            .then(function (response) {
                window.location.href = '/courses/' + response.data.course.slug;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        updateCourse(formData) {
            // put request
        },
    },
}
</script>

