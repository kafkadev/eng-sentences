<template>
  <div v-if="getQueryText">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
      <input @change="getFile" name="subtitle" v-model="fileData" class="form-control form-control-dark w-100" type="file" placeholder="Text" aria-label="Search" style="
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




    <sentences-table v-if="$root.articleTextArr" :datat="$root.articleTextArr" :typet="'translate_link'"></sentences-table>
  </div>
</template>



<script>
var xmlhttp = null;
module.exports = {

  data() {
    return {
      fileData: null,
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
    getFile(e){

      var fileType = e.target.files[0].name.split('.').slice(-1)[0];
      e.target.files[0].text().then((content) => {
        console.log('RAW1',content)
        console.log('RAW2',content.split("\r"))
        console.log('RAW3',content.split("\n"))
        console.log('RAW4',content.split("\n\s"))
        console.log('RAW5',content.split("\n\r"))
        console.log('RAW6',content.split("\r\n\r\n"))
        console.log('RAW7',content.split("\n\n"))
        if (fileType == 'srt') {
          this.loadSrt(content)
        } else if (fileType == 'vtt') {
          this.loadVtt(content)
        }
        else if (fileType == 'txt') {
          this.loadTxt(content)
        }
      })






    },

    loadTxt(content){
      this.$root.articleTextArr = this.$root.matchArticleToArray(content)

    },
    loadSrt(content){

      content = content.split("\n\r").map((item) => {
        item = item.split("\r").splice(2).join(', ');
        return item;
      })
      console.log(content)
      this.$root.articleTextArr = content


    },
    loadVtt(content){
      content = content.split("\n\n").map((item) => {
      console.log(item)
        item = item.split("\n").splice(1).join(', ');
        return item;
      })
      console.log(content)
      this.$root.articleTextArr = content

    },
    loadCSV(url)
    {
      fetch(url)
      .then((response) => {
        return response.text();
      })
      .then((content) => {
       content = content.split("\r\n\r\n").map((item) => {
        item = item.split("\r\n");
        return item;
      })
       this.$root.articleTextArr = content
     });

    },
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
