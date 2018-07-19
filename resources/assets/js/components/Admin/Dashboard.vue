<template>
    <div class="container col-md-10 col-lg-8">
        <h4 class="d-inline-flex align-items-center font-weight-light mb-0">
            <i class="material-icons mr-2">dashboard</i>
            <span>Dashboard</span>
        </h4>
        <hr>

        <div class="card-deck mt-4 mb-4">
            <div class="card bg-light border-0">
                <a href="/admin/courses" class="anchor-custom" style="color: #000;">
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
                <a href="/admin/categories" class="anchor-custom" style="color: #000;">
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

        <div class="card-deck">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <div class="row m-0 p-3">
                        <div class="col-md-4 align-self-center text-center">
                            <i class="material-icons" style="font-size: 80px; color: #4DB6AC;">local_library</i><br>
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
                <a href="/admin/users" class="anchor-custom" style="color: #000;">
                    <div class="card-body">
                        <div class="row m-0 p-3">
                            <div class="col-md-4 align-self-center text-center">
                                <i class="material-icons" style="font-size: 80px; color: #9C5B7B;">person</i><br>
                            </div>
                            <div class="col-md-8 align-self-center text-right">
                                <h6>Users</h6>
                                <h3>{{ usersCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div style="height: 10px; background-color: #9C5B7B;"></div>
                </a>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['coursesCount', 'categoriesCount', 'usersCount', 'instructorsCount', 'learnersCount'],
}
</script>