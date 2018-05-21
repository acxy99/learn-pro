<template>
    <div class="container mt-3">
        <!--<b-alert show>Default Alert</b-alert>
        <b-alert variant="success" show>Success Alert</b-alert>

        <div class="alert alert-primary" role="alert">
            This is a primary alert—check it out!
        </div>
        <div class="alert alert-secondary" role="alert">
            This is a secondary alert—check it out!
        </div>-->

        <h3>{{ page.title }}</h3><hr />
        <p v-html="page.body"></p>
    </div>
</template>

<script>
    export default {
        props: {
            id: { type: String, required: true }
        },

        data() {
            return {
                page: {
                    id: '',
                    title: '',
                    body: '',
                    course_id: ''
                }
            }
        },

        created() {
            this.fetchPage();
        },

        methods: {
            fetchPage: function() {
                fetch('/api/pages/' + this.id)
                    .then(res => res.json())
                    .then(res => {
                        this.page = res.data;
                    })
                    .catch(err => console.log(err));
            }
        },
    }
</script>