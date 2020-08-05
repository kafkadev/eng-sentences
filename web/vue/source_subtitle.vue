<template>
  <div v-if="getQueryText">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
      <input @change="getFile" name="subtitle" v-model="fileData" class="form-control form-control-dark w-100" type="file" placeholder="Text" aria-label="Search" style="
      max-width: 80%;
      ">
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="$root.articleText = 0, getArticle()">Set</button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="showWordsTab = !showWordsTab">Words</button>
          <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>


      <nav-list></nav-list>
  </div>
</div>




<sentences-table v-if="$root.articleTextArr" :datat="$root.articleTextArr" :typet="'translate_link'"></sentences-table>
</div>
</template>



<script>
var xmlhttp = null;
module.exports = {

  data() {
    return {
      fileData: null,
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
    getQueryText() {
      if (this.$route.query && this.$route.query.text) {
        this.$root.linkText = this.$route.query.text
        this.getArticle()

    }
    return true;
}
},
methods: {
    getFile(e){
        console.log(e.target.files[0].name.split('.').slice(-1)[0])
        if (e.target.files[0].name.split('.').slice(-1)[0] == 'srt') {

            this.loadSrt(e)
        } else if (e.target.files[0].name.split('.').slice(-1)[0] == 'vtt') {
            this.loadVtt(e)
        }



    },

    loadSrt(e){

        e.target.files[0].text().then(content => {
           content = content.split("\r\n\r\n").map((item) => {
            item = item.split("\r\n").splice(2).join(', ');
            return item;
        })
           this.$root.articleTextArr = content
           console.log(content.filter(x => x))

       })


    },
    loadVtt(e){

        e.target.files[0].text().then(content => {
           content = content.split("\r\n\r\n").map((item) => {
            item = item.split("\r\n").splice(1).join(', ');
            return item;
        })
           this.$root.articleTextArr = content
           console.log(content.filter(x => x))

       })


    },
    loadCSV(url)
    {

      fetch(url)
      .then((response) => {
        return response.text();
    })
      .then((content) => {
       content = content.split("\r\n\r\n").map((item) => {
        item = item.split("\r\n");
        return item;
    })
       this.$root.articleTextArr = content
       console.log(content.filter(x => x))
      // document.getElementById('frm').innerHTML = content.filter(x => x).join("<br>");
  });
   /* xmlhttp=null;
           // code for Mozilla, etc.
           if (window.XMLHttpRequest)
           {
             xmlhttp=new XMLHttpRequest();
           }
           // code for IE
           else if (window.ActiveXObject)
           {
             xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
           }

           if (xmlhttp!=null)
           {
             xmlhttp.onreadystatechange=state_Change;
             xmlhttp.open("GET",url,true);
             xmlhttp.send(null);
           }
           else
           {
             alert("Your browser does not support XMLHTTP.");
         }*/
     },

     state_Change()
     {
          // if xmlhttp shows "loaded"
          if (xmlhttp.readyState==4)
          {
            // if "OK"
            if (xmlhttp.status==200)
            {
              var content = xmlhttp.responseText;
             // console.log(content.split("\r\n\r\n"))
             content = content.split("\r\n\r\n").map((item) => {
              item = item.split("\r\n").splice(1).join(', ');
              return item;
          })
             console.log(content)

            /*content = content.replace(/</g, '&lt;');
              content = content.replace(/>/g, '&gt;');
              content = content.replace(/\n/g, '<br>');*/

              document.getElementById('frm').innerHTML = content.join("<br>");
          }
          else
          {
              alert("Problem retrieving CSV file");
          }
      }
  },
  getArticle(){
      window.scrollTo(0, 0)
      this.$root.articleText = ''
      setTimeout(() => {

        fetch(this.$root.apiUrl + '/getLink?url='+this.$root.linkText.trim()).then((response) => {
          return response.json()
      }).then((data) => {
         console.log(data)
         this.$root.articleTextArr = _.pluck(data, 'text')
         this.$root.articleText = this.$root.rawDataClean(_.pluck(data, 'text').join(' '))
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
