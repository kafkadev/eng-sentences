<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <input v-model="searchTag" class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" style="
            max-width: 500px;
            ">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="showCat = !showCat">Categories</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <nav-list></nav-list>
            </div>
        </div>


        <div class="row">


            <div class="col-md-8" >

    <iframe v-if="selectedPost && selectedPost.title" :src="selectedPost.content" style="width: 100%;height:calc(100vh - 100px);
    border: 0;"></iframe>

        </div>
        <div class="table-responsive col-md-4"  >
              <div class="form-group mb-20 notranslate">
                <select class="custom-select" v-model="searchTag" @change="getArticle(searchTag)">
                <option v-for="(item, indexa) in _.keys(_.indexBy(categories, 'category'))">{{item}}</option>
            </select>
        </div>
            <div style="height: 157px; overflow-y: scroll;" v-if="1 == 0 && posts && showCat">
                                        <button
            v-for="(item, indexa) in _.keys(_.indexBy(categories, 'category'))" type="button" class="btn btn-outline-primary btn-sm catbtn"
            @click="searchTag = item, getArticle(item)" style=""
            :class="[searchTag == item ? 'btn-primary text-white':'']">
            <span class="notranslate">{{item}}</span><br> <small style="font-size:10px;color: red;">{{item}}</small></button>
            </div>

                    <div style="height: calc(100vh - 160px);
        overflow-y: scroll;">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>type</th>
                    <th>title</th>
                </tr>
            </thead>
            <tbody>
                <tr class="notranslate" v-for="(item, key) in (searchTag ? posts : posts.slice(0,50))" :key="key" v-if="searchTag ? item.category.search(searchTag) != -1 : true">
                    <td>{{item.id}}</td>
                    <td>{{item.category}}</td>
                    <td class="text-primary text-capitalize1 font-weight-bold curp" v-html="item.title" @click="selectedPost = item">{{item.title}}
                    </td>
                    <td>{{new URL(item.content).hostname}}</td>

                </tr>

            </tbody>
        </table>

    </div>
        </div>

</div>
<div v-if="selectedPost == 22 && selectedPost.title" :class="[selectedPost ? 'showModal':'']" class="modal fade bd-example-modal-xl show" :aria-modal="(selectedPost.title)" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" :aria-hidden="(!selectedPost.title)" style="
">
<div class="modal-dialog modal-xl  modal-dialog-scrollable" role="document"  style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" v-html="selectedPost.title">{{selectedPost.title}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="selectedPost = 0">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <iframe :src="selectedPost.content" style="width: 100%;
    height: 700px;
    border: 0;"></iframe>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="selectedPost = 0">Close</button>
    <button type="button" class="btn btn-primary hide">Save changes</button>
</div>
</div>
</div>
</div>
</div>
</template>

