<template>
    <div class="container pt-4 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li v-if="course.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li  class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="leapUrl">LEAP</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">{{ title }}</li>
            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">edit</i>
            <span>{{ title }}</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <form @submit.prevent="onSubmit">

                <div class="row">
                    <div class=" col-md-6 form-group ">
                        <label for="qtype">Question Type</label>
                        <br>
                        <input type="radio" id="mcq" value="mcq" v-model="leap.qtype">
                        <label for="mcq">Multi-Choice Question</label>
                        <br>
                        <input type="radio" id="t/f" value="t/f" v-model="leap.qtype">
                        <label for="t/f">Ture/False Question</label>
                    </div>
                    <div class=" col-md-6 form-group ">
                        <label for="status">Required to answer ? </label>
                        <br>
                        <input type="radio" id="status" value="active" v-model="leap.status">
                        <label for="yes">Yes</label>
                        <br>
                        <input type="radio" id="status" value="inactive" v-model="leap.status">
                        <label for="no">No</label>
                    </div>

                </div>

                <div class=" form-group">
                    <label for="question">Question</label>
                    <textarea id="description" name="description" v-model="leap.question" class="form-control" :class="{'is-invalid': errors['question']}"></textarea>
                    <div class="invalid-feedback" v-if="errors['question']">{{ errors['question'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="options">Options</label>
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Points</th>
                            <th>Option</th>
                            <th/>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(q,index) in aoptions"
                            :key="index"
                            class="option-input option-o"
                        >
                            <td>
                                <input
                                    v-model="q.point"
                                    type="number"
                                    class=" col-lg-6 form-control"
                                />
                            </td>
                            <td>
                                <textarea
                                    v-model="q.option"
                                    class="form-control"
                                    name="options[o]"
                                    cols="100"
                                />
                            </td>
                            <td>
                                <button
                                    v-if="aoptions.length>1"
                                    class="btn btn-danger remove"
                                    @click.prevent="removeOption(index)"
                                >
                                    remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button
                    id="addoption"
                    class="btn btn-secondary"
                    @click.prevent="addMoreOption()"
                >
                    Add More Option
                </button>
                </div>



                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-form br-0" dusk="save-button">Save</button>
                    <button type="button" class="btn btn-secondary btn-form br-0" @click="cancel()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect/src/Multiselect.vue';
// import 'vue-multiselect/dist/vue-multiselect.min.css';

export default {
    components: { Multiselect },
    props: ['course','leap'],
    data() {
        return {
            title: '',
            courseUrl: '/admin/courses/' + this.course.slug,
            leapUrl: '/admin/courses/'+this.course.slug+'/create',
            errors: [],
            cancelUrl: '',
            aoptions: [{point:'',option:'',id: this.getRandomId()}],
        }
    },
    created() {
        if (this.leap.id) {
            this.title = 'Update LEAP Question';            
        } else {
            this.title = 'Create LEAP Question';
        }
    },
    mounted () {
        
        const leapOptions = JSON.parse(JSON.parse(this.leap.options));
        console.log(leapOptions.length);

        if (leapOptions.length) {
            this.aoptions = []
            window.console.log(leapOptions);
            console.log(leapOptions.length);
            leapOptions.map(o => {
                const option = o
                this.aoptions.push(option)
                console.log(option);
            })
        }

    },

    methods: {
        onSubmit() {
            this.errors = [];

            const params = this.leap
            params.options = []
            this.aoptions.map(a => {
                params.options.push(a)
            })

            var formData = new FormData();
            
            formData.append('qtype', this.leap.qtype);
            formData.append('question', this.leap.question);
            formData.append('status', this.leap.status);
            formData.append('options', JSON.stringify(this.leap.options));
            formData.append('course_id', this.course.id);

            if (!this.leap.id) {
                this.createLeapQuestion(formData);
            } else {
                this.updateLeapQuestion(formData);
            }
        },
        createLeapQuestion(formData) {
            axios.post('/api/admin/leap', formData,{
                headers: {
                    'Content-Type': 'application/json',
                }
                })
                .then(response => {
                    window.location.href = '/admin/courses/' + this.course.slug +'/leap';
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        updateLeapQuestion(formData) {
            formData.append('id', this.leap.id);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/leap/' + this.leap.id, formData, {
                _method: 'put',
            })
            .then(response => {
                window.location.href = '/admin/courses/' + this.course.slug +'/leap';
            })
            .catch(error => {
                console.log(error);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        getRandomId () {
            return `${Date.now()}-${parseInt(Math.random() * 1000)}`
        },
        addMoreOption () {
            this.aoptions.push({answer:'',option:'',id:this.getRandomId()})
        },
        removeOption (index) {
            this.aoptions.splice(index, 1)
        },
        customTopicLabel(topic){
            return topic.title;
        },
        cancel() {
            window.history.back();
        },
    },
}
</script>

<style>
.is-danger .multiselect__tags {
    border-color: #dc3545;
}
</style>