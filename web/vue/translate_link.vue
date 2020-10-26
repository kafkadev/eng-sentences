<template>
    <div v-if="getQueryText">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
            <input v-on:keyup.enter="$root.articleText = 0, getArticle()" name="url" v-model="$root.linkText" class="form-control form-control-dark w-100" type="text" placeholder="Text" aria-label="Search" style="
            max-width: 80%;
            ">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="$root.articleText = 0, getArticle()">Set</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="showWordsTab = !showWordsTab">Words</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>


<nav-list></nav-list>
            </div>
        </div>




<sentences-table :datat="$root.matchArticleToArray($root.articleText)" :typet="'translate_link'" ></sentences-table>
      </div>
  </template>



  <script>
  module.exports = {

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
        getQueryText() {
            if (this.$route.query && this.$route.query.text) {
                this.$root.linkText = this.$route.query.text
                    this.getArticle()

            }
            return true;
        }
    },
    methods: {

        getArticle(){
            window.scrollTo(0, 0)
            this.$root.articleText = ''
            setTimeout(() => {

              fetch(this.$root.apiUrl + '/getLink?url='+this.$root.linkText.trim()).then((response) => {
                return response.json()
            }).then((data) => {
                   console.log(data)
           this.$root.articleTextArr = _.pluck(data, 'text')
           this.$root.articleText = this.$root.rawDataClean(_.pluck(data, 'text').join(' '))
         // val.text = val.text.replace(/(<\s*[^>]*>)/gi, ' ');
     })


        }, 100)
        }
    }
}
</script>
<style scoped>
.bg-yellow{
  background-color: yellowgreen;
}
</style>
