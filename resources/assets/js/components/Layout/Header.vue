<template>
    <nav class="navbar navbar-expand navbar-dark bg-dark sticky-top mb-4">
        <a class="navbar-brand" href="/">LEARN<b>PRO</b></a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/admin') }" href="/admin">Admin</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/categories') }" href="/categories">Categories</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/courses') }" href="/courses">Courses</a></li>
            </ul>

            <ul v-if="currentUser" class="navbar-nav">
                <li><button class="btn btn-link border-0 nav-link" @click="logout()">Logout</button></li>
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
    props: ['authUser'],
    data() {
        return {
            currentUser: this.authUser,
            currentPath: this.$router.currentRoute.path,
        }
    },
    created() {
        console.log('current user: ' + this.currentUser);
    },
    methods: {
        isCurrentPath(path) {
            return this.currentPath == path;
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
