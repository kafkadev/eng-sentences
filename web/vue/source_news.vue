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
                        :href="'/#/TranslateLink?text=' + item.value">{{$root.decode(item.text)}}</a> - {{item.url.split('/')[2]}}</td>
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
            sourceDomains: [
                'https://www.techradar.com/',
                'https://www.pcworld.com/',
                'https://www.engadget.com/tags/cameras/',
                'https://www.digitaltrends.com/',
                'https://ourcodeworld.com/',
                'https://css-tricks.com/archives/',
                'https://techcrunch.com/startups/',
                'https://dev.to/latest',
                'https://dev.to/t/css/latest',
                'https://www.latimes.com/science',
                'https://medium.com/tag/css',
                'https://medium.com/tag/javascript',
                'https://www.clickz.com/type/news/',
                'https://www.dailywritingtips.com/category/expressions/',
            ],
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

        getLinks(text = '') {
            window.scrollTo(0, 0)
            setTimeout(() => {


                fetch('/api/getLinks/'+text).then((response) => {
                    console.log(response)
                    return response.json()
                }).then((data) => {


                    this.$root.sourceLinks = _.map(data, (val) => {


                        val.text = val.title
                        val.value = val.url
                        return val;
                    })

                    // val.text = val.text.replace(/(<\s*[^>]*>)/gi, ' ');
                })

            }, 100)
        },


    },
    created(){
                    setTimeout(() => {

                this.getLinks('css')

            }, 100)

    }
}
</script>

<style scoped>
.bg-yellow {
    background-color: yellowgreen;
}
</style>
