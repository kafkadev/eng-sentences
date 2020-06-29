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
                    <select class="custom-select" v-model="queryText" @change="getWordList(queryText)">
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
            categories: ['bilinmeyen'],
            min_size: 20
        }
    },
    computed: {
        getData() {
            this.words = [];
            if (this.$route.query && this.$route.query.text) {

                this.queryText = this.$route.query.text
                setTimeout(() => {
                    this.$root.all_words[queryText]
                }, 100);

            }
            return true;
        }
    },
    methods: {
        getWordList(cat, type = 0) {
            this.words = [];

            if (cat && !type) {
                setTimeout(() => {
                    if (cat == 'irregular_verbs') {

                        this.words = _.flatten(_.values(this.$root.all_words[this.queryText]).map(val => val.join(' | ')))
                    }
                    else if (cat == 'units_of_time') {

                        this.words = _.flatten(_.values(this.$root.all_words[this.queryText]))
                    }
                    else if (['compounds','general_verbs','pairs','personal_pronouns','possessive_pronouns', 'state_verbs'].includes(cat)) {

                        this.words = _.flatten(this.$root.all_words[this.queryText].map(val => _.values(val).join(' | ')))
                    }

                    else if (['units_of_time','proverbs'].includes(cat)) {

                        this.words = _.flatten(_.values(this.$root.all_words[this.queryText].map(val => _.values(val))))
                    }
                    else if (['word_clues'].includes(cat)) {
                        var sources = this.$root.all_words[this.queryText];
                        this.words =   _.keys(sources).map(key => key + ': ' + sources[key].join(' | ') )


                    }
                    else {
                      this.words = this.$root.all_words[this.queryText]
                  }
                //  console.log(this.$root.all_words[this.queryText])
              }, 100);

            } else{
                                   if (cat == 'irregular_verbs') {

                        return _.flatten(_.values(this.$root.all_words[cat]).map(val => val.join(' | ')))
                    }
                    else if (cat == 'units_of_time') {

                        return _.flatten(_.values(this.$root.all_words[cat]))
                    }
                    else if (['compounds','general_verbs','pairs','personal_pronouns','possessive_pronouns', 'state_verbs'].includes(cat)) {

                        return _.flatten(this.$root.all_words[cat].map(val => _.values(val).join(' | ')))
                    }

                    else if (['units_of_time','proverbs'].includes(cat)) {

                        return _.flatten(_.values(this.$root.all_words[cat].map(val => _.values(val))))
                    }
                    else if (['word_clues'].includes(cat)) {
                        var sources = this.$root.all_words[cat];
                        return   _.keys(sources).map(key => key + ': ' + sources[key].join(' | ') )


                    }
                    else {
                      return this.$root.all_words[cat]
                  }
            }


        },
        getWords() {

          fetch(this.$root.apiUrl + '/getFavorites')
          .then((response) => {
              return response.json()
          })
          .then((data) => {
            this.categories = _.keys(this.$root.all_words).sort()
            this.words = _.pluck(data, 'text').reverse()
           // console.log(data)
        });

      },

  },

  created() {
let demosa = {}
_.keys(this.$root.all_words).map((key) => {
demosa[key] = this.getWordList(key, 1).map((value, keya) => key + ';' + value)
})
//setTimeout(() => console.log(demosa), 5000)

setTimeout(() => localStorage.setItem('data01', JSON.stringify(demosa)), 5000)
    this.getWords()
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
