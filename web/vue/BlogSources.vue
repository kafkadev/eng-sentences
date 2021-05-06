<template>
<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
        <input v-model="queryText" v-on:keyup.enter="getLinks(queryText)"   class="form-control form-control-dark w-100" type="text" placeholder="Başlıklarda Ara" aria-label="Search" style="
    max-width: 60%;
">
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" @click="getLinks(queryText)">Set</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Words</button>
            </div>

            <nav-list></nav-list>
        </div>
    </div>
    <h2 class="hide">Section title</h2>
    <div class="table-responsive" v-if="$root.sourceLinks">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, key) in $root.sourceLinks">
                    <td>{{key}}</td>
                    <td><a class="text-primary text-capitalize font-weight-bold curp"
                        :href="'/#/post/' + item.id">{{$root.decode(item.text)}}</a> </td>
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
            issubtitle: true,
            queryText: '',
            article: '',
            articleForm: '',
            highlightText: '',
            linkText: '',
            minSize: 20,
            regexQuery: '',
            nowDate: new Date().toISOString()
        }
    },
    methods: {

        getLinks(text = '', limit = 10) {
            window.scrollTo(0, 0)
            this.$root.sourceLinks = []
            setTimeout(() => {


                fetch('/blog/wp-json/wp/v2/posts?per_page='+limit+'&search='+text).then((response) => {
                    console.log(response)
                    return response.json()
                }).then((data) => {


                    this.$root.sourceLinks = _.map(data, (val) => {


                        val.text = val.link
                        val.text = val.title.rendered
                        val.id = val.id
                        val.value = val.link
                        return val;
                    })

                    // val.text = val.text.replace(/(<\s*[^>]*>)/gi, ' ');
                })

            }, 100)
        },


    },
    created(){
this.queryText = this.$route.query && this.$route.query.text ? this.$route.query && this.$route.query.text : 'past tense';
                    setTimeout(() => {
                this.getLinks(this.queryText, 60)

            }, 100)

    }
}
</script>

<style scoped>
.bg-yellow {
    background-color: yellowgreen;
}
</style>
