<template>
    <div class="container pt-4 col-lg-6 col-md-8">
        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>Update Profile</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form @submit.prevent="onSubmit" id="form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" v-model="profile.slug" class="form-control" disabled>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" v-model="profile.first_name" class="form-control">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" v-model="profile.last_name" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="gender">Gender</label>
                        <multiselect 
                            v-model="gender"
                            label="title"
                            track-by="value"
                            select-label="Click to select"
                            deselect-label="Selected"
                            :options="genderOptions"
                            :searchable="true"
                            :allow-empty="false">
                        </multiselect>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="dob">Date of Birth</label>
                        <date-picker v-model="dob" lang="en" :not-after="new Date()" style="width: 100%"></date-picker>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" id="phone" name="phone" v-model="profile.phone" class="form-control" :class="{'is-invalid': errors['phone']}">
                    <div class="invalid-feedback" v-if="errors['phone']">{{ errors['phone'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <multiselect 
                        id="country"
                        v-model="country"
                        deselect-label="Selected country"
                        :options="countryOptions"
                        :searchable="true"
                        :allow-empty="false">
                    </multiselect>
                </div>

                <div class="form-group">
                    <label for="picture">Picture</label>
                    <input type="file" id="picture" accept="image/*" class="form-control">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-form br-0">Save</button>
                    <button type="button" class="btn btn-secondary btn-form br-0" @click="cancel()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect/src/Multiselect.vue';
import DatePicker from 'vue2-datepicker'
import moment from 'moment'

export default {
    components: { Multiselect, DatePicker },
    props: ['profile', 'countries'],
    data() {
        return {
            gender: '',
            genderOptions: [
                { title: 'Female', value: 'F' },
                { title: 'Male', value: 'M' }
            ],
            country: this.profile.country,
            countryOptions: this.countries,
            dob: this.profile.date_of_birth,
            errors: [],
        }
    },
    created() {
        this.initData();
    },
    methods: {
        initData() {
            if (this.profile.gender) {
                if (this.profile.gender == 'F') {
                    this.gender = { title: 'Female', value: 'F' }
                } else {
                    this.gender = { title: 'Male', value: 'M' }
                }
            }
        },
        onSubmit() {
            var form = document.getElementById('form');
            var formData = new FormData(form);
            formData.append('gender', this.profile.gender ? this.profile.gender : '');
            formData.append('country', this.profile.country ? this.profile.country : '');
            var picture = document.querySelector('#picture').files[0];
            if (picture) formData.append('picture', picture);
            formData.append('_method', 'PUT');

            for (var pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }

            axios.post('/api/profiles/' + this.profile.user_id, formData, {
                _method: 'put',
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(response => {
                    window.location.href = '/profiles/' + this.profile.slug;
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
    },
    watch: {
        gender: function(val) {
            this.profile.gender = val.value
        },
        country: function(val) {
            this.profile.country = val
        },
        dob: function(val) {
            this.profile.date_of_birth = val ? moment(val).format('YYYY-MM-DD') : '';
        }
    }
}
</script>

<style>
.mx-input {
    height: 40px;
    border: 1px solid #E8E8E8;
    box-shadow: none;
}
</style>