<template>
    <div class="container">

        <h4>Dashboard</h4><hr>

        <div class="card-deck">
            <div class="card bg-light border-0">
                <a href="/admin/courses" style="text-decoration: none; color: #000;">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <div class="col-md-4 align-self-center text-center">
                                <i class="material-icons" style="font-size: 80px; color: #FFCA28;">school</i><br>
                            </div>
                            <div class="col-md-8 align-self-center text-right">
                                <h6>Courses</h6>
                                <h3>{{ coursesCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div style="height: 10px; background-color: #FFCA28;"></div>
                </a>
            </div>

            <div class="card bg-light border-0">
                <a href="/admin/categories" style="text-decoration: none; color: #000;">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <div class="col-md-4 align-self-center text-center">
                                <i class="material-icons" style="font-size: 80px; color: #FF7043;">label_important</i><br>
                            </div>
                            <div class="col-md-8 align-self-center text-right">
                                <h6>Categories</h6>
                                <h3>{{ categoriesCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div style="height: 10px; background-color: #FF7043;"></div>
                </a>
            </div>
        </div>
        <br>

        <div class="card-deck">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons" style="font-size: 80px; color: #4DB6AC;">people</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <h6>Instructors</h6>
                            <h3>{{ instructorsCount }}</h3>
                        </div>
                    </div>
                </div>

                <div style="height: 10px; background-color: #4DB6AC;"></div>
            </div>

            <div class="card bg-light border-0">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons" style="font-size: 80px; color: #9C5B7B;">local_library</i><br>
                        </div>
                        <div class="col-md-8 align-self-center text-right">
                            <h6>Learners</h6>
                            <h3>{{ learnersCount }}</h3>
                        </div>
                    </div>
                </div>
                <div style="height: 10px; background-color: #9C5B7B;"></div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['coursesCount', 'categoriesCount'],
    data() {
        return {
            instructorsCount: 0,
            learnersCount: 0,
        }
    },
}
</script>