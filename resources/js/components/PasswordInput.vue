<template>
  <div class="">
    <div class="input-group">
      <input
        :type="show ? 'text' : 'password'"
        class="form-control"
        placeholder="Password"
      />
      <div class="input-group-append">
        <button type="button" class="input-group-text btn btn-light" @click="show=!show">
            <i class="fa fa-eye" v-show="!show"></i>
            <i class="fa fa-eye-slash" v-show="show"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false
    };
  },
  mounted() {},
  methods: {}
};
</script>
