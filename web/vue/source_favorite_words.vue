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
                    <select class="custom-select" v-model="queryText">
                        <option value="">Select a Category</option>
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

    },
    methods: {

        getWords() {

          fetch(this.$root.apiUrl + '/getFavoriteWords')
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
