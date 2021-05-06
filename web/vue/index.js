var Main = httpVueLoader('./vue/main.vue')
var Dashboard = httpVueLoader('./vue/Dashboard.vue')
var User = httpVueLoader('./vue/user.vue')
var SiteTop = httpVueLoader('./vue/SiteTop.vue')
var SiteFooter = httpVueLoader('./vue/SiteFooter.vue')
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
var SourceDictionary = httpVueLoader('./vue/source_dictionary.vue')
var SourceFavoriteWords = httpVueLoader('./vue/source_favorite_words.vue')
var SourceFavoriteSentences = httpVueLoader('./vue/source_favorite_sentences.vue')
var SearchWord = httpVueLoader('./vue/search_word.vue')
var SearchWordOutsource = httpVueLoader('./vue/search_word_outsource.vue')
var TranslateLink = httpVueLoader('./vue/translate_link.vue')
var SourceSubtitle = httpVueLoader('./vue/source_subtitle.vue')
var TranslateSubtitle = httpVueLoader('./vue/translate_subtitle.vue')
var TranslateRaw = httpVueLoader('./vue/translate_raw.vue')
var Erken = httpVueLoader('./vue/erken.vue')
var NamedWrapper = httpVueLoader('./vue/named.vue')
var RightTable = httpVueLoader('./vue/RightTable.vue')
var LeftTable = httpVueLoader('./vue/LeftTable.vue')
var SourceLongSentences = httpVueLoader('./vue/SourceLongSentences.vue')
var BlogSources = httpVueLoader('./vue/BlogSources.vue')
var TopWords = httpVueLoader('./vue/TopWords.vue')


alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
Vue.prototype.alertify = window.alertify;


Vue.mixin({
    data() {
        return {
            apiUrl: '/api',
        }
    },
    components: {
        LeftTable,
        RightTable,
        SiteTop,
        SiteFooter,
        Sidebar,
        SentencesTable,
        WordButtons,
        NavList
    },
    methods: {

    }
})








if (!location.host.split(".").includes("test")) {
    if (!window.console) window.console = {};
    var methods = [
    "log",
    "debug",
    "warn",
    "info",
    "error",
    "trace",
    "dir",
    "dirxml",
    "group",
    "groupEnd",
    "time",
    "timeEnd",
    "assert",
    "profile",
    ];
    for (var i = 0; i < methods.length; i++) {
        console[methods[i]] = function() {};
    }
}




/* Router and App setup: */
var routes = [{
    path: '/post/:postId',
    name: 'post',
    props: true,
    component: Post
},
{
    path: '/',
    name: 'home',
    props: true,
    component: Dashboard
}, {
    path: '/SourceSubtitle',
    name: 'SourceSubtitle',
    props: true,
    component: SourceSubtitle
},
{
    path: '/search',
    name: 'SearchWord',
    component: SearchWord
},
{
    path: '/TopWords',
    name: 'TopWords',
    component: TopWords
},
{
    path: '/BlogSources',
    props: true,
    name: 'BlogSources',
    component: BlogSources
},
{
    path: '/SearchWordOutsource',
    name: 'SearchWordOutsource',
    component: SearchWordOutsource
},
{
    path: '/SourceDictionary',
    name: 'SourceDictionary',
    component: SourceDictionary
},
{
    path: '/TranslateLink',
    name: 'TranslateLink',
    component: TranslateLink
},
{
    path: '/TranslateSubtitle',
    name: 'TranslateSubtitle',
    component: TranslateSubtitle
},    {
    path: '/SourceLongSentences',
    name: 'SourceLongSentences',
    component: SourceLongSentences
},
{
    path: '/TranslateRaw',
    name: 'TranslateRaw',
    component: TranslateRaw
},
{
    path: '/SourceNews',
    name: 'SourceNews',
    component: SourceNews
},
{
    path: '/SourceArticles',
    name: 'SourceArticles',
    component: SourceArticles
},
{
    path: '/SourceFiles',
    name: 'SourceFiles',
    component: SourceFiles
},
{
    path: '/SourceVideo',
    name: 'SourceVideo',
    component: SourceVideo
},
{
    path: '/SourceFavoriteWords',
    name: 'SourceFavoriteWords',
    component: SourceFavoriteWords
},
{
    path: '/SourceFavoriteSentences',
    name: 'SourceFavoriteSentences',
    component: SourceFavoriteSentences
}
];

var router = new VueRouter({
    //mode: 'history',
    routes: routes
});




