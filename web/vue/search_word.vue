<template>
    <div>
        <div v-if="getQueryText" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
            <input  v-on:keyup.enter="searchWord(queryText)" v-model="queryText" class="form-control form-control-dark w-100" type="text" placeholder="arama kelimesi" aria-label="Search" style="
            max-width: 500px;
            ">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="searchWord(queryText)">Set</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="setSource(localWords)">Local</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="setSource(OutsourceWords)">Outsource</button>
                </div>
<nav-list></nav-list>
            </div>
        </div>


<sentences-table :datat="_.pluck(words, 'text')" :typet="'translate_link'"></sentences-table>

    </div>
</template>


<script>
module.exports = {

    data() {
        return {
            queryText: '',
            article: '',
            articleForm: '',
            sourceType: 1,
            words: [],
            min_size: 15,
            max_size: 200,
        }
    },
    computed: {
        getQueryText() {
            if (this.$route.query && this.$route.query.text) {
                this.words = []
                this.queryText = this.$route.query.text
                setTimeout(() => {

                    this.searchWord(this.$route.query.text);
                }, 100);

            }
            return true;
        }
    },
    methods: {
        searchWord(text = '') {
            this.$root.saveWordHistory(text.trim())
            this.words = []
            window.scrollTo(0, 0)
            fetch(this.$root.apiUrl + '/word.php?limit=100&text=' + text.trim() + '&min_size=' + this.min_size).then((response) => {
                return response.json()
            }).then((data) => {
                this.localWords = data.getSearch.map((val) => {
                    val.text = val.text.replace(/(<\s*[^>]*>)/gi, ' ');
                    return val;
                })
                this.words = this.localWords
            })

            fetch(this.$root.apiUrl + '/word_outsource.php?text=' + text.trim() + '&type=word&url=0').then((response) => {
                return response.json()
            }).then((data) => {
                if (data.data) {
                    this.OutsourceWords = data.data.sentences.map((val, key)=> {
                        val['text'] = val['sentence'];
                        return val
                    })
                }

            })

        },
        setSource(arr = []) {
            this.words = []
            setTimeout(() => {
             this.words = arr
         }, 100);
        },
    },

    created() {
        if (this.$route.query && this.$route.query.text) {
            //this.searchWord(this.$route.query.text)
        }
        console.log(this.$route.query)
    }
}
</script>

<style scoped>
.bg-yellow {
    background-color: yellowgreen;
}

tr td.translated {
    color: black;
    font-size: 12px;
}

tr td.translated:hover {
    color: black;
}
</style>
