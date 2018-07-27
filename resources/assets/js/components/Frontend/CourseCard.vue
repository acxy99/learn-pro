<template>
    <div class="card br-0Z">
        <a :href="courseUrl" class="anchor-custom" style="color: #000">
            <div class="wrapper">
                <img class="card-img-top img" :src="course.image_path">
            </div>
            <div class="card-body">
                <small>{{ course.code }}</small>
                <div v-if="homepage">
                    <h6 class="card-title line-clamp-hp">{{ course.title }}</h6>
                    <small class="card-text line-clamp-hp text-muted">{{ course.description }}</small>
                </div>
                <div v-else>
                    <h5 class="card-title line-clamp">{{ course.title }}</h5>
                    <p class="card-text line-clamp text-muted">{{ course.description }}</p>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    props: ['course', 'homepage'],
    data() {
        return {
            courseUrl: '/courses/' + this.course.slug
        }
    }
}
</script>

<style>
.line-clamp {
    display: -webkit-box!important;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 48px;
}

.line-clamp-hp {
    display: -webkit-box!important;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 40px;
}
</style>
