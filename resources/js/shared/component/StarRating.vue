<template>
  <div class="d-flex">
    <i
      class="fas fa-star"
      v-for="star in fullStars"
      :key="'full ' + star"
       @click="$emit('input', star)"
    >
      <!-- @click="$emit('rating-changed', star)" -->
    </i>
    <i class="fas fa-star-half-alt" v-if="halfStar"></i>
    <i
      class="far fa-star"
      v-for="star in emptyStars"
      :key="'empty ' + star"
      @click="$emit('input', fullStars + star)"
    >
      <!-- @click="$emit('rating-changed', fullStars + star)" -->
    </i>
  </div>
</template>

<script>
export default {
  props: {
    // rating: Number
    value: Number
  },
  computed: {
    halfStar() {
      const fraction = Math.round(
        // (this.rating - Math.floor(this.rating)) * 100
        (this.value - Math.floor(this.value)) * 100
      );
      //console.log(fraction);
      return fraction > 0 && fraction < 50;
    },
    fullStars() {
    //   return Math.round(this.rating);
      return Math.round(this.value);
    },
    emptyStars() {
    //   return 5 - Math.ceil(this.rating);
      return 5 - Math.ceil(this.value);
    }
  }
};
</script>