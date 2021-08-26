<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Topic</li>
            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2">settings</i>
            <span>Manage Topic</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <div class="row mb-3">
                <div class="col-md-9 align-self-center">
                    <input class="form-control br-0" style="width: 70%" type="search" placeholder="Search by title , difficulity , num ques to ans , passing mark" v-model="searchInput" @keyup="searchInputChanged()">
                </div>
                <div class="col-md-3 text-right">
                    <a class="btn btn-primary btn-form br-0" :href="createTopicUrl" role="button" dusk="create-page-button">Create Topic</a>
                </div>
            </div>

            <table class="bg-white table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10%">NO.</th>
                        <th style="width: 35%">Title</th>
                        <th style="width: 10%">Difficulity</th>
                        <th style="width: 15%">Num Ques to Answer</th>
                        <th style="width: 10%">Passing Mark</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="t in topic" :key="t.id" @mouseover="active = t.id" @mouseout="active = ''" style="height: 75px">
                            <td style="width: 10%">{{t.custom_index}}</td>
                            <td style="width: 40%">
                                <a class="anchor-custom" :href="getManageTopicUrl(t)">{{ t.title }}</a>
                            </td>
                            <td style="width: 30%">{{t.difficulity}}</td>
                            <td style="width: 30%">{{t.num_ques}}</td>
                            <td style="width: 30%">{{t.passing_mark}}</td>
                            <td style="width: 20%">
                                <div v-show="active == t.id">
                                    <a class="btn p-1" :href="getEditTopicUrl(t)">
                                        <i class="material-icons">create</i>
                                    </a>
                                    <button class="btn p-1" style="background-color: transparent" @click="deleteTopic(t)" >
                                        <i class="material-icons" style="color: red;">delete</i>
                                    </button>
                                </div>
                            </td>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination m-0" style="justify-content: center">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getTopic(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getTopic(pagination.next_page_url)">Next</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course'],
    data() {
        return {
            courseUrl: '/admin/courses/' + this.course.slug,
            active: '',
            createTopicUrl: '/admin/courses/' + this.course.slug + '/topic/create',
            topic: [],
            pagination: {},
            searchInput: '',
            
        }
    },
    created() {
        this.getTopic();
    },
    methods: {
        getTopic(url) {
            url = url || '/api/admin/courses/' + this.course.id + '/topic'

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

        getManageTopicUrl(topic) {
            return '/admin/courses/' + this.course.slug+'/topic/'+topic.id;
        },
        getEditTopicUrl(topic) {
            return '/admin/courses/' + this.course.slug + '/topic/' + topic.id + '/edit';
        },
        deleteTopic(topic) {
            if(confirm('Are you sure you want to delete this topic?')) {
                axios.delete('/admin/topic/' + topic.id)
                    .then(response => {
                        this.getTopic();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        searchInputChanged() {
            this.getTopic();
        }
    },
}
</script>
