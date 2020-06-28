<template>
<div v-if="getData">
            <a
            v-for="(item, indexa) in $root.sidebarOneToArray(getData)" :key="indexa" v-if="!$root.banWords(item)"
            @click="$root.highlightText = $root.replaceSidebarAtoZ(item)" :class="$root.highlightText == $root.replaceSidebarAtoZ(item) ? 'bg-yellow' : ''"
            type="button" class="btn btn-outline-primary btn-sm" style="width:200px;margin:5px;float:left;font-weight:600;text-align:left;"  
            :href="'#/search?text=' + $root.replaceSidebarAtoZ(item)">
            
            <span class="notranslate">{{item}}</span>: 
            <small style="font-size:10px;color: red;">{{item}}</small>
            </a>
        </div>
  </template>



  <script>
  module.exports = {
  name: "user",
  props: ['datat', 'typet'],
    data() {
        return {
            article: '',
            articleForm: '',
            highlightText: '',
            linkText: '',
            minSize: 20,
            showWordsTab: false,
            regexQuery: '',
        }
    },
    computed: {
        getData() {
           return this.datat
        }
    },
    methods: {},
    created(){
        console.log(this.getData);
        
    }
}
</script>
<style scoped>
.bg-yellow{
  background-color: yellowgreen;
}
</style>
