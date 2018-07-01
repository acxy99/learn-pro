<template>
    <div class="container">

        <small class="text-muted">Page Details</small>
        <div class="row">
            <div class="col-md-7 align-self-center">
                <h5 class="m-0">{{ page.title }}</h5>
            </div>
            <div class="col-md-5 align-self-center text-right">
                <a class="btn btn-primary" style="border-radius: 0;" :href="editPageUrl" role="button">Edit Page</a>
                <button class="btn btn-danger" style="border-radius: 0;" @click="deletePage()">Delete Page</button>
            </div>
        </div>
        <hr>

        <!-- Page Details -->
        <div class="m-1">
            <div class="row">
                <div class="col">
                    <small class="text-muted">Course Code</small>
                    <p>{{ course.code }}</p>
                </div>
                <div class="col">
                    <small class="text-muted">Course Title</small>
                    <p>{{ course.title }}</p>
                </div>
                <div class="col">
                    <small class="text-muted">Course ID</small>
                    <p>{{ course.id }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <small class="text-muted">Page Title</small>
                    <p>{{ page.title }}</p>
                </div>
                <div class="col">
                    <small class="text-muted">Page ID</small>
                    <p>{{ page.id }}</p>
                </div>
                <div class="col">
                    <small class="text-muted">Parent Page ID</small>
                    <p v-if="page.parent_id">{{ page.parent_id }}</p>
                    <p v-else>None</p>
                </div>
            </div>

            <small class="text-muted">Page Body</small>
            <p v-html="page.body" class="border mt-2 p-4"></p> 
        </div>     

    </div>
</template>

<script>
export default {
    props: ['course', 'page'],
    data() {
        return {
            editPageUrl: '/admin/courses/' + this.course.slug + '/pages/' + this.page.slug + '/edit',
        }
    },
    methods: {
        deletePage() {
            if(confirm('Are you sure you want to delete this page?')) {
                axios.delete('/api/admin/pages/' + this.page.id)
                    .then(response => {
                        window.location.href = '/admin/courses/' + this.course.slug + '/pages';
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    },
}
</script>
