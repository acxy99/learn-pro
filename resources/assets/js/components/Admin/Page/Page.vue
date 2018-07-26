<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="pagesUrl">Pages</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Page Details</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6 align-self-center">
                <h4 class="font-weight-light m-0">{{ page.title }}</h4>
            </div>
            <div class="col-md-6 align-self-center text-right">
                <a class="btn btn-primary br-0" :href="editPageUrl" role="button">Edit Page</a>
                <button class="btn btn-danger br-0" @click="deletePage()">Delete Page</button>
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
            courseUrl: '/admin/courses/' + this.course.slug,
            pagesUrl: '/admin/courses/' + this.course.slug + '/pages',
            editPageUrl: '/admin/courses/' + this.course.slug + '/pages/' + this.page.slug + '/edit',
            indexUrl: '/admin/courses/' + this.course.slug + '/pages',
        }
    },
    methods: {
        deletePage() {
            if(confirm('Are you sure you want to delete this page?')) {
                axios.delete('/admin/pages/' + this.page.id)
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
