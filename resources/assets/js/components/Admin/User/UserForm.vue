<template>
    <div class="container pt-4 col-lg-6 col-md-8">
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>{{ title }}</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form @submit.prevent="onSubmit">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" v-model="user.username" class="form-control" :class="{'is-invalid': errors['username']}">
                    <div class="invalid-feedback" v-if="errors['username']">{{ errors['username'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" v-model="user.email" class="form-control" :class="{'is-invalid': errors['email']}">
                    <div class="invalid-feedback" v-if="errors['email']">{{ errors['email'][0] }}</div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" v-model="user.password" class="form-control" :class="{'is-invalid': errors['password']}">
                        <div class="invalid-feedback" v-if="errors['password']">{{ errors['password'][0] }}</div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="password-confirmation">Confirm Password</label>
                        <input type="password" id="password-confirmation" v-model="user.password_confirmation" class="form-control" :class="{'is-invalid': errors['password_confirmation']}">
                        <div class="invalid-feedback" v-if="errors['password_confirmation']">{{ errors['password_confirmation'][0] }}</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <multiselect 
                        id="role"
                        v-model="role"
                        deselect-label="This role is selected"
                        track-by="name"
                        label="title"
                        :options="roleOptions"
                        :searchable="true"
                        :allow-empty="false"
                        :disabled="user.id != null">
                    </multiselect>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-form br-0">{{ submitButtonText }}</button>
                    <button type="button" class="btn btn-secondary btn-form br-0" @click="cancel()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect/src/Multiselect.vue';

export default {
    components: { Multiselect },
    props: ['user', 'roles'],
    data() {
        return {
            title: '',
            role: '',
            roleOptions: this.roles,
            submitButtonText: '',
            errors: [],
        }
    },
    created() {
        this.initData();
    },
    methods: {
        initData() {
            if (this.user.id) {
                this.title = 'Update User';
                this.role = this.user.role;
                this.submitButtonText = 'Update';
                this.user.password = '';
                this.user.password_confirmation = '';
            } else {
                this.title = 'Create User';
                this.role = this.roles[0];
                this.submitButtonText = 'Create';
                this.user.username = '';
                this.user.email = '';
                this.user.password = '';
                this.user.password_confirmation = '';
            }
        },
        onSubmit() {
            this.errors = [];

            var formData = new FormData();
            formData.append('username', this.user.username);
            formData.append('email', this.user.email);
            formData.append('password', this.user.password);
            formData.append('password_confirmation', this.user.password_confirmation);
            formData.append('role', this.role.name);

            if (!this.user.id) {
                this.createUser(formData);
            } else {
                this.updateUser(formData);
            }
        },
        createUser(formData) {
            axios.post('/api/admin/users', formData)
                .then(response => {
                    window.location.href = '/admin/users/'
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        updateUser(formData) {
            formData.append('id', this.user.id);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/users/' + this.user.id, formData, {
                _method: 'put',
            })
                .then(response => {
                    window.location.href = '/admin/users/'
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        cancel() {
            window.history.back();
        },
    }
}
</script>
