

var Main = httpVueLoader('./vue/main.vue')
var User = httpVueLoader('./vue/user.vue')
var Sidebar = httpVueLoader('./vue/sidebar.vue')
var SentencesTable = httpVueLoader('./vue/list_sentences_table.vue')
var WordButtons = httpVueLoader('./vue/list_words_buttons.vue')
var NavList = httpVueLoader('./vue/nav_list.vue')
var Post = httpVueLoader('./vue/posts.vue')
var Home = httpVueLoader('./vue/home.vue')
var UserList = httpVueLoader('./vue/user-list.vue')
var SourceNews = httpVueLoader('./vue/source_news.vue')
var SourceArticles = httpVueLoader('./vue/source_articles.vue')
var SourceVideo = httpVueLoader('./vue/source_video.vue')
var SourceFiles = httpVueLoader('./vue/source_files.vue')
var SourceBest = httpVueLoader('./vue/source_bestwords.vue')
var SearchWord = httpVueLoader('./vue/search_word.vue')
var SearchWordOutsource = httpVueLoader('./vue/search_word_outsource.vue')
var TranslateLink = httpVueLoader('./vue/translate_link.vue')
var TranslateSubtitle = httpVueLoader('./vue/translate_subtitle.vue')
var TranslateRaw = httpVueLoader('./vue/translate_raw.vue')
var Erken = httpVueLoader('./vue/erken.vue')
var NamedWrapper = httpVueLoader('./vue/named.vue')


/* Router and App setup: */
var routes = [
{
  path: '/post/:post_id',
  name: 'posts',
  props: true,
  component: Post
},
{
  path: '/',
  name: 'home',
  props: true,
  component: SourceNews
},
{
  path: '/search',
  name: 'SearchWord',
  component: SearchWord
},
{
  path: '/search-outsource',
  name: 'SearchWordOutsource',
  component: SearchWordOutsource
},
{
  path: '/translate-link',
  name: 'TranslateLink',
  component: TranslateLink
},{
  path: '/translate-subtitle',
  name: 'TranslateSubtitle',
  component: TranslateSubtitle
},
{
  path: '/translate-raw',
  name: 'TranslateRaw',
  component: TranslateRaw
},
{
  path: '/source-news',
  name: 'SourceNews',
  component: SourceNews
},
{
  path: '/source-articles',
  name: 'SourceArticles',
  component: SourceArticles
},
{
  path: '/source-files',
  name: 'SourceFiles',
  component: SourceFiles
},
{
  path: '/source-video',
  name: 'SourceVideo',
  component: SourceVideo
},
{
  path: '/source-best',
  name: 'SourceBest',
  component: SourceBest
},
];

var router = new VueRouter({
  //mode: 'history',
  routes: routes
});


setTimeout(() => {



},0)

Vue.mixin({
  components: {
    Sidebar,
    SentencesTable,
    WordButtons,
    NavList
  }
})

