<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
                        <h2>
                            {{ bookable.title }}
                        </h2>
                        <hr />
                        <article>{{bookable.description}}</article>
                    </div>
                    <div v-else>Loading data...</div>
                </div>
            </div>
            <review-list :bookable-id="this.$route.params.id"></review-list>  
        </div>
        <div class="col-md-4 pb-4">
            <availaibility :bookable-id="this.$route.params.id"></availaibility>
        </div>
    </div>
</template>

<script>
import Availaibility from './Availaibility';
import ReviewList from './ReviewList';

export default {
    data (){
        return {
        bookable:null,
        loading: false,
        };
    },
    created() {
        this.loading = true;
        const ide = this.$route.params.id;
        const request = axios
        .get(`/api/bookables/${ide}`).then(response => {
        this.bookable = response.data;
        this.loading = false;
        })
        .catch(console.log("Failing"))
        ;
    },
    components:{
        Availaibility: Availaibility,
        ReviewList : ReviewList,
    }
}
</script>