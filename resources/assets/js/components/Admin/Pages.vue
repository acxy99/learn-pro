<template>
    <div class="container">

        <small class="text-muted">List of Pages</small>
        <div class="row mb-3">
            <div class="col-md-9 align-self-center">
                <h4 class="m-0">{{ course.code }} {{ course.title }}</h4>
            </div>
            <div class="col-md-3 text-right">
                <a class="btn btn-primary" style="border-radius: 0" :href="createPageUrl" role="button">Create Page</a>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50%">Title</th>
                    <th style="width: 15%">ID</th>
                    <th style="width: 15%">Parent ID</th>
                    <th style="width: 20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="page in pages" :key="page.id" @mouseover="active = page.id">
                    <td style="width: 50%">
                        <a style="text-decoration: none" :href="getManagePageUrl(page)">{{ page.title }}</a>
                    </td>
                    <td style="width: 15%">{{ page.id }}</td>
                    <td style="width: 15%">{{ page.parent_id }}</td>
                    <td style="width: 20%">
                        <div v-show="active == page.id">
                            <a class="btn p-1" :href="getViewPageUrl(page)">
                                <i class="material-icons" >visibility</i>
                            </a>
                            <a class="btn p-1" :href="getEditPageUrl(page)">
                                <i class="material-icons">create</i>
                            </a>
                            <button class="btn p-1" style="background-color: transparent" @click="deletePage(page)">
                                <i class="material-icons" style="color: red;">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <ul class="pagination mb-5">
            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getPages(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getPages(pagination.next_page_url)">Next</a></li>
        </ul>

    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            active: '',
            createPageUrl: '/admin/courses/' + this.course.slug + '/pages/create',
            pages: [],
            pagination: {},
        }
    },
    created() {
        this.getPages();
    },
    methods: {
        getPages(url) {
            url = url || '/api/admin/courses/' + this.course.id + '/pages'

            axios.get(url)
                .then(response => {
                    this.pages = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(response => {
                    console.log(error);
                })
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
        getManagePageUrl(page) {
            return '/admin/courses/' + this.course.slug + '/pages/' + page.slug;
        },
        getViewPageUrl(page) {
            return '/courses/' + this.course.slug + '/pages/' + page.slug;
        },
        getEditPageUrl(page) {
            return '/admin/courses/' + this.course.slug + '/pages/' + page.slug + '/edit';
        },
        deletePage(page) {
            if(confirm('Are you sure you want to delete this page?')) {
                axios.delete('/api/admin/pages/' + page.id)
                    .then(response => {
                        this.getPages();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    },
}
</script>
