<template>
    <div class="pt-3">
        <h5>Contents</h5><hr>
        <sidebar-tree :courseSlug="course.slug" :children="pages" :depth="(-1)" :currentPage="currentPage"></sidebar-tree>
    </div>
</template>

<script>
export default {
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
        getPageUrl(page) {
            return '/courses/' + this.course.slug + '/pages/' + page.slug;
        },
        hasChildren(page) {
            return page.children.length;
        },
        getChildUrl(child) {
            return '/courses/' + this.course.slug + '/pages/' + child.slug;
        },
        isCurrentPage(page) {
            return page.title == this.currentPage;
        },
        getStyle(page) {
            if (this.isCurrentPage(page)) {
                return {
                    color: '#222',
                    fontWeight: 'bold',
                    disabled: 'disabled',
                    textDecoration: 'none',
                }
            } else {
                return {
                    color: '#333',
                    textDecoration: 'none',
                }
            }
        },
    },
}
</script>
