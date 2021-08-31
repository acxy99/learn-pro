<template>
    <div class="card-body px-5">
        <div class="row mt-5">
            <div class="col-12">
                <div class="question">
                    <div class="p-5 bg-light text-center text-muted">
                            <h5 class="font-weight-light">{{question.question}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div
                    v-for="option in options"
                    :key="option.id"
                    class="custom-control custom-checkbox"
                >
                    <input
                        :id="option.id"
                        v-model="answer"
                        :value="option.id"
                        type="checkbox"
                        class="custom-control-input"
                    >
                    <label
                        class="custom-control-label"
                        :for="option.id"
                    >{{ option.option }}</label>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="next-button">
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        @click="previous"
                    >
                        Previous
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        @click="next"
                    >
                        Next
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-dark"
                        @click="clearAns"
                    >
                        Clear Answer
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        @click="finish"
                    >
                        Finish
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        question: {
            type: Object,
            required: true
        },
        answers: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        answer: [],
        options:[],
        ans:[]
    }),
    mounted () {
        this.options = JSON.parse(JSON.parse(this.question.options));
        this.ans =JSON.parse(this.question.answers);
        this.answer = this.answers.find(a => a.id === this.question.id)|| []
        console.log(this.answer);
    },
    methods: {
        clearAns () {
            this.answer = []
        },
        previous () {
            const ans = {}
            ans[this.question.id] = this.answer
            this.$emit('previous', ans)
        },
        next () {
            const ans = {}
            ans[this.question.id] = this.answer
            this.$emit('next', ans)
        },
        finish () {
            const ans = {}
            ans[this.question.id] = this.answer
            this.$emit('finish', ans)
        }

    }
}
</script>
