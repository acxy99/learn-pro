<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top" dusk="navbar">
        <a class="navbar-brand" href="/">LEARN<b>PRO</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/categories') }" href="/categories">Categories</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/courses') }" href="/courses">Courses</a></li>
            </ul>

            <ul class="navbar-nav mr-2">
                <li class="" v-if="$userIsAdmin() || $userIsInstructor()">
                    <a class="nav-link" :class="{ active: isCurrentPath('/admin') }" href="/admin">Dashboard</a>
                </li>
            </ul>

            <ul class="navbar-nav mr-2">
                <li class="" v-if="$userIsLearner()">
                    <a class="nav-link" :class="{ active: isCurrentPath('/') }" href="/">My Courses</a>
                </li>
            </ul>

            <ul v-if="$user" class="navbar-nav">
                <li class="dropdown"> 
                    <a class="nav-link dropdown-toggle p-0 d-flex align-items-center" href="#" style="height: 40px;" dusk="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-inline-flex rounded-circle mr-2" style="width: 30px; height: 30px; overflow: hidden;">
                            <img :src="$user.profile.picture_path" style="object-fit: cover; max-width: 100%;">
                        </span>
                        <span class="mr-2">{{ $user.username }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mt-3" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item">Logged in as <strong>{{ $user.username }}</strong></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" :href="viewProfileUrl">View profile</a>
                        <!-- <a v-if="!$userIsAdmin()" class="dropdown-item" :href="getMyCoursesUrl()">My courses</a> -->
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item btn btn-link border-0" @click="logout()" type="button" dusk="logout-button">Logout</button>
                    </div>
                </li>
            </ul>
            <ul v-else class="navbar-nav">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/login') }" href="/login" dusk="login-button">Login</a></li>
                <!-- <li><a class="nav-link" :class="{ active: isCurrentPath('/register') }" href="/register">Register</a></li> -->
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            currentPath: this.$router.currentRoute.path,
            viewProfileUrl: '',
        }
    },
    created() {
        this.initData();
    },
    methods: {
        initData() {
            this.viewProfileUrl = this.$user ? ('/profiles/' + this.$user.profile.slug) : '#';
        },
        isCurrentPath(path) {
            return this.currentPath == path;
        },
        getMyCoursesUrl() {
            return '#';
        },
        logout() {
            axios.post('/logout')
                .then(response => {
                    window.location.href = '/';
                })
                .catch(error => {
                    console.log(error)
                });
        }
    }
}
</script>
