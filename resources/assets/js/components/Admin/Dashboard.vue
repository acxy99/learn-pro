<template>
    <div class="container pt-4">
        <h4 class="d-inline-flex align-items-center font-weight-light mb-0">
            <i class="material-icons mr-2">dashboard</i>
            <span>Dashboard</span>
        </h4>
        <hr>

        <div class="row mt-4">
            <dashboard-card 
                class="col-md-4 mb-4"
                dusk="course-card"
                :url="course.url" 
                :color="course.color" 
                :icon="course.icon" 
                :title="course.title" 
                :count="course.count"
            ></dashboard-card>
            <dashboard-card 
                class="col-md-4 mb-4"
                dusk="category-card"
                v-if="$userIsAdmin()"
                :url="category.url" 
                :color="category.color" 
                :icon="category.icon" 
                :title="category.title" 
                :count="category.count"
            ></dashboard-card>
            <dashboard-card 
                class="col-md-4 mb-4"
                dusk="user-card"
                v-if="$userIsAdmin()"
                :url="user.url" 
                :color="user.color" 
                :icon="user.icon" 
                :title="user.title" 
                :count="user.count"
            ></dashboard-card>
        </div>
    </div>
</template>

<script>
import DashboardCard from './DashboardCard'

export default {
    components: { DashboardCard },
    props: ['coursesCount', 'categoriesCount', 'usersCount'],
    data() {
        return {
            course: {
                url: '/admin/courses',
                color: '#EB6B56',
                icon: 'school',
                title: 'Courses',
                count: this.coursesCount
            },
            category: {
                url: '/admin/categories',
                color: '#B05F6D',
                icon: 'label_important',
                title: 'Categories',
                count: this.categoriesCount
            },
            user: {
                url: '/admin/users',
                color: '#355C7D',
                icon: 'person',
                title: 'Users',
                count: this.usersCount
            }
        }
    }
}
</script>