//document.addEventListener('DOMContentLoaded', function() {

    const appsd = new Vue({

        data() {
            return {
                apiUrl: '/api',
                linkText: 'https://css-tricks.com/clean-up-your-css/',
                articleText: '',
                highlightText: '',
                articleForm: '',
                sidebarAddWordText: '',
                favoritedWords: [],
                saveLinkHistoryCollection: [],
                saveWordHistoryCollection: [],
                saveWordHistoryCollection1: [],
                articleTextArr: [],
                sourceLinks: [],
                tableHelperWords: [],
                dictionaryData: [],
                leftTable: {
                    'getSearch': [],
                    'getArticles': [],
                    'getVideos': [],
                    'getWords': [],
                    'getDict': [],
                    'getDictFamily': [],
                },
                showDictionary: true,
            }
        },
        router: router,
        el: '#app',
        render: h => h(Main),
        template: '<Main/>',
        methods: {
            parser1(str){
                //satır sonları
              return str.replace(/([.?!])(\s)*(?=[a-z0-9.,'?!;:şçüğıÇÜĞŞİĞÖö’"])/g, "$1|").split("|").filter(sentence => !!sentence).map(sentence => sentence.trim());
          },
          matchArticleToArray(text = '', subtitle = 0) {

            return text.trim().match(/(\S.+?[.!?])(?=(\s)|$)(?<!\s([a-z0-9.,'?!;:şçüğıÇÜĞŞİĞÖö’]){0,-1}.)/g)
        },
        replaceSidebarAtoZ(text) {
            return text.trim().replace(/([^a-z]+)/gi, '')
        },
        banWords(text) {
            text = text.toLowerCase();
            return [].includes(text) || text.length < 1
        },
        sidebarOneToArray(text) {
            return text.length > 1 ? _.uniq(text.toLowerCase().replace(/([^a-z]+)/gi, ' ').split(' ')).sort() : 0
        },
        rawDataClean(text) {
            //return unescape(text.replace(/([^a-z0-9.,'?!;]+)/gi, ' '))
            return unescape(text.replace(/([^a-z0-9.,'?!;:şçüğıÇÜĞŞİĞÖö’]+)/gim, ' '))
        },
        searchWord(text = '', min_size = 20) {
            text = text.trim().toLowerCase();
            if (text) {
                this.saveWordHistoryCollection1.unshift(text)

                this.leftTable = []
                this.tableHelperWords = []


                setTimeout(() => {
                    window.scrollTo(0, 0)
                    fetch(this.$root.apiUrl + '/getSentences?limit=100&text=' + text + '&min_size=' + min_size).then((response) => {
                        return response.json()
                    }).then((data) => {
                        this.leftTable = data

                    })


                }, 100)
            }

        },
        textSelectorEvent(text) {
            text = text.trim();
console.log(text)
            if (text.trim() && typeof text.trim() === 'string' && !text.trim().includes(":")) {
                console.log(text.trim());
                this.tableHelperWords = []

                //this.showDictionary = false
                //text = text.trim().replace(/([^a-z\s']+)/gi, '');
                this.sidebarAddWordText = text
                this.highlightText = text
                this.searchWord(text)


            }
            //this.sidebarAddWordText = window.getSelection().toString()
            //this.doubleClick(window.getSelection().toString())
        },
        textSelector(e) {
            e.preventDefault();

            var text = window.getSelection().toString()
            if (text.trim()) {
                this.tableHelperWords = []

                //this.showDictionary = false
                //text = text.trim().replace(/([^a-z\s']+)/gi, '');
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
          saveWordHistory(text) {
            //console.log(text);

            this.saveWordHistoryCollection.push(text)
            if (localStorage.getItem('wordHistory')) {
                let wordArr = [...JSON.parse(localStorage.getItem('wordHistory')), ...this.saveWordHistoryCollection]
                localStorage.setItem('wordHistory', JSON.stringify(_.uniq(wordArr)))
            } else {
                localStorage.setItem('wordHistory', JSON.stringify([]))
            }


        },
        saveLinkHistory(text) {
            //console.log(text);

            this.saveLinkHistoryCollection.push(text)
            if (localStorage.getItem('linkHistory')) {
                let wordArr = [...JSON.parse(localStorage.getItem('linkHistory')), ...this.saveLinkHistoryCollection]
                localStorage.setItem('linkHistory', JSON.stringify(_.uniq(wordArr)))
            } else {
                localStorage.setItem('linkHistory', JSON.stringify(this.saveLinkHistoryCollection))
            }


        },
        encode: function(str) {
            var buf = [];

            for (var i = str.length - 1; i >= 0; i--) {
                buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
            }

            return buf.join('');
        },
        decode: function(str) {
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

                   console.log('Eklendi:' + text)
                   this.alertify.success(text)
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
        },
                getWords() {

          fetch(this.$root.apiUrl + '/getFavoriteWords')
          .then((response) => {
              return response.json()
          })
          .then((data) => {

            this.$root.favoritedWords = _.pluck(data, 'text').reverse()
           // console.log(data)
        });

      },
    },
    created() {



        this.getWords();
    }
});
//});
