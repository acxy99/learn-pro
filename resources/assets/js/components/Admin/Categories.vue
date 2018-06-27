<template>
    <div class="container">

        <div class="row mb-2">
            <div class="col-md-9 align-self-center">
                <h4 class="m-0">List of Categories</h4>
            </div>
            <div class="col-md-3 text-right">
                <a class="btn d-inline-flex align-items-center" style="border-radius: 0" :href="createCategoryUrl" role="button">
                    <i class="material-icons mr-1">add_circle</i>
                    <span>Create Category</span>
                </a>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 20%">Title</th>
                    <th style="width: 40%">Description</th>
                    <th style="width: 10%">Image</th>
                    <th style="width: 10%">ID</th>
                    <th style="width: 20%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id" @mouseover="active = category.id">
                    <td style="width: 20%">
                        <a style="text-decoration: none" :href="getManageCategoryUrl(category)">{{ category.title }}</a>
                    </td>
                    <td style="width: 40%">{{ category.description }}</td>
                    <td style="width: 10%">{{ category.image }}</td>
                    <td style="width: 10%">{{ category.id }}</td>
                    <td style="width: 20%">
                        <div v-show="active == category.id">
                            <a class="btn p-1" :href="getViewCategoryUrl(category)" data-toggle="tooltip" data-placement="bottom" title="View">
                                <i class="material-icons">visibility</i>
                            </a>
                            <a class="btn p-1" :href="getEditCategoryUrl(category)" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                <i class="material-icons">create</i>
                            </a>
                            <button class="btn p-1" style="background-color: transparent" @click="deleteCategory(category)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                <i class="material-icons" style="color: red;">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <ul class="pagination mb-5">
            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCategories(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCategories(pagination.next_page_url)">Next</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            createCategoryUrl: '/admin/categories/create',
            categories: [],
            pagination: {},
            active: '',
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories(url) {
            url = url || '/api/admin/categories';

            axios.get(url)
                .then(response => {
                    this.categories = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(error => {
                    console.log(error)
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
        getManageCategoryUrl(category) {
            return '/admin/categories/' + category.slug;
        },
        getViewCategoryUrl(category) {
            return '/categories/' + category.slug;
        },
        getEditCategoryUrl(category) {
            return '/admin/categories/' + category.slug + '/edit';
        },
        deleteCategory(category) {
            if(confirm('Are you sure you want to delete this category?')) {
                axios.delete('/api/admin/categories/' + category.id)
                    .then(response => {
                        this.getCategories();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
}
</script>
