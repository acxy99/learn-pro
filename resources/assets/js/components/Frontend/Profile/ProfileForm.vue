<template>
    <div class="container col-md-6">
        <h4>Update User Profile</h4><hr>

        <form @submit.prevent="onSubmit" id="form" class="mb-4">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" v-model="profile.username" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" v-model="profile.first_name" class="form-control" :class="{'is-invalid': errors['first_name']}">
                <div class="invalid-feedback" v-if="errors['first_name']">{{ errors['first_name'][0] }}</div>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" v-model="profile.last_name" class="form-control" :class="{'is-invalid': errors['last_name']}">
                <div class="invalid-feedback" v-if="errors['last_name']">{{ errors['last_name'][0] }}</div>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <multiselect 
                    v-model="gender"
                    label="title"
                    track-by="value"
                    deselect-label="Selected gender"
                    :options="genderOptions"
                    :searchable="true"
                    :allow-empty="false">
                </multiselect>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <date-picker v-model="dob" lang="en" :not-after="new Date()" style="display: block"></date-picker>
            </div>

            <div class="form-group">
                <label for="phone">Phone number</label>
                <input type="text" id="phone" name="phone" v-model="profile.phone" class="form-control">
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

            <button type="submit" class="btn btn-primary btn-block mt-4">Save</button>
            <button type="button" class="btn btn-light btn-block mt-2" @click="cancel()">Cancel</button>
        </form>
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
