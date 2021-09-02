<template>

<div class=" align-self-center">
    <vsa-list style="vsa-max-width: 100%">
  <!-- Here you can use v-for to loop through items  -->
    <vsa-item>
        <vsa-heading>
            PLA Activities
        </vsa-heading>
    
        <vsa-content >
            <div v-if="!result">
                <p>You haven't participated yet !</p>
            <button  type="button" @click="participatePla()" class="btn btn-success " dusk="save-button">Start</button>  
            </div>
            <div v-else>
            <span>Status:</span>  <span v-if="result.is_pass" style="color: green"> Pass </span><span v-else style="color: red"> Fail </span>
            <p> Obtain Mark : {{result.obtain_mark}}</p>
            <button  type="button" @click="participatePla()" class="btn btn-success " dusk="save-button">Start</button>  
            </div>
        </vsa-content>
    </vsa-item>
</vsa-list>
</div>


</template>


<script>
import {
  VsaList,
  VsaItem,
  VsaHeading,
  VsaContent,
  VsaIcon
} from 'vue-simple-accordion';
import 'vue-simple-accordion/dist/vue-simple-accordion.css';

export default {
    props: ['course','topic','result'],
    components: {
    VsaList,
    VsaItem,
    VsaHeading,
    VsaContent,
    VsaIcon
    },
    data() {
        return {
        }
    },
    mounted(){
        // this.getPlaResult();
      
    },
    created(){
        // this.getPlaResult();
    },
    methods:{
        async getPlaResult(){
            await axios.get('/api/mycourses/'+this.$user.id+'/topic/'+this.topic.id+'/pla/result')
                .then(response => {
                    this.result = response.data.data
                    console.log("Here");
                    console.log(this.result.obtain_mark);
                    
                    })
            console.log(this.result);
        },

        participatePla(){
            window.location.href= '/mycourses/'+this.course.slug+'/topic/'+this.topic.id+'/pla'
        }    
    }
}
</script>



