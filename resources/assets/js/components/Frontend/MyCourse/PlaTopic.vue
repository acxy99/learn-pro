<template>
<div class="container pt-4">
        <div class="row">
            <div class="col-md-8 align-self-end">
                <h3 class="align-self-end font-weight-normal m-0">
                    <span>PLA Activities</span>
                </h3>
            </div>
            <div class="col-md-4 align-self-end">
                <h6 class=" align-self-end font-weight-light m-0">
                    <span  v-bind:data-identity="topic.passing_mark" >Total Mark: {{topic.passing_mark}} </span>
                </h6>
            </div>
        </div>
        <hr>
        <div class="row mt-4">
                        <div class="col-md-10">
                            <div>
                                <h5 class="font-weight-light">Questions</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <div
                                class="btn-toolbar"
                                role="toolbar"
                                aria-label="Toolbar with button groups"
                            >
                                <button
                                    v-for="(question, i ) in questions"
                                    :key="question.id"
                                    type="button"
                                    class="btn btn-link mr-4"
                                    :class="{'answered': hasAnswer(question.id), 'active': showQuestionNumber === question.id}"
                                    @click.prevent="showQuestionNumber = question.id"
                                >
                                    {{ i + 1 }}
                                </button>
                            </div>
                        </div>
                    </div>
                <Question
                    v-for="question in questions"
                    v-show="showQuestionNumber === question.id"
                    :key="question.id"
                    :question="question"
                    :answers="answers"
                    @previous="previousQuestion"
                    @next="nextQuestion"
                    @finish="finishPla"
                />
                <hr>
                    

    </div>
                
</template>
<script>
import Question from './Question.vue'

export default 
{    
    props:['topic','course'],
    components: {
        Question,
    },
    data () {
        
        return {
            questions: [],
            showQuestionNumber: null,
            answers: [],
            result: null,
            showAnswerdQuestion: false
        }
    },
    computed: {
    },
    watch: {

    },
    created () {
        this.getPla();
        console.log(this.questions);
    },
    mounted () {

        console.log(this.topic.id);
        console.log('pla com mounted');
        
    },
    methods: {
        getPla () {
            axios.get('/api/load-pla/'+this.topic.id)
                .then(res => {
                    this.questions = res.data.questions
                })
        },
    
        storeAnswer (ans) {
            return new Promise((resolve, reject) => {
                axios.post('/api/mycourses/'+this.$user.id+'/topic/answer-pla/'+this.topic.id, ans)
                    .then(res => {
                        resolve(res.data)
                    })
                    .catch((error) => {
                        reject(error)
                    })
            })
        },
        nextQuestion (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.answers = res.answers
                    const i = this.questions.findIndex(q => this.showQuestionNumber === q.id)
                    if (i + 1 === this.questions.length) {
                        this.showQuestionNumber = this.questions[0].id
                    } else {
                        this.showQuestionNumber = this.questions[i + 1].id
                    }
                })
        },
        previousQuestion (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.answers = res.answers
                    const i = this.questions.findIndex(q => this.showQuestionNumber === q.id)
                    if (i === 0) {
                        this.showQuestionNumber = this.questions[this.questions.length - 1].id
                    } else {
                        this.showQuestionNumber = this.questions[i - 1].id
                    }
                })
        },
        finishPla (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.complete()
                })
        },
        complete () {
            axios.post('/api/mycourses/'+this.$user.id+'/topic/complete-pla/'+this.topic.id)
                .then(res => {
                    this.result = res.data.result
                    window.location.href= '/mycourses/'+this.course.slug+'/topic/'+this.topic.id+'/pla'
                })
        },
        hasAnswer (id) {
            const answer = this.answers.find(a => a.id === id)
            return answer && typeof answer.answer !== 'undefined'
        }
    }
}
</script>
