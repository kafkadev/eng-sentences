<template>

    <button type="button" class="notranslate btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

        Menu
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="/#/translate-link" @click="toLink($event)">Link</a>
            <a class="dropdown-item" href="/#/translate-raw"  @click="toLink($event)">Raw</a>
            <a class="dropdown-item" href="/#/search"  @click="toLink($event)">Words</a>
            <a class="dropdown-item" href="/#/translate-subtitle"  @click="toLink($event)">Subtitle</a>
            <div class="dropdown-divider"></div>
            <span class="dropdown-item-text"><b>Kaynaklar</b></span>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/#/source-files"  @click="toLink($event)">Files</a>
            <a class="dropdown-item" href="/#/source-best"  @click="toLink($event)">Favorites</a>

            <div class="dropdown-divider"></div>
            <span class="dropdown-item-text"><b>Dış Kaynak</b></span>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/#/source-news"  @click="toLink($event)">Feed</a>
            <a class="dropdown-item" href="/#/source-articles"  @click="toLink($event)">Articles</a>
            <a class="dropdown-item" href="/#/source-video"  @click="toLink($event)">Videos</a>
            <div class="dropdown-divider"></div>
            <span class="dropdown-item-text"><b>Api</b></span>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/manage/db.php?sqlite=&username=admin">Manage</a>
        </div>
    </button>

</template>
<script>
module.exports = {
    name: "user",
    props: ['datat', 'typet'],
    data() {
        return {
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
        getData() {
            return this.datat
        }
    },
    methods: {
        toLink(event){
            console.log(event.target.href.split('/').pop())
            this.$router.push(event.target.href.split('/').pop() ||'/')
        }
    },
    created() {
        //console.log(this.getData);

    }
}
</script>
<style scoped>
.bg-yellow {
    background-color: yellowgreen;
}
</style>
