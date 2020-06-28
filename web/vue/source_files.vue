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

                <iframe v-if="selectedPost && selectedPost" :src="selectedPost" style="width: 100%;height:calc(100vh - 100px);
                border: 0;"></iframe>

            </div>
            <div class="table-responsive col-md-4"  >
              <div class="form-group mb-20 notranslate">
                <select class="custom-select" v-model="searchTag" @change="getFiles(searchTag)">
                    <option v-for="(item, indexa) in categories">{{item}}</option>
                </select>
            </div>
            <div style="height: 157px; overflow-y: scroll;" v-if="1 == 0 && posts && showCat">
                <button
                v-for="(item, indexa) in _.keys(_.indexBy(categories, 'category'))" type="button" class="btn btn-outline-primary btn-sm catbtn"
                @click="searchTag = item, getFiles(item)" style=""
                :class="[searchTag == item ? 'btn-primary text-white':'']">
                <span class="notranslate">{{item}}</span><br> <small style="font-size:10px;color: red;">{{item}}</small></button>
            </div>

            <div style="height: calc(100vh - 160px);
            overflow-y: scroll;">
            <table class="table table-striped table-sm" v-if="posts">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="notranslate" v-for="(item, key) in posts" :key="key" v-if="searchTag == item.split('.').pop()">
                        <td>{{key}}</td>
                        <td @click="selectedPost = item.replace('..', '')">{{item.split('/').reverse()[1]}}/{{item.split('/').pop()}}</td>

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
            categories: ['json','pdf','txt','doc','rtf','csv']
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
        getFiles(text) {
            window.scrollTo(0, 0)
            setTimeout(() => {

                fetch('http://sentences.test/api/scan_files.php').then((response) => {
                    return response.json()
                }).then((data) => {
                    this.posts = data.reverse()
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
