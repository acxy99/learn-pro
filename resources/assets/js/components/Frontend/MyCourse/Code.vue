<template>

<div class=" align-self-center">
    <vsa-list style="vsa-max-width: 100%">
  <!-- Here you can use v-for to loop through items  -->
    <vsa-item>
        <vsa-heading>
            PLA Activities
        </vsa-heading>
    
        <vsa-content >
            <div v-if="result.length ===0">
                <p>You haven't participate yet !</p>
            <button  type="button" @click="participatePla()" class="btn btn-success " dusk="save-button">Start</button>  
            </div>
            <div v-else>
            <p> Obtain Mark : {{obtainMark}}</p>
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
    props: ['course','topic'],
    components: {
    VsaList,
    VsaItem,
    VsaHeading,
    VsaContent,
    VsaIcon
    },
    data() {
        return {
            result:[],
            obtainMark:'',
            status:''
        }
    },
    mounted(){
        
      
    },
    created() {
        this.getPlaResult();
        console.log(this.obtainMark);
        
    },
    methods:{
        getPlaResult(){
            axios.get('/api/mycourses/'+this.$user.id+'/topic/'+this.topic.id+'/pla/result')
                .then(response => {
                    this.result = response.data.data
                    // console.log(this.result.obtain_mark);
                    })
             console.log(this.result.obtian_mark);
           
        },

        participatePla(){
            window.location.href= '/mycourses/'+this.course.slug+'/topic/'+this.topic.id+'/pla'
        }    
    }
}
</script>



