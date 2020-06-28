<template>
    <div class="container-fluid">

        <div class="row">
          <sidebar></sidebar>
          <main role="main" class="col-md-11 ml-sm-auto col-lg-11 px-4">
        <router-view></router-view>
      </main>
        </div>

    </div>
</template>

<script>

  module.exports = {

    data() {
      return {
      posts: [] // selected user data. Place this here to make sure it's reactive.
    };
  },
  methods: {
},
beforeUpdate() {},
updated() {},
created() {},
beforeCreate() {

},
mounted() {

},
filters: {},
components: {}
}
</script>

<style>
.hello {
  background-color: #ffe;
}
</style>


