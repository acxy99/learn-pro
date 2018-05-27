<template>
    <div class="container">
        <h2>Categories</h2><hr>
        <b-button class="mb-3" variant="primary" href="/categories/create">Add New Categories</b-button>

        <div v-if="categories.length">
            <div class="card-columns">
                <div class="card" v-for="category in categories" v-bind:key="category.id">
                    <img class="card-img-top" :src="getImageUrl(category)">
                    <div class="card-body">
                        <h5 class="card-title"><a :href="getCategoryUrl(category)">{{ category.title }}</a></h5>
                        <p class="card-text">{{ category.description }}</p>
                    </div>
                </div>
            </div>
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="fetchCategories(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="fetchCategories(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
        
        <div v-else>No categories to display</div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: [],
                category: {
                    id: '',
                    title: '',
                    description: '',
                    image: '',
                },
                pagination: {},
            }
        },
        created() {
            this.fetchCategories();
        },
        methods: {
            fetchCategories(page_url) {
                let vm = this;
                page_url = page_url || '/api/categories';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.categories = res.data;
                        vm.makePagination(res.links, res.meta);
                    })
                    .catch(err => console.log(err));
            },
            getImageUrl(category) {
                return 'storage/categories/' + category.image;
            },
            getCategoryUrl(category) {
                return '/categories/' + category.id;
            },
            makePagination(links, meta) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    prev_page_url: links.prev,
                    next_page_url: links.next,
                };
                this.pagination = pagination;
            }
        }
    }
</script>