<template>
  <div class="row">
    <div
      :class="[{'col-md-4': loading || !alreadyReviewed}, {'d-none': !loading && alreadyReviewed}]"
    >
      <div class="card">
        <div class="card-body">
          <div v-if="loading">Loading...</div>
          <div v-if="hasBooking">
            <p>
              Stayed at
              <router-link :to="{name: 'Bookable', params: {id: booking.bookable.bookable_id}}">{{booking.bookable.title}}</router-link>
            </p>
            <p>From {{ booking.from}} to {{ booking.to}} </p>
          </div>
        </div>
      </div>
    </div>
    <div
      :class="[{'col-md-8': loading || !alreadyReviewed},{'col-md-12': !loading && alreadyReviewed}]"
    >
      <div v-if="loading">Loading data</div>
      <div v-else>
        <div v-if="alreadyReviewed">
          <h3>You already reviewed this booking!</h3>
        </div>
        <div v-else>
          <div class="form-group">
            <label class="text-muted">Select star rating</label>
            <!-- <star-rating :rating="1" class="fa-3x" @rating-changed="onRatingChanged"></star-rating> -->
            <!-- <star-rating :rating="review.rating" class="fa-3x" @rating-changed="review.rating = $event"></star-rating> -->
            <star-rating v-model="review.rating" class="fa-3x"></star-rating>
          </div>
          <div class="form-group">
            <label for="content" class="text-muted">Describe your experience</label>
            <textarea
              name="content"
              coils="30"
              rows="10"
              class="form-control"
              v-model="review.content"
            ></textarea>
          </div>
          <button class="btn btn-lg btn-primary btn-block">Submit</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      review: {
        rating: 5,
        content: null
      },
      existingReview: null,
      loading: false,
      booking: null
    };
  },
  // methods: {
  //     onRatingChanged(rating) {
  //         console.log(rating);
  //     },
  // },
  created() {
    this.loading = true;
    axios
      .get(`/api/reviews/${this.$route.params.id}`)
      .then(response => (this.existingReview = response.data.data))
      .catch(err => {
        if (
          err.response &&
          err.response.status &&
          404 === err.response.status
        ) {
          return axios
            .get(`/api/booking-by-review/${this.$route.params.id}`)
            .then(response => {
              this.booking = response.data.data;
            });
        }
      })
      .then(response => {
        console.log(response);
        this.loading = false;
      });
  },
  computed: {
    alreadyReviewed() {
      return this.hasReview || !this.booking;
    },
    hasReview() {
      return this.existingReview !== null;
    },
    hasBooking() {
      return this.booking !== null;
    }
  }
};
</script>