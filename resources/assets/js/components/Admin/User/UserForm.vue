<template>
    <div class="container col-md-6">
        <div class="p-4">
            <h4>{{ title }}</h4><hr>

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

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" v-model="user.password" class="form-control" :class="{'is-invalid': errors['password']}">
                    <div class="invalid-feedback" v-if="errors['password']">{{ errors['password'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="password-confirmation">Confirm Password</label>
                    <input type="password" id="password-confirmation" v-model="user.password_confirmation" class="form-control" :class="{'is-invalid': errors['password_confirmation']}">
                    <div class="invalid-feedback" v-if="errors['password_confirmation']">{{ errors['password_confirmation'][0] }}</div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">{{ submitButtonText }}</button>
                <button type="button" class="btn btn-light btn-block mt-2" @click="cancel()">Cancel</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            title: '',
            submitButtonText: '',
            cancelUrl: '',
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
                this.submitButtonText = 'Update';
                this.user.password = '';
                this.user.password_confirmation = '';
            } else {
                this.title = 'Create User';
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
                    console.log(this.errors);
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
