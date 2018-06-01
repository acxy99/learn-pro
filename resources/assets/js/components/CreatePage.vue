<template>
    <div class="container">
        <small>
            <a :href="getCourseUrl(course.code)" style="text-decoration: none">{{ course.code }} {{ course.title }}</a>
        </small>
        <h3>Create Page</h3><hr>

        <form @submit.prevent="createPage">
            <div class="form-group">
                <label for="course_id">Course ID</label>
                <input type="text" class="form-control" id="course_id" v-model="page.course_id" :placeholder="course.id" readonly>
            </div>

            <div class="form-group">
                <label for="parent_id">Parent ID</label>
                <select class="custom-select" v-model="page.parent_id">
                    <option v-for="parent in parents" v-bind:key="parent.id" :value="parent.id">{{ parent.title }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" v-model="page.title">
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <!-- <textarea class="form-control" id="body"></textarea> -->
                <tinymce 
                    api-key="jvygsti8vfl669gfq2jxa3h5qr00kuj22sgdd3tfhibp14yj" 
                    :init="{
                        height: '300',
                        plugins: 'codesample, link'
                    }"
                    v-model="page.body">
                </tinymce>
                <!-- <editor api-key='jvygsti8vfl669gfq2jxa3h5qr00kuj22sgdd3tfhibp14yj' cloud-channel='dev' :init="{/* your settings */}"></editor> -->
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <!-- parent, title, body, submit button -->
        </form>
    </div>
</template>

<script>
import Tinymce from '@tinymce/tinymce-vue';

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
    components: {
        'tinymce': Tinymce,
    },
    created() {
        console.log(this.course);
        console.log(this.parents);
    },
    methods: {
        createPage() {
            fetch('/api/pages', {
                method: 'put',
                body: JSON.stringify(this.page),
                headers: {
                    'content-type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .catch(err => console.log(err));
        },
        getCourseUrl(course_code) {
            return '/courses/' + course_code;
        }
    },
}
</script>
