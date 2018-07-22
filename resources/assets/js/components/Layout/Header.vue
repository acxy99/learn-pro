<template>
    <nav class="navbar navbar-expand navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="/">LEARN<b>PRO</b></a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/categories') }" href="/categories">Categories</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/courses') }" href="/courses">Courses</a></li>
            </ul>

            <ul class="navbar-nav mr-2">
                <li class="" v-if="$userIsAdmin() || $userIsInstructor()">
                    <a class="nav-link" :class="{ active: isCurrentPath('/admin') }" href="/admin">Dashboard</a>
                </li>
            </ul>

            <ul v-if="$user" class="navbar-nav">
                <li class="mr-2">
                    <span class="d-flex rounded-circle" style="width: 30px; height:30px; overflow: hidden; display: inline-block">
                        <img :src="$user.profile.picture_path" style="object-fit: cover; max-width: 100%;">
                    </span>
                </li>
                <li class="dropdown align-self-center">
                    <a class="nav-link dropdown-toggle p-0 align-middle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $user.username }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mt-3" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item">Logged in as <strong>{{ $user.username }}</strong></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" :href="viewProfileUrl">View profile</a>
                        <a v-if="!$userIsAdmin()" class="dropdown-item" :href="getMyCoursesUrl()">My courses</a>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item btn btn-link border-0" @click="logout()">Logout</button>
                    </div>
                </li>
                <!-- <li><button class="btn btn-link border-0 nav-link" @click="logout()">Logout</button></li> -->
            </ul>
            <ul v-else class="navbar-nav">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/login') }" href="/login">Login</a></li>
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
        console.log(this.$user);
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
