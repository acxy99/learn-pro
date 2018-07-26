<template>
    <div class="container col-md-10">
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
            <div class="col-md-10">
                <span>{{ course.title }}</span>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Description</span>
            </div>
            <div class="col-md-10">
                <span>{{ course.description }}</span>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <span class="text-muted">Categories</span>
            </div>
            <div class="col-md-10">
                <div v-if="course.categories.length">
                    <a role="button" v-for="category in course.categories" :key="category.id" :href="getCategoryUrl(category)" class="anchor-custom" style="color: #000;">
                        <div class="d-inline-block p-2 mb-1 mr-1" style="background-color: #EEE">
                            <span>{{ category.title }}</span>
                        </div>
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
                        <a class="anchor-custom" :href="getInstructorProfileUrl(instructor)">
                            <h6 v-if="hasFullName(instructor)">{{ instructor.profile.first_name }} {{ instructor.profile.last_name }}</h6>
                            <h6 v-else>{{ instructor.username }}</h6>
                        </a>
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
        getInstructorProfileUrl(instructor) {
            return '/profiles/' + instructor.profile.slug;
        },
        hasFullName(instructor) {
            return instructor.profile.first_name && instructor.profile.last_name;
        }
    }
}
</script>
