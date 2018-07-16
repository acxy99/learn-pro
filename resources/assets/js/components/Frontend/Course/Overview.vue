<template>
    <div class="container p-3">
        <h5 class="mb-4">About this course</h5>
        
        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Code</span>
            </div>
            <div class="col-md-9">
                <span>{{ course.code }}</span>
            </div>
        </div>
        <hr>
        
        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Title</span>
            </div>
            <div class="col-md-9">
                <span>{{ course.title }}</span>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Description</span>
            </div>
            <div class="col-md-9">
                <span>{{ course.description }}</span>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Categories</span>
            </div>
            <div class="col-md-9">
                <div v-if="course.categories.length">
                    <a role="button" v-for="category in course.categories" :key="category.id" :href="getCategoryUrl(category)" style="text-decoration: none; color: #000;">
                        <span class="p-2 mr-1" style="background-color: #EEE">{{ category.title }}</span>
                    </a>
                </div>
                <div v-else class="text-muted">none</div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Instructors</span>
            </div>
            <div class="col-md-10">
                <div class="mb-4" v-for="instructor in course.instructors" :key="instructor.key">
                    <div class="d-inline-block align-middle mr-3">
                        <span class="d-flex rounded-circle" style="width: 60px; height:60px; overflow: hidden; display: inline-block">
                            <img :src="instructor.profile.picture_path" style="object-fit: cover; max-width: 100%;">
                        </span>
                    </div>
                    <div class="d-inline-block align-middle">
                        <h6>{{ instructor.username }}</h6>
                        <small>{{ instructor.email }}</small>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
export default {
    props: ['course'],
    methods: {
        getCategoryUrl(category) {
            return '/categories/' + category.slug;
        },
    }
}
</script>
