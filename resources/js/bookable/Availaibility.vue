<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check availaibility
      <span v-if="notAvailability">(NOT AVAILABLE)</span>
      <span v-if="hasAvailability">(AVAILABLE)</span>
    </h6>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          type="text"
          placeholder="Start Date"
          name="from"
          class="form-control form-control-sm"
          v-model="from"
          @keyup.enter="check"
          :class="[{'is-invalid': errorFor('from')}]"
        />
        <v-errors :errors="errorFor('from')"></v-errors>
      </div>

      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          type="text"
          placeholder="Finish Date"
          name="to"
          class="form-control form-control-sm"
          v-model="to"
          @keyup.enter="check"
          :class="[{'is-invalid': errorFor('to')}]"
        />
        <v-errors :errors="errorFor('to')"></v-errors>
      </div>
    </div>
    <button class="btn btn-secondary btn-block" v-on:click="check" :disabled="loading">Check!</button>
  </div>
</template>

<script>
import { is404, is422 } from "../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  props: {
    bookableId: String
  },
  data() {
    return {
      from: null,
      to: null,
      loading: false,
      status: null,
    };
  },
  methods: {
    check() {
      this.loading = true;
      this.errors = null;

      axios
        .get(
          `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
        )
        .then(response => {
          this.status = response.status;
        })
        .catch(error => {
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        })
        .then(() => (this.loading = false));
    },
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
    hasAvailability() {
      return 200 === this.status;
    },
    notAvailability() {
      return 400 === this.status;
    }
  }
};
</script>

<style scoped>
label {
  font-size: 0.7rem;
  color: gray;
  font-weight: bold;
  text-transform: uppercase;
}
</style>