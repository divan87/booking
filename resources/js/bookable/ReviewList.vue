<template>
    <div style="padding: 1.25rem">
        <div v-if="loading">Data is loading....</div>
        <div v-else> 
            <!-- <star-rating :rating="4.4"></star-rating>  -->
            <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">Review List</h6>
            <div class="border-bottom d-none d-md-block" v-for="(review, index) in reviews" :key="'review ' + index">
                <div class="row pt-4">
                    <div class="col-md-6">Name Review</div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <!-- <star-rating :rating="review.rating" class="fa-lg"></star-rating> -->
                        <star-rating :value="review.rating" class="fa-lg"></star-rating>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ review.created_at | fromNow }}</div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12">
                        {{ review.content }}
                    </div>
                </div>
            </div> 
        </div>
    </div>
</template>

<script>
//import moment from 'moment'; //local register. To register global - see app.js

export default {
    props: {
        bookableId: String
    },
    data() {
        return {
            loading: false,
            reviews: null,
        }
    },
    created () {
        this.loading = true;
        axios.get(`/api/bookables/${this.bookableId}/reviews`)
        .then(response => this.reviews = response.data.data)
        .then(() => (this.loading = false));
    },
    //local register filter
    // filters: { 
    //     fromNow(value) {
    //         return moment(value).fromNow();
    //     },
    // }
}
</script>