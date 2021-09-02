<template>
<div class="container pt-4">
        <div class="row">
            <div class="col-md-8 align-self-end">
                <h3 class="align-self-end font-weight-normal m-0">
                    <span>Leap Attachment</span>
                </h3>
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
                    @finish="finishLeap"
                />
                <hr>
                    

    </div>
                
</template>
<script>
import Question from './Question.vue'

export default 
{    
    props:['course'],
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
        this.getLeap();
    },
    mounted () {
        
    },
    methods: {
        getLeap () {
            axios.get('/api/load-leap/'+this.course.slug)
                .then(res => {
                    this.questions = res.data.questions
                })
        },
        // startPla () {
        //     const params =this.topic
        //     axios.post('/api/mycourses/'+this.$user.id+'/topic/answer-pla/'+this.topic.id, { params })
        //         .then(res => {
        //             this.questions = res.data.questions
        //             this.answers = res.data.answers
        //         })
        // },
    
        storeAnswer (ans) {
            return new Promise((resolve, reject) => {
                axios.post('/api/mycourses/'+this.$user.id+'/answer-leap/'+this.course.slug, ans)
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
        finishLeap (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.complete()
                })
        },
        complete () {
            axios.post('/api/mycourses/'+this.$user.id+'/complete-leap/'+this.course.slug)
                .then(res => {
                    this.result = res.data.result
                    window.location.href= '/mycourses/'+this.course.slug+'/topic'
                })
        },
        hasAnswer (id) {
            const answer = this.answers.find(a => a.id === id)
            return answer && typeof answer.answer !== 'undefined'
        }
    }
}
</script>
