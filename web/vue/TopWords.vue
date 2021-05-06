<template>
    <div >



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

          fetch(this.$root.apiUrl + '/getTopWords')
          .then((response) => {
              return response.json()
          })
          .then((data) => {

            this.words = _.pluck(data, 'text')
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
