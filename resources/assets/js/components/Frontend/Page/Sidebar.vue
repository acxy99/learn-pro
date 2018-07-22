<template>
    <div>
        <sidebar-tree :courseSlug="course.slug" :children="pages" :depth="(-1)" :currentPage="currentPage"></sidebar-tree>
    </div>
</template>

<script>
import SidebarTree from './SidebarTree'

export default {
    components: { SidebarTree },
    props: ['course', 'currentPage'],
    data() {
        return {
            pages: [],
        };
    },
    created() {
        this.getPages();
    },
    methods: {
        getPages() {
            axios.get('/api/courses/' + this.course.id + '/pages')
                .then(response => {
                    this.pages = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
}
</script>
