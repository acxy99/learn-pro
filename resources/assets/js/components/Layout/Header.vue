<template>
    <nav class="navbar navbar-expand navbar-dark bg-dark sticky-top mb-5">
        <a class="navbar-brand" href="/">LEARN<b>PRO</b></a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/admin') }" href="/admin">Admin</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/categories') }" href="/categories">Categories</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/courses') }" href="/courses">Courses</a></li>
            </ul>

            <ul class="navbar-nav">
                <li><a class="nav-link" :class="{ active: isCurrentPath('/login') }" href="/login">Login</a></li>
                <li><a class="nav-link" :class="{ active: isCurrentPath('/register') }" href="/register">Register</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            currentPath: this.$router.currentRoute.path
        }
    },
    methods: {
        isCurrentPath(path) {
            return this.currentPath == path;
        }
    }
}
</script>
