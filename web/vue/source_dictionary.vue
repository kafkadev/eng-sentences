<template>
    <div >
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
            <input v-model="queryText" class="form-control form-control-dark w-100" type="text" placeholder="Text" aria-label="Search" style="
            max-width: 500px;
            ">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Set</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Local</button>
                </div>
                <div class="form-group mb-0 mr-10" style="margin-right: 10px;">
                    <select class="custom-select" v-model="queryText" @change="getWords(queryText)">
                        <option value="">Select a Category</option>
                        <option v-for="(item, key) in categories">{{item}}</option>
                    </select>

                </div>
                <nav-list></nav-list>
            </div>
        </div>


        <sentences-table v-if="queryText && words" :datat="words" :typet="'translate_link'"></sentences-table>
    </div>
</template>


<script>
module.exports = {

    data() {
        return {
            queryText: 'nouns',
            article: '',
            articleForm: '',
            sourceType: 1,
            words: [],
            categories: ["possessive_pronouns","strong_words","infinitive_verbs","nouns","proverbs","commonWords","ergative_verbs","state_verbs","general_verbs","adverbs","pairs","rhymelees_words","personalNouns","irregular_verbs","units_of_time","word_clues","sentences","personal_pronouns","adjs","states_of_drunkenness","compounds","prepositions","resume_action_words","interjections","encouraging_words","phrasal_verb","irregular_verbs01"
].sort(),
            min_size: 20
        }
    },
    computed: {},
    methods: {
        getWordList(cat, type = 0) {},
        getWords(cat) {
this.words = [];
          fetch(this.$root.apiUrl + '/getDictionarySentences/' + cat)
          .then((response) => {
              return response.json()
          })
          .then((data) => {
            this.words = _.pluck(data, 'text')
        });

      },

  },

  created() {

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
