<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Course Details</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6 col-xl-7 align-self-center">
                <h5 class="m-0">{{ course.code }} {{ course.title }}</h5>
            </div>
            <div class="col-md-6 col-xl-5 align-self-center text-right">
                <a v-if="userCanEditCourse()" class="btn btn-primary br-0" :href="editCourseUrl" role="button" dusk="edit-button">Edit Course</a>
                <button v-if="userCanDeleteCourse()" class="btn btn-danger br-0" @click="deleteCourse()" dusk="delete-button">Delete Course</button>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-1">
                <small class="text-muted">ID</small>
                <p>{{ course.id }}</p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Code</small>
                <p>{{ course.code }}</p>
            </div>
            <div class="col-md-8">
                <small class="text-muted">Title</small>
                <p>{{ course.title }}</p>
            </div>
        </div>

        <small class="text-muted">Description</small>
        <p>{{ course.description }}</p>

        <small class="text-muted">Image</small>
        <p>
            <a role="button" class="border-0 p-0" :href="course.image_path" data-toggle="tooltip" data-placement="bottom" title="View">
                <i class="material-icons align-middle" style="font-size: 1.2em; color: #888;">visibility</i>
            </a>
            <span v-if="course.image">{{ course.image }}</span>
            <span v-else>none</span>
        </p>

        <small class="text-muted">Categories</small>
        <p v-if="course.categories.length" class="mt-2">
            <a role="button" v-for="category in course.categories" :key="category.id" :href="getCategoryUrl(category)" class="anchor-custom" style="color: #000;">
                <span class="p-2 mr-1" style="background-color: #EEE">{{ category.title }}</span>
            </a>
        </p>
        <p v-else>none</p>

        <small class="text-muted">Instructors</small>
        <p v-if="course.instructors.length" class="mt-2">
            <a role="button" v-for="instructor in course.instructors" :key="instructor.id" :href="getInstructorProfileUrl(instructor)" class="anchor-custom" style="color: #000;">
                <span class="p-2 mr-1" style="background-color: #EEE">{{ instructor.username }}</span>
            </a>
        </p>
        <p v-else>none</p>

        <div class="row">
            <div class="col-md-4">
                <small class="text-muted">Created at</small>
                <p>{{ course.created_at }}</p>
            </div>
            <div class="col-md-4">
                <small class="text-muted">Updated at</small>
                <p>{{ course.updated_at }}</p>
            </div>
        </div>
   
        <hr>
    
        <!-- enhancement_v1 -->
        <div class="card-group mb-5">
        
            <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons p-1" style="font-size: 100px; color: #fd8d29;">filter_list</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <p class="m-0" style="font-size: 20;">LEAP</p>
                            <h1>{{ course.leap_count }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light br-0" :href="manageLeapUrl" role="button" dusk="manage-leap-button">Manage LEAP</a>
                </div>
            </div>
            <div class="card bg-light border-0 m-1">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons p-1" style="font-size: 100px; color: #a3fb81;">view_list</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <p class="m-0" style="font-size: 20;">Topics</p>
                            <h1>{{ course.topic_count }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn bg-light br-0" :href="manageTopicUrl" role="button" dusk="manage-topic-button">Manage Topic</a>
                </div>
            </div>
            


        </div>
        <div class = "card-group mb-5">
           

        </div>
    </div>
</template>

<script>
export default {
    props: ['course', 'lastUpdatedPage', 'lastUpdatedFile'],
    data() {
        return {
            indexUrl: '/admin/courses',
            editCourseUrl: '/admin/courses/' + this.course.slug + '/edit',
            manageLeapUrl: '/admin/courses/'+ this.course.slug + '/leap',
        
            manageTopicUrl: '/admin/courses/'+ this.course.slug + '/topic',
        }
    },
    methods: {
        userCanEditCourse() {
            return this.$userIsAdmin() || this.$user.teaching_courses.includes(this.course.id);
        },
        userCanDeleteCourse() {
            return this.$userIsAdmin() || this.course.owner_id == this.$user.id;
        },
        deleteCourse() {
            if(confirm('Are you sure you want to delete this course?')) {
                axios.delete('/admin/courses/' + this.course.id)
                    .then(response => {
                        window.location.href = '/admin/courses';
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getCategoryUrl(category) {
            return '/admin/categories/' + category.slug;
        },
        getInstructorProfileUrl(instructor) {
            return '/profiles/' + instructor.profile.slug;
        },
    },
}
</script>