<template>
    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" href="/admin/courses">Courses</a></li>
                <li class="breadcrumb-item d-inline-flex align-self-center"><a class="anchor-custom" :href="courseUrl">{{ course.code }}</a></li>
                <li class="breadcrumb-item active d-inline-flex align-self-center" aria-current="page">Leap</li>

            </ol>
        </nav>

        <h4 class="d-inline-flex align-items-center font-weight-light mb-3">
            <i class="material-icons mr-2"><a href="/admin/courses" style="color:black">settings</a></i>
            <span>Manage LEAP</span>
        </h4>

        <div class="bg-light p-3 mb-5">
            <div class="row mb-3">
                <div class="col-md-9 align-self-center">
                    <input class="form-control br-0" style="width: 40%" type="search" placeholder="Search by question,status,type" v-model="searchInput" @keyup="searchInputChanged()">
                </div>
                <div class="col-md-3 text-right">
                    <a class="btn btn-primary btn-form br-0" :href="createQuestionUrl" role="button" dusk="upload-files-button">Create Question</a>
                </div>
            </div>

            <div style="overflow-x:auto">
                <table class="bg-white table table-hover table-bordered mb-3">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 50%">Question</th>
                            <th style="width: 20%">Question Type</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="l in leap" :key="l.id" @mouseover="active = l.id" @mouseout="active = ''" style="height: 75px">
                            <td style="width: 5%">{{l.id}}</td>
                            <td style="width: 50%">{{l.question}}</td>
                            <td style="width: 20%">{{l.qtype}}</td>
                            <td style="width: 10%">{{l.status}}</td>
                            <td style="width: 15%">
                                <div v-show="active == l.id">
                                    <a class="btn p-1" :href="getEditLeapUrl(l)">
                                        <i class="material-icons">create</i>
                                    </a>
                                    <button class="btn p-1" style="background-color: transparent" @click="deleteLeap(l)" >
                                        <i class="material-icons" style="color: red;">delete</i>
                                    </button>
                                </div>
                            </td>
                            </tr>
                    </tbody>
                </table>
                <ul class="pagination m-0" style="justify-content: center">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="getLeap(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="getLeap(pagination.next_page_url)">Next</a></li>
            </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['course',],
    data() {
        return {
            active: '',
            searchInput: '',
            courseUrl: '/admin/courses/' + this.course.slug,
            createQuestionUrl:'/admin/courses/'+this.course.slug +'/leap/create',
            leap:[],
            pagination: {},
        };
    },
    created() {
        this.getLeap();
    },
    methods: {
        getLeap(url) {
            url = url || '/api/admin/courses/'+this.course.id+'/leap'

            

            axios.get(url, {
                    params: {
                        searchInput: this.searchInput,
                    }
                })
                .then(response => {
                    this.leap = response.data.data;
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
        getEditLeapUrl(leap) {
            return '/admin/courses/' + this.course.slug + '/leap/' + leap.id + '/edit';
        },
        deleteLeap(leap) {
            if(confirm('Are you sure you want to delete this question?')) {
                axios.delete('/admin/leap/' + leap.id)
                    .then(response => {
                        this.getLeap();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        searchInputChanged() {
            this.getLeap();
        }
    },
}
</script>