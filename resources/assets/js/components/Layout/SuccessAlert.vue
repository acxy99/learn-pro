<template>
    <div class="alert alert-success text-center br-0 mb-0" dusk="alert-message">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="font-weight-light">{{ message }}</span>
    </div>
</template>

<script>
export default {
    props: ['message'],
    created() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 4000);
    }
}
</script>
