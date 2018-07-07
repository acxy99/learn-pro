<template>
    <div class="container">

        <div class="row mb-3">
            <div class="col-md-9 align-self-center">
                <h4 class="m-0">Users</h4>
            </div>
            <div class="col-md-3 text-right">
                <a class="btn btn-primary" style="border-radius: 0" :href="createUserUrl" role="button">Create User</a>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 30%">Username</th>
                    <th style="width: 30%">Email</th>
                    <th style="width: 20%">ID</th>
                    <th style="width: 20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" @mouseover="active = user.id" @mouseout="active = ''" style="height: 65px">
                    <td style="width: 30%">{{ user.username }}</td>
                    <td style="width: 30%">{{ user.email }}</td>
                    <td style="width: 20%">{{ user.id }}</td>
                    <td style="width: 20%">
                        <div v-show="active == user.id">
                            <a class="btn p-1" :href="getEditUserUrl(user)" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                <i class="material-icons">create</i>
                            </a>
                            <a class="btn p-1" :href="getProfileUrl(user)" data-toggle="tooltip" data-placement="bottom" title="User profile">
                                <i class="material-icons">account_circle</i>
                            </a>
                            <button class="btn p-1" style="background-color: transparent" @click="deleteUser(user)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                <i class="material-icons" style="color: red;">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <ul class="pagination mb-5">
            <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getUsers(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getUsers(pagination.next_page_url)">Next</a></li>
        </ul>

    </div>
</template>

<script>
export default {
    data() {
        return {
            createUserUrl: '/admin/users/create',
            users: [],
            pagination: {},
            active: '',
        }
    },
    created() {
        this.getUsers();
    },
    methods: {
        getUsers(url) {
            url = url || '/api/admin/users';
            axios.get(url)
                .then(response => {
                    this.users = response.data.data;
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
        getEditUserUrl(user) {
            return '/admin/users/' + user.id + '/edit';
        },
        getProfileUrl(user) {
            return '/profiles/' + user.profile.slug;
        },
        deleteUser(user) {
            if(confirm('Are you sure you want to delete this user?')) {
                axios.delete('/api/admin/users/' + user.id)
                    .then(response => {
                        this.getUsers();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    },
}
</script>

