<template>
    <div
        v-if="!loading"
        class="single-exam exam"
    >
        <section
            v-if="startTime"
            class="exam-bord"
        >
            <div class="card">
                <Question
                    v-for="question in questions"
                    v-show="showQuestionNumber === question.id"
                    :key="question.id"
                    :question="question"
                    :answers="answers"
                    @previous="previousQuestion"
                    @next="nextQuestion"
                    @finish="finishExam"
                />
                
                <div class="card-body">
                    <div class="row mt-5">
                        <div class="col-12">
                            <div>
                                <h5>QUESTIONS</h5>
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
                                    class="btn btn-primary mr-1"
                                    :class="{'answered': hasAnswer(question.id), 'active': showQuestionNumber === question.id}"
                                    @click.prevent="showQuestionNumber = question.id"
                                >
                                    {{ i + 1 }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import Question from './Question.vue'
export default {
    components: {
        Question
    },
    data: () => ({
        loading: false,
        startTime: null,
        exam: {},
        questions: [],
        examRemainingTime: null,
        showQuestionNumber: null,
        answers: [],
        result: null,
        showAnswerdQuestion: false
    }),
    computed: {
    },
    watch: {
        '$route' () {
            this.getExam()
        },
    },
    created () {
        this.getExam()
    },
    mounted () {

    },
    methods: {
        getExam () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.exam
            }

            axios.get(`/api/take-exam/${params.id}`, { params })
                .then(res => {
                    this.exam = res.data.exam
                    this.startTime = res.data.time
                    this.result = res.data.result
                    this.questions = res.data.questions

                    this.loading = false
                    if (this.startTime) {
                        this.start()
                    }
                })
        },

        start () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.exam
            }

            axios.post(`/api/start-exam/${params.id}`, { params })
                .then(res => {
                    this.questions = res.data.questions
                    this.startTime = res.data.time
                    this.showQuestionNumber = res.data.questions[0].id
                    this.answers = res.data.answers
                })
                .finally(() => {
                    this.loading = false
                })
        },
        storeAnswer (ans) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/answer/${this.exam.id}`, ans)
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
        finishExam (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.complete()
                })
        },
        complete () {
            axios.post(`/api/complete-exam/${this.exam.id}`)
                .then(res => {
                    this.result = res.data.result
                    this.startTime = null
                    window.location.reload()
                })
        },
        hasAnswer (id) {
            const answer = this.answers.find(a => a.id === id)
            return answer && typeof answer.answer !== 'undefined'
        }
    }
}
</script>
