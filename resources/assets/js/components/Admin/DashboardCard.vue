<template>
    <div class="card border-0">
        <a :href="url" class="anchor-custom" style="color: #000;">
            <div class="card-body bg-light">
                <div class="text-center p-4">
                    <i class="material-icons" style="font-size: 100px;" :style="{ color: color }">{{ icon }}</i><br>
                </div>
                <div class="text-center">
                    <h1 class="font-weight-light">{{ count }}</h1>
                    <h6 class="font-weight-light text-muted">{{ title }}</h6>
                </div>
            </div>
            <div style="height: 10px;" :style="{ backgroundColor: color }"></div>
        </a>
    </div>
</template>

<script>
export default {
    props: ['url', 'color', 'icon', 'title', 'count']
}
</script>
