<template>
    <div class="container pt-4 ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li v-if="course.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li  class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="topicUrl">Topic</a></li>
                <li v-if="topic.id" class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="topicViewUrl">{{topic.id}}</a></li>
                <li  class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="plaUrl">PLA</a></li>
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
                        <input type="radio" id="mcq" value="mcq" v-model="pla.qtype">
                        <label for="mcq">Multi-Choice Question</label>
                        <br>
                        <input type="radio" id="t/f" value="t/f" v-model="pla.qtype">
                        <label for="t/f">Ture/False Question</label>
                    </div>
                    <div class=" col-md-6 form-group ">
                        <label for="status">Required to answer ? </label>
                        <br>
                        <input type="radio" id="status" value="active" v-model="pla.status">
                        <label for="yes">Yes</label>
                        <br>
                        <input type="radio" id="status" value="inactive" v-model="pla.status">
                        <label for="no">No</label>
                    </div>

                </div>
                <div class="row">
                        <div class="col-md-3 form-group">
                        <label for="custom_index">Mark</label>
                        <input type="number" id="mark" name="mark" v-model="pla.mark" class="form-control"  :class="{'is-invalid': errors['mark']}" maxlength="100">
                        <div class="invalid-feedback" v-if="errors['mark']">{{ errors['mark'][0] }}</div>
                    </div>
                </div>

                <div class=" form-group">
                    <label for="question">Question</label>
                    <textarea id="description" name="description" v-model="pla.question" class="form-control" :class="{'is-invalid': errors['question']}"></textarea>
                    <div class="invalid-feedback" v-if="errors['question']">{{ errors['question'][0] }}</div>
                </div>

                <div class="form-group">
                    <label for="options">Options</label>
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Answer</th>
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
                                    v-model="q.answer"
                                    type="checkbox"
                                />
                            </td>
                            <td>
                                <textarea
                                    v-model="q.option"
                                    class="form-control"
                                    name="options[o]"
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
    props: ['course','pla','topic'],
    data() {
        return {
            title: '',
            courseUrl: '/admin/courses/' + this.course.slug,
            plaUrl: '/admin/courses/'+this.course.slug+'/topic/'+this.topic.id+'/pla',
            topicUrl:'/admin/courses/'+this.course.slug+'/topic',
            topicViewUrl:'/admin/courses/'+this.course.slug+'/topic/'+this.topic.id,
            errors: [],
            cancelUrl: '',
            aoptions: [{answer:'',option:'',id: this.getRandomId()}],
        }
    },
    created() {
        if (this.pla.id) {
            this.title = 'Update PLA Question';            
        } else {
            this.title = 'Create PLA Question';
        }
    },
    mounted () {

        const plaOptions = JSON.parse(JSON.parse(this.pla.options));
        console.log(plaOptions.length);
        if (plaOptions.length) {
            this.aoptions = []
            window.console.log(plaOptions);
            console.log(plaOptions.length);
            plaOptions.map(o => {
                const option = o
                option.answer = this.pla.answers.indexOf(o.id) !== -1
                this.aoptions.push(option)
                console.log(option);
            })
        }

    },
    methods: {
        onSubmit() {
            this.errors = [];

            const params = this.pla
            params.answers = []
            params.options = []
            this.aoptions.map(a => {
                if (a.answer) {
                    params.answers.push(a.id)
                }
                delete a.answer
                params.options.push(a)
            })

            var formData = new FormData();
            
            formData.append('qtype', this.pla.qtype);
            formData.append('question', this.pla.question);
            formData.append('mark', this.pla.mark);
            formData.append('status', this.pla.status);
            formData.append('options', JSON.stringify(this.pla.options));
            formData.append('answers', this.pla.answers);
            formData.append('topic_id', this.topic.id);
            formData.append('course_id', this.course.id);

            if (!this.pla.id) {
                this.createPlaQuestion(formData);
            } else {
                this.updatePlaQuestion(formData);
            }
        },
        createPlaQuestion(formData) {
            axios.post('/api/admin/pla', formData,{
                headers: {
                    'Content-Type': 'application/json',
                }
                })
                .then(response => {
                    window.location.href = '/admin/courses/' + this.course.slug +'/topic/'+this.topic.id +'/pla';
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        updatePlaQuestion(formData) {
            formData.append('id', this.pla.id);
            formData.append('_method', 'PUT');

            axios.post('/api/admin/pla/' + this.pla.id, formData, {
                _method: 'put',
            })
            .then(response => {
                window.location.href = '/admin/courses/' + this.course.slug +'/topic/'+this.topic.id +'/pla';
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