const appsd = new Vue({

  data() {
    return {
      apiUrl : '/api',
      linkText : 'https://css-tricks.com/clean-up-your-css/',
      articleText : '',
      highlightText : '',
      articleForm : '',
      sidebarAddWordText : '',
      saveWordHistoryCollection:[],
      saveWordHistoryCollection1:[],
      articleTextArr:[],
      sourceLinks:[],
      tableHelperWords: [],
      dictionaryData: [],
      leftTable: {
        'getSearch':[],
        'getArticles':[],
        'getVideos':[],
        'getWords':[],
        'getDict':[],
        'getDictFamily':[],
      },
      showDictionary: true,
    }
  },
  router: router,
  el: '#app',
  render: h => h(Main),
  template: '<Main/>',
  methods: {
    searchWord(text = '', min_size = 20) {
      text = text.trim().toLowerCase();
      if (text) {
        this.saveWordHistoryCollection1.push(text)

        this.leftTable = []
        this.tableHelperWords = []


        setTimeout(() => {
          window.scrollTo(0, 0)
          fetch(this.$root.apiUrl + '/getSentences?limit=100&text=' + text + '&min_size=' + min_size).then((response) => {
            return response.json()
          }).then((data) => {
            this.leftTable = data

          })

         /* if (text.split(' ').length && text.split(' ').length < 2) {

            fetch(this.$root.apiUrl + '/word_outsource.php?text=' + text + '&type=word&url=0').then((response) => {
              return response.json()
            }).then((data) => {
              if (data && data.data && data.data.sentences) {
                let OutsourceWords = data.data.sentences.map((val, key)=> {
                  val['text'] = val['sentence'];
                  return val
                })
            // this.tableHelperWords = this.tableHelperWords.length < 5 ? this.tableHelperWords.concat(OutsourceWords) : this.tableHelperWords
          }

        })


        } */

      },100)
      }

    },
    textSelector(e) {
      e.preventDefault();

      var text = window.getSelection().toString()
      if (text.trim()) {
        this.tableHelperWords = []

  //this.showDictionary = false
  text = text.trim().replace(/([^a-z\s']+)/gi, '');
  this.sidebarAddWordText = text
  this.highlightText = text
  this.searchWord(text)


}
//this.sidebarAddWordText = window.getSelection().toString()
//this.doubleClick(window.getSelection().toString())
},
doubleClick(text) {
  this.tableHelperWords = []
  this.dictionaryData = []
  //this.showDictionary = false
  text = text.trim().replace(/([^a-z]+)/gi, '');
  this.sidebarAddWordText = text
  this.highlightText = text
  this.searchWord(text)
  /*fetch('http://sentences.test/api/dictionary.php?type=important&text='+text).then((response) => {
    return response.json()
  }).then((data) => {
   // console.log(data);
    this.dictionaryData = data
  })*/


},
saveWordHistory(text){
  //console.log(text);

  this.saveWordHistoryCollection.push(text)
  if (localStorage.getItem('wordHistory')) {
    let wordArr = [...JSON.parse(localStorage.getItem('wordHistory')),...this.saveWordHistoryCollection]
    localStorage.setItem('wordHistory', JSON.stringify(_.uniq(wordArr)))
  } else {
    localStorage.setItem('wordHistory', JSON.stringify([]))
  }


},
matchArticleToArray(text = '', subtitle = 0){

  return text.trim().match(/(\S.+?[.!?:;])(?=(\s)|$)(?<!\s([A-Z]|[a-z]){0,-1}.)/g)
},
replaceSidebarAtoZ(text){
  return text.trim().replace(/([^a-z]+)/gi, '')
},
banWords(text){
  text = text.toLowerCase();
  return ['and','that','one','any','for','this','the'].includes(text) || text.length < 4
},
sidebarOneToArray(text){
  return _.uniq(text.toLowerCase().replace(/([^a-z]+)/gi, ' ').split(' ')).sort()
},
rawDataClean(text){
  //return unescape(text.replace(/([^a-z0-9.,'?!;]+)/gi, ' '))
  return unescape(text.replace(/([^a-z0-9.,'?!;:şçüğıÇÜĞŞİĞÖö’]+)/gim, ' '))
},
encode : function(str) {
  var buf = [];

  for (var i=str.length-1;i>=0;i--) {
    buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
  }

  return buf.join('');
},
decode : function(str) {
  return str.replace(/&#(\d+);/g, function(match, dec) {
    return String.fromCharCode(dec);
  });
},
saveWordHistorySend(text) {

  fetch(this.apiUrl + '/addFavorite?text=' + text.trim() + '&type=save&url=0')
  .then((response) => {
    return response.json()
  })
  .then((data) => {
   // console.log(data)
   this.sidebarAddWordText = '';
 });
},
getAllWords() {

  fetch(this.apiUrl + '/all_words.json')
  .then((response) => {
    return response.json()
  })
  .then((data) => {
    this.all_words = data
  });
}
},
created(){
  //this.getAllWords();
}
});


