<template>
    <div class="container">
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">settings</i>
            <span>Manage Users</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <div class="row mb-3">
                <div class="col-md-9 align-self-center">
                    <input class="form-control" style="border-radius: 0; width: 40%" type="search" placeholder="Search by username" v-model="searchInput" @keyup="searchInputChanged()">
                </div>
                <div class="col-md-3 text-right">
                    <a class="btn btn-primary" style="border-radius: 0" :href="createUserUrl" role="button">Create User</a>
                </div>
            </div>

            <table class="bg-white table table-hover table-bordered mb-3">
                <thead>
                    <tr>
                        <th style="width: 20%">Username</th>
                        <th style="width: 20%">Role</th>
                        <th style="width: 30%">Email</th>
                        <th style="width: 10%">ID</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" @mouseover="active = user.id" @mouseout="active = ''" style="height: 65px">
                        <td style="width: 20%">{{ user.username }}</td>
                        <td style="width: 20%">{{ user.role.name }}</td>
                        <td style="width: 30%">{{ user.email }}</td>
                        <td style="width: 10%">{{ user.id }}</td>
                        <td style="width: 20%">
                            <div v-show="active == user.id">
                                <a class="btn p-1" :href="getEditUserUrl(user)" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                    <i class="material-icons">create</i>
                                </a>
                                <a class="btn p-1" :href="getProfileUrl(user)" data-toggle="tooltip" data-placement="bottom" title="User profile">
                                    <i class="material-icons">account_circle</i>
                                </a>
                                <button v-if="user.id != $user.id" class="btn p-1" style="background-color: transparent" @click="deleteUser(user)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <i class="material-icons" style="color: red;">delete</i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination m-0" style="justify-content: center;">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getUsers(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getUsers(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
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
            searchInput: '',
        }
    },
    created() {
        this.getUsers();
    },
    methods: {
        getUsers(url) {
            url = url || '/api/admin/users';
            axios.get(url, {
                    params: { searchInput: this.searchInput }
                })
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
                axios.delete('/admin/users/' + user.id)
                    .then(response => {
                        this.getUsers();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        searchInputChanged() {
            this.getUsers();
        }
    },
}
</script>

