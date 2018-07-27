<template>
    <div class="card br-0">
        <a :href="categoryUrl" class="anchor-custom" style="color: #000">
            <div class="wrapper">
                <img class="card-img-top img" :src="category.image_path">
            </div>
            <div class="card-body">
                <div v-if="homepage">
                    <h6 class="card-title line-clamp-hp">{{ category.title }}</h6>
                    <small class="card-text line-clamp-hp text-muted">{{ category.description }}</small>
                </div>
                <div v-else>
                    <h5 class="card-title line-clamp">{{ category.title }}</h5>
                    <p class="card-text line-clamp text-muted">{{ category.description }}</p>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    props: ['category', 'homepage'],
    data() {
        return {
            categoryUrl: '/categories/' + this.category.slug
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
