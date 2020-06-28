<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
            <textarea rows="6" v-on:keyup.enter="setArticle()" name="text" v-model="$root.articleForm" class="form-control form-control-dark w-100" type="text" placeholder="Buraya büyük yazı bloku veya paragraf" style="
            max-width: 80%;
            "></textarea>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="setArticle()">Set</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
<nav-list></nav-list>
            </div>
        </div>
        <h2 class="hide">Section title</h2>



<sentences-table :datat="$root.matchArticleToArray($root.articleText, issubtitle)" :typet="'translate_link'"></sentences-table>
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
            regexQuery: '',
            issubtitle: false,
        }
    },
    methods: {
        setArticle() {
            this.$root.articleText = ''
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
        getArticle(){
            window.scrollTo(0, 0)
            setTimeout(() => {

              fetch(this.$root.apiUrl + '/raw_clean.php?url='+this.$root.linkText.trim()).then((response) => {
                return response.json()
            }).then((data) => {
                this.$root.articleText = this.$root.rawDataClean(data.body)
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
