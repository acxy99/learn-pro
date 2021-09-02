<template>
    <div>
        <div class="jumbotron" :style="jumbotronStyle">
            <div class="p-5">
                <h1 class="text-center" style="text-decoration:overline underline;">  Topic </h1>
                <div class="text-center"><small>{{ course.code }}</small></div>
                <h3 class="text-center">{{ course.title }}</h3>
            </div>
        </div>
            <div class="container col-md-11">
                <h5 class="font-weight-light">Suggested to learn from <b> {{result.learner_type}}</b> topic</h5>
                <input class="form-control br-0 mb-3" style="width: 40%" type="search" placeholder="Search" v-model="searchInput" @keyup="searchInputChanged()">

                <table class="bg-white table table-hover table-bordered">
                    <tbody>
                        <tr v-for="t in topic" :key="t.id" @mouseover="active = t.id" @mouseout="active = ''" style="height: 75px">
                            <td style="width: 40%">
                                <a class="anchor-custom" :href="getTopicUrl(t)">{{ t.title }} ({{t.difficulity}})</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <ul class="pagination m-0" style="justify-content: center">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getTopic(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getTopic(pagination.next_page_url)">Next</a></li>
            </ul>
    
        
    </div>
</template>

<script>
export default {

    props: ['course', 'result'],
    data() {
        return {
            jumbotronStyle: {
                'background-image': 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(' + this.course.image_path + ')',
            },

            topic:[],
            searchInput:'',
            pagination:{}

        }
    },
    mounted(){

    },
        created() {
        this.getTopic();
    },
    methods:{
        searchInputChanged() {
            this.getTopic();
        },
        getTopicUrl(topic) {
            return '/mycourses/' + this.course.slug+'/topic/'+topic.id;
        },
        getTopic(url) {
            url = url || '/api/mycourses/' + this.course.id + '/topic'

            axios.get(url, {
                    params: {
                        searchInput: this.searchInput,
                    }
                })
                .then(response => {
                    this.topic = response.data.data;
                    this.makePagination(response.data.links, response.data.meta);
                })
                .catch(response => {
                    console.log(error);
                })
        },
        makePagination(links, meta) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                prev_page_url: links.prev,
                next_page_url: links.next,
            };
            this.pagination = pagination;
        },


    }
}
</script>

<style>
.jumbotron {
    opacity: 0.8;
    background-size: cover;
    background-position: center;
    height: 100%;
    color: white;
    border-radius: 0;
}
</style>


