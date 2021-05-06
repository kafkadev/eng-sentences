<template>
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


            <div style="height: calc(100vh - 160px);overflow-y: scroll;">
                <table class="table table-striped table-sm" v-if="posts">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="notranslate" v-for="(item, key) in posts" :key="key" v-if="1==0 || searchTag == item.split('.').pop()">
                            <td>{{key}}</td>
                            <td @click="selectedPost = item.replace('..', '')">{{item.split('/').pop()}}</td>
                        </tr>

                    </tbody>
                </table>

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
            posts: [],
            categories: ['json','pdf','txt','doc','rtf','csv','vtt','str','srt']
        }
    },
    methods: {

        getFiles(text) {
            window.scrollTo(0, 0)
            setTimeout(() => {

                fetch('/scan_files.php').then((response) => {
                    return response.json()
                }).then((data) => {
                    this.posts = data
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

.catbtn{
    width:185px;
    margin:4px;
    float:left;
    font-weight:600;
    text-align:left;
}
</style>
