<template>
    <div>
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




<sentences-table :datat="$root.articleTextArr" :typet="'translate_link'"></sentences-table>
      </div>
  </template>



  <script>
  //http://sentences.test/api/get_dizi.php?name=24&part=en-1-1.vtt
  module.exports = {

    data() {
        return {
            article: '',
            articleForm: '',
            highlightText: '',
            linkText: '24,1,1',
            minSize: 20,
            showWordsTab: false,
            regexQuery: '',
        }
    },
    created(){
this.$root.linkText = this.linkText
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
            this.$root.articleTextArr = []
            setTimeout(() => {
let queryPart = this.$root.linkText.split(',')
              fetch(this.$root.apiUrl + '/get_dizi.php?name='+queryPart[0]+'&part=en-'+queryPart[1]+'-'+queryPart[2]+'.vtt').then((response) => {
                return response.json()
            }).then((data) => {
                   //console.log(data)
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
