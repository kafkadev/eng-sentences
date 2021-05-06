<template>
    <div>
        <site-top></site-top>
        <div class="wrapper">
        <div class="container-fluid">
        <router-view></router-view>
        <site-footer></site-footer>
      </div>
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
    methods: {},
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
.curp {
    cursor: cell;
}
</style>
