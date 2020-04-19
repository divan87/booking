<template>
  <div>
    <div class="form-group">
      <label class="text-muted">Select star rating</label>
      <!-- <star-rating :rating="1" class="fa-3x" @rating-changed="onRatingChanged"></star-rating> -->
      <!-- <star-rating :rating="review.rating" class="fa-3x" @rating-changed="review.rating = $event"></star-rating> -->
      <star-rating v-model="review.rating" class="fa-3x"></star-rating>
    </div>
    <div class="form-group">
      <label for="content" class="text-muted">Describe your experience</label>
      <textarea name="content" coils="30" rows="10" class="form-control" v-model="review.content"></textarea>
    </div>
    <button class="btn btn-lg btn-primary btn-block">Submit</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      review: {
        rating: 5,
        content: null
      }
    };
  }
  // methods: {
  //     onRatingChanged(rating) {
  //         console.log(rating);
  //     },
  // },
};
</script>