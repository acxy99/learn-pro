<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl()" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h3>Create Page</h3><hr>

        <form @submit.prevent="createPage">
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

tinymce.init({
    selector: '#body',
    plugins: 'link, codesample',
    height: '400',
});

export default {
    props: ['course','parents'],
    data() {
        return {
            page: {
                title: '',
                body: '',
                course_id: '',
                parent_id: '',
            },
        }
    },
    methods: {
        getCourseUrl() {
            return '/courses/' + this.course.slug;
        },
        createPage() {
            this.page.course_id = this.course.id;
            this.page.body = tinymce.get('body').getContent();

            fetch('/api/page', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': Laravel.csrfToken,
                },
                credentials: 'same-origin',
                body: JSON.stringify(this.page),
            }).then(
                response => {
                    if(response.ok) { /* redirect */
                        window.location.href = this.getCourseUrl(this.course.slug);
                    } else {
                        throw Error([response.status, response.statusText].join(' '));
                    }
                }
            )
            .catch((err)=>console.log(err));
        },
    },
}
</script>
