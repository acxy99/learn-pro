<template>
    <div class="container">
        <h3 class="d-inline-flex align-items-center"><i class="material-icons mr-2" style="font-size: 1.75rem">apps</i>Categories</h3>
        <hr>

        <div v-if="categories.length">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3" v-for="category in categories" v-bind:key="category.id">
                    <div class="card" style="border-radius: 0">
                        <div class="wrapper">
                            <img class="card-img-top img" :src="category.image_path">
                        </div>
                        <div class="card-body">
                            <a :href="getCategoryUrl(category)" style="text-decoration: none">
                                <h5 class="card-title line-clamp">{{ category.title }}</h5>
                            </a>
                            <p class="card-text line-clamp">{{ category.description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCategories(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" v-on:click="getCategories(pagination.next_page_url)">Next</a></li>
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
            pagination: {},
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories(url) {
            url = url || '/api/categories';
            axios.get(url)
                .then(response => {
                    this.categories = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        makePagination(links, meta) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                prev_page_url: links.prev,
                next_page_url: links.next,
            };
            this.pagination = pagination;
        },
        getCategoryUrl(category) {
            return '/categories/' + category.slug;
        },
    }
}
</script>
