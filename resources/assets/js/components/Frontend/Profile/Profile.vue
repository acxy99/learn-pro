<template>
    <div class="container col-md-6">
        <small class="text-muted">User Profile</small>
        <div class="row">
            <div class="col-md-7 align-self-center">
                <h4 class="m-0">{{ profile.username }}</h4>
            </div>
            <div v-if="userCanEditProfile()" class="col-md-5 align-self-center text-right">
                <a class="btn btn-outline-primary d-inline-flex align-items-center" style="border-radius: 0;" :href="editProfileUrl" role="button">
                    <i class="material-icons mr-1">create</i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
        <hr>

        <div class="d-flex rounded-circle border p-2 m-4 mx-auto" style="width: 180px; height:180px; overflow: hidden;">
            <img class="rounded-circle" :src="profile.picture_path" style="object-fit: cover; max-width: 100%;">
        </div>

        <div class="">
            <small class="text-muted">First Name</small>
            <div class="bg-light p-2 mt-1 mb-2">
                <span v-if="profile.first_name">{{ profile.first_name }}</span>
                <span v-else>&nbsp;</span>
            </div>
        </div>

        <div class="">
            <small class="text-muted">Last Name</small>
            <div class="bg-light p-2 mt-1 mb-2">
                <span v-if="profile.last_name">{{ profile.last_name }}</span>
                <span v-else>&nbsp;</span>
            </div>
        </div>

        <div class="">
            <small class="text-muted">Gender</small>
            <div class="bg-light p-2 mt-1 mb-2">
                <span v-if="profile.gender">{{ getGenderTitle(profile.gender) }}</span>
                <span v-else>&nbsp;</span>
            </div>
        </div>

        <div class="">
            <small class="text-muted">Date of Birth</small>
            <div class="bg-light p-2 mt-1 mb-2">
                <span v-if="profile.date_of_birth">{{ profile.date_of_birth }}</span>
                <span v-else>&nbsp;</span>
            </div>
        </div>

        <div class="">
            <small class="text-muted">Phone Number</small>
            <div class="bg-light p-2 mt-1 mb-2">
                <span v-if="profile.phone">{{ profile.phone }}</span>
                <span v-else>&nbsp;</span>
            </div>
        </div>

        <div class="">
            <small class="text-muted">Country</small>
            <div class="bg-light p-2 mt-1 mb-2">
                <span v-if="profile.country">{{ profile.country }}</span>
                <span v-else>&nbsp;</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['profile'],
    data() {
        return {
            editProfileUrl: '/profiles/' + this.profile.slug + '/edit',
        }
    },
    methods: {
        getGenderTitle(gender) {
            if (gender == 'F') {
                return 'Female';
            } else {
                return 'Male';
            }
        },
        userCanEditProfile() {
            return this.$user &&  (this.$user.role.name == 'admin' || this.$user.id == this.profile.user_id);
        },
    }
}
</script>