<script>
module.exports = {

    data() {
        return {
            showCat: true,
            searchTag: 'tenses',
            issubtitle: true,
            article: '',
            articleForm: '',
            selectedPost: 0,
            highlightText: '',
            linkText: '',
            minSize: 20,
            regexQuery: '',
            posts: {},
            categories: [{"category":"general","count":"20144"},{"category":"grammarly","count":"1300"},{"category":"uncategorized","count":"222"},{"category":"grammar","count":"197"},{"category":"vocabulary","count":"177"},{"category":"okuma","count":"148"},{"category":"ways-to-say","count":"113"},{"category":"ingilizce","count":"100"},{"category":"speaking","count":"91"},{"category":"phrasal-verbs","count":"66"},{"category":"tenses","count":"62"},{"category":"ingilizce-dersi","count":"60"},{"category":"conjunctions","count":"59"},{"category":"prepositions","count":"53"},{"category":"en","count":"38"},{"category":"verbs","count":"32"},{"category":"animals","count":"30"},{"category":"konusma","count":"29"},{"category":"collocations","count":"28"},{"category":"synonyms","count":"28"},{"category":"gramer","count":"25"},{"category":"idioms","count":"24"},{"category":"nouns","count":"22"},{"category":"tense","count":"21"},{"category":"wp","count":"18"},{"category":"antonyms-opposite-words","count":"17"},{"category":"modals","count":"17"},{"category":"activities","count":"13"},{"category":"common-mistakes","count":"11"},{"category":"conditionals","count":"11"},{"category":"abbreviations-contractions","count":"10"},{"category":"appearance","count":"7"},{"category":"body-parts","count":"7"},{"category":"classroom","count":"7"},{"category":"clothes","count":"7"},{"category":"colours","count":"7"},{"category":"drinks","count":"7"},{"category":"foods","count":"7"},{"category":"house","count":"7"},{"category":"living-room","count":"7"},{"category":"pets","count":"7"},{"category":"space","count":"7"},{"category":"toys-games","count":"7"},{"category":"vegetables","count":"7"},{"category":"writing","count":"7"},{"category":"accessories","count":"6"},{"category":"adjectives","count":"6"},{"category":"bathroom","count":"6"},{"category":"bedroom","count":"6"},{"category":"birds","count":"6"},{"category":"books-literature","count":"6"},{"category":"business-trade","count":"6"},{"category":"car-parts","count":"6"},{"category":"city-life","count":"6"},{"category":"classroom-language","count":"6"},{"category":"communication","count":"6"},{"category":"computer-parts","count":"6"},{"category":"computer-software","count":"6"},{"category":"cooking","count":"6"},{"category":"countries","count":"6"},{"category":"daily-routines","count":"6"},{"category":"dining-room","count":"6"},{"category":"electronics","count":"6"},{"category":"environment","count":"6"},{"category":"face","count":"6"},{"category":"family","count":"6"},{"category":"farm-life","count":"6"},{"category":"fast-food","count":"6"},{"category":"feelings","count":"6"},{"category":"films-cinema","count":"6"},{"category":"fitness","count":"6"},{"category":"free-time-activities","count":"6"},{"category":"fruits","count":"6"},{"category":"garden","count":"6"},{"category":"geography","count":"6"},{"category":"health-illness","count":"6"},{"category":"herbs-spices","count":"6"},{"category":"history","count":"6"},{"category":"holiday","count":"6"},{"category":"insects","count":"6"},{"category":"internet","count":"6"},{"category":"jobs-occupations","count":"6"},{"category":"landscape","count":"6"},{"category":"language-terminology","count":"6"},{"category":"law-order","count":"6"},{"category":"maths","count":"6"},{"category":"medicine-hospital","count":"6"},{"category":"military","count":"6"},{"category":"music","count":"6"},{"category":"nationalities","count":"6"},{"category":"nature","count":"6"},{"category":"numbers","count":"6"},{"category":"prefixes","count":"6"},{"category":"sentences","count":"6"},{"category":"weather","count":"6"},{"category":"alphabet","count":"5"},{"category":"computer-games","count":"5"},{"category":"days-months-seasons","count":"5"},{"category":"festivals","count":"5"},{"category":"homophones","count":"5"},{"category":"office","count":"5"},{"category":"personality-characters","count":"5"},{"category":"photography","count":"5"},{"category":"physics","count":"5"},{"category":"plants","count":"5"},{"category":"question-words","count":"5"},{"category":"religion","count":"5"},{"category":"school-education","count":"5"},{"category":"science","count":"5"},{"category":"sea-animals","count":"5"},{"category":"sea-side","count":"5"},{"category":"shopping","count":"5"},{"category":"sport-types","count":"5"},{"category":"street","count":"5"},{"category":"technology","count":"5"},{"category":"tools-equipments","count":"5"},{"category":"transportation","count":"5"},{"category":"travel","count":"5"},{"category":"collective-nouns","count":"4"},{"category":"kitchen","count":"4"},{"category":"proverbs","count":"4"},{"category":"school-subjects","count":"4"},{"category":"active-passive-voice","count":"3"},{"category":"english-for-kids","count":"3"},{"category":"tem2","count":"3"},{"category":"determiners","count":"2"},{"category":"gerunds-infinitives","count":"2"},{"category":"human","count":"2"},{"category":"reported-speech","count":"2"},{"category":"speaking-general","count":"2"},{"category":"toefl","count":"2"},{"category":"business-english","count":"1"},{"category":"english-exercises","count":"1"},{"category":"english-phrases","count":"1"},{"category":"genel","count":"1"},{"category":"ielts","count":"1"},{"category":"listening","count":"1"},{"category":"proje-kosesi","count":"1"},{"category":"universo","count":"1"}]
        }
    },
    methods: {
        setArticle() {
            //setTimeout(() => this.$root.articleText = this.articleForm.match( /[^\.!\?]+[\.!\?]+|[^\.!\?]+/g ), 2000)
            //.match(/[^.\n]+/g)
            //( *?[a-zA-Z'.!?.] *?){10,}
            //.match(/(\S.+?[.!?])(?=\s+|$)(?<!\s([A-Z]|[a-z]){1,3}.)+/g)
            window.scrollTo(0, 0)
            setTimeout(() => {
                if (this.issubtitle) {
                    this.$root.articleText = this.$root.rawDataClean(this.$root.articleForm.split('\n').join('. '))

                } else {
                    this.$root.articleText = this.$root.rawDataClean(this.$root.articleForm)

                }

            }, 2000)
            //setTimeout(() => this.$root.articleText = this.$root.articleForm, 2000)

        },
        getArticle(text) {
            window.scrollTo(0, 0)
            setTimeout(() => {

                fetch('http://sentences.test/api/NewsSources.php?type=news&text=' + text).then((response) => {
                    return response.json()
                }).then((data) => {
                    console.log(data);
                    this.posts = _.sortBy(data,'category')
                })

            }, 100)
        }
    },
    created(){
        //this.getArticle();
    }
}
</script>

<style>
.bg-yellow {
    background-color: yellowgreen;
}
img{
    width:100%!important;
    height: auto!important;
}
.showModal{
    width: 100%;
    margin: 0px;
    max-width: 100%;
    padding-right: 17px;
    display: block;
}
.catbtn{
    width:185px;
    margin:4px;
    float:left;
    font-weight:600;
    text-align:left;
}
</style>
