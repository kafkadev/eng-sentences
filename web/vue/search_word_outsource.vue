<template>
            <div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
                    <input v-model="queryText" class="form-control form-control-dark w-100" type="text" placeholder="Text" aria-label="Search" style="
    max-width: 500px;
">
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" @click="searchWord(queryText)">Set</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            This week
                        </button>
                    </div>
                </div>
  <h2 class="hide">Section title</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm" v-if="getQueryText">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Main</th>
                                <th>Translate</th>
                            </tr>
                        </thead>
                        <tbody>
                                 <tr v-for="(item, key) in words" v-if="item.text.length < 300 && item.text.length > 10" :class="$root.highlightText && item.text.toLowerCase().split(' ').includes($root.highlightText) ? 'bg-yellow' : ''">
                                        <th scope="row">{{key}}</th>
                                        <td>
                                            <span class="notranslate" style="font-weight:600;color:blue;">
                                                <span v-for="keyw in item.text.replace('.', '').toLowerCase().split(' ')" @click.middle="$router.push('search?text=' + keyw.replace(/([^a-z0-9]+)/gi, ''))">{{keyw}} </span>
                                            </span>

                                        </td>
                                        <td><span class="translated" style="color:black;"><small>{{item.text.replace('.', '').toLowerCase()}}<small></span></td>
                                    </tr>

                        </tbody>
                    </table>
                </div>
</div>
</template>

<script>

  module.exports = {

    data() {
      return {
        queryText : '',
        article : '',
        articleForm : '',
        words: []
      }
  },
  computed: {
    getQueryText(){
          if (this.$route.query && this.$route.query.text) {
            this.words = []
            setTimeout(() => {


        this.searchWord(this.$route.query.text);
            }, 2000);

    }
    return true;
    }
  },
  methods: {
    setArticle(){
        setTimeout(() => this.article = this.articleForm,2000)

    },
    searchWord(text = ''){
      this.$root.saveWordHistory(text.trim())
      this.words = []
      window.scrollTo(0, 0)
      fetch(this.$root.apiUrl + '/word_outsource.php?text='+text.trim()+'&type=word&url=0').then((response) => {
        return response.json()
      }).then((data) => {
        this.words = data.data.sentences.map((val, key)=> {
            val['text'] = val['sentence'];
            return val
        })
      })
    }
  },
  created(){
    if (this.$route.query && this.$route.query.text) {
      //this.searchWord(this.$route.query.text)
    }
    console.log(this.$route.query)
  }
}
</script>
<style scoped>
.bg-yellow{
  background-color: yellowgreen;
}
tr td.translated{
  color: black;
  font-size: 12px;
}
tr td.translated:hover{
  color: black;
}
</style>
