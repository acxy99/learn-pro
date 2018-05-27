<template>
    <b-container>
        <h3>{{ category.title }}</h3>
        <p>{{ category.description }}</p>
        <hr>

        <div v-if="category.courses.length">
            <!-- do something -->
        </div>
        <div v-else>No courses to display</div>
    </b-container>
</template>

<script>
    export default {
        props: {
            id: { type: String, required: true }
        },

        data() {
            return {
                category: {
                    id: '',
                    title: '',
                    description: '',
                    courses: [],
                }
            }
        },

        created() {
            this.fetchCategory();
        },

        methods: {
            fetchCategory(page_url) {
                page_url = page_url || ('/api/categories/' + this.id);
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.category = res.data;
                    })
                    .catch(err => console.log(err));
            }
        }
    }
</script>