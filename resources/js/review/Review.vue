<template>
  <div>
    <fatal-error v-if="error"></fatal-error>
    <succsess v-if="succsess">You've left a review, thank you very much</succsess>
    <div class="row" v-if="!succsess && !error">
      <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]">
        <div class="card">
          <div class="card-body">
            <div v-if="loading">Loading...</div>
            <div v-if="hasBooking">
              <p>
                Stayed at
                <router-link
                  :to="{name: 'Bookable', params: {id: booking.bookable.bookable_id}}"
                >{{booking.bookable.title}}</router-link>
              </p>
              <p>From {{ booking.from}} to {{ booking.to}}</p>
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
                :class="[{'is-invalid': errorFor('content')}]"
              ></textarea>
              <v-errors :errors="errorFor('content')"></v-errors>
            </div>
            <button
              class="btn btn-lg btn-primary btn-block"
              @click.prevent="submit"
              :disabled="sending"
            >Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { is404, is422 } from "../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      review: {
        id: null,
        rating: 5,
        content: null
      },
      existingReview: null,
      loading: false,
      booking: null,
      error: false,
      sending: false,
      succsess: false
    };
  },
  // methods: {
  //     onRatingChanged(rating) {
  //         console.log(rating);
  //     },
  // },
  async created() {
    this.review.id = this.$route.params.id;
    this.loading = true;

    try {
      this.existingReview = (
        await axios.get(`/api/reviews/${this.review.id}`)
      ).data.data;
    } catch (err) {
      if (is404(err)) {
        try {
          this.booking = (
            await axios.get(`/api/booking-by-review/${this.review.id}`)
          ).data.data;
        } catch (err) {
          this.error = !is404(err);
        }
      } else {
        this.error = true;
      }
    }

    this.loading = false;

    // axios
    //   .get(`/api/reviews/${this.review.id}`)
    //   .then(response => (this.existingReview = response.data.data))
    //   .catch(err => {
    //     if (is404(err)) {
    //       return axios
    //         .get(`/api/booking-by-review/${this.review.id}`)
    //         .then(response => {
    //           this.booking = response.data.data;
    //         })
    //         .catch(err => {
    //           is404(err) ? {} : (this.error = true);
    //           // if (!is404(err)) {
    //           //     this.error = true;
    //           //   }
    //         });
    //     }
    //     this.error = true;
    //   })
    //   .then(response => {
    //     console.log(response);
    //     this.loading = false;
    //   });
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
    },
    oneColumn() {
      return !this.loading && this.alreadyReviewed;
    },
    twoColumns() {
      return this.loading || !this.alreadyReviewed;
    }
  },
  methods: {
    submit() {
      this.errors = null;
      this.sending = true;
      this.succsess = false;
      axios
        .post(`/api/reviews`, this.review)
        .then(response => {
          this.succsess = 201 === response.status; //succsess будет true если response.status = 201
        })
        .catch(err => {
          if (is422(err)) {
            const errors = err.response.data.errors;
            if (errors["content"] && 1 === _.size(errors)) {
              this.errors = errors;
              return;
            }
          }
          this.error = true;
        })
        .then(() => (this.sending = false));
    }
  }
};
</script>
