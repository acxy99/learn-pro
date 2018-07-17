<template>
    <div class="container">
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">settings</i>
            <span>Manage Categories</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <div class="row mb-3">
                <div class="col-md-9 align-self-center">
                    <input class="form-control" style="border-radius: 0; width: 40%" type="search" placeholder="Search" v-model="searchInput" @keyup="searchInputChanged()">
                </div>
                <div class="col-md-3 text-right">
                    <a class="btn btn-primary" style="border-radius: 0" :href="createCategoryUrl" role="button">Create Category</a>
                </div>
            </div>

            <table class="table table-hover table-bordered bg-white mb-3">
                <thead>
                    <tr>
                        <th style="width: 20%">Title</th>
                        <th style="width: 40%">Description</th>
                        <th style="width: 15%">Image</th>
                        <th style="width: 8%">ID</th>
                        <th style="width: 17%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" :key="category.id" @mouseover="active = category.id" @mouseout="active = ''" style="height: 75px">
                        <td style="width: 20%">
                            <a style="text-decoration: none" :href="getManageCategoryUrl(category)">{{ category.title }}</a>
                        </td>
                        <td style="width: 40%">{{ category.description }}</td>
                        <td style="width: 15%">
                            <div v-if="category.image">
                                <a style="text-decoration: none;" :href="category.image_path">{{ category.image }}</a>
                            </div>
                            <div v-else class="text-muted">none</div>
                        </td>
                        <td style="width: 8%">{{ category.id }}</td>
                        <td style="width: 17%">
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

            <ul class="pagination m-0" style="justify-content: center;">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCategories(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getCategories(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
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
            searchInput: '',
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories(url) {
            url = url || '/api/admin/categories';

            axios.get(url, {
                    params: {
                        searchInput: this.searchInput,
                    }
                })
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
                axios.delete('/admin/categories/' + category.id)
                    .then(response => {
                        this.getCategories();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        searchInputChanged() {
            this.getCategories();
        }
    }
}
</script>
