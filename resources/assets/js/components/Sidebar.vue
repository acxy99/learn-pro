<template>
    <div>
        <h5>Contents</h5><hr>
        <ul class="list-unstyled">
            <li v-for="page in pages" :key="page.id" class="mb-3">
                <a :href="getPageUrl(page)" :style="getStyle(page)">{{ page.title }}</a>
                
                <ul v-if="hasChildren(page)" class="list-unstyled pl-3">
                    <li v-for="child in page.children" v-bind:key="child.id">
                        <a :href="getChildUrl(child)" :style="getStyle(child)">{{ child.title }}</a>
                    </li>
                </ul>
            </li>
        </ul>
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
