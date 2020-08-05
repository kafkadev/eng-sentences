<template>
  <div v-if="getData" class="row">
    <div class="col-md-6" v-if="$root.tableHelperWords">
      <div class="btn-toolbar show notranslate mb-20">
        <div class="btn-group mr-2">
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(1)" :class="[showModeLeft == 1 ? 'btn-primary color-white' : '']">
            Sentences
            <b>{{$root.leftTable.getSearch ? $root.leftTable.getSearch.length : 0}}</b>
             </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(2)" :class="[showModeLeft == 2 ? 'btn-primary color-white' : '']">
            Dictionary
            <b>{{$root.leftTable.getDict ? $root.leftTable.getDict.length : 0}}</b>
             </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(3)" :class="[showModeLeft == 3 ? 'btn-primary color-white' : '']">
            Videos
            <b>{{$root.leftTable.getVideos ? $root.leftTable.getVideos.length : 0}}</b>
             </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(4)" :class="[showModeLeft == 4 ? 'btn-primary color-white' : '']">
            Articles
            <b>{{$root.leftTable.getArticles ? $root.leftTable.getArticles.length : 0}}</b>
             </button>
             <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(8)" :class="[showModeLeft == 8 ? 'btn-primary color-white' : '']">
            Subtitles
            <b>{{$root.leftTable.getSubtitles ? $root.leftTable.getSubtitles.length : 0}}</b>
             </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(5)" :class="[showModeLeft == 5 ? 'btn-primary color-white' : '']">
            Best Words
            <b>{{$root.leftTable.getWords ? $root.leftTable.getWords.length : 0}}</b>
             </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(7)" :class="[showModeLeft == 7 ? 'btn-primary color-white' : '']">
            Dict Family
            <b>{{$root.leftTable.getDictFamily ? $root.leftTable.getDictFamily.length : 0}}</b>
             </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(6)" :class="[showModeLeft == 6 ? 'btn-primary color-white' : '']">
            Viewer <b></b>
           </button>
        </div>
      </div>
<h2 class="notranslate">{{$root.highlightText || 'empty'}} </h2>
<h3 class="notranslate" v-if="$root.saveWordHistoryCollection1.length > 0">
  <span class="notranslate  text-primary text-capitalize1 font-weight-bold" v-for="(keyw, kin) in getLastWords" @click="$root.textSelector($event)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9]+)/gi, ''))">
                {{keyw}},
              </span> </h3>
      <div class="card" v-if="showModeLeft == 6">
        <div class="card-header notranslate">viewer</div>
        <iframe v-if="viewer.type == 'url'" :src="viewer.data.content" style="width: 100%;height:calc(100vh - 100px);
        border: 0;"></iframe>
        <iframe v-if="viewer.type == 'video'" id="ytplayer" allowFullScreen="allowFullScreen" frameBorder="0" type="text/html" width="100%" height="680"
        :src="'https://www.youtube.com/embed/'+viewer.data.resourceId.split('v=')[1]+'?autoplay=1&origin=http://example.com'"
        frameborder="0"></iframe>
      </div>



    <div class="table-responsive" style="height: calc(100vh - 160px);"  v-if="showModeLeft == 1">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th class="">Main</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, key) in _.pluck($root.leftTable.getSearch, 'text')" v-if="item.length > 15">
            <td class="notranslate" @click="$root.saveWordHistorySend(item)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
            <td class="">
              <span class="notranslate  text-primary text-capitalize1 font-weight-bold" v-for="keyw in item.split(' ')" @mouseup="$root.textSelector($event)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9]+)/gi, ''))">
                {{keyw}}
              </span>
              <br>
              <span>
                {{item}}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="table-responsive" style="height: calc(100vh - 160px);"  v-if="showModeLeft == 8">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th class="">Main</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, key) in _.pluck($root.leftTable.getSubtitles, 'text')" v-if="item.length > 15">
            <td class="notranslate" @click="$root.saveWordHistorySend(item)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
            <td class="">
              <span class="notranslate  text-primary text-capitalize1 font-weight-bold" v-for="keyw in item.replace(',', ', ').replace('-the-next-generation','').replace('-','').split(' ')" @mouseup="$root.textSelector($event)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9]+)/gi, ''))">
                {{keyw}}
              </span>
              <br>
              <span>
                {{item.replace(',', ', ').replace('-the-next-generation','').replace('-','_')}}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

        <div v-if="showModeLeft == 2" style="height: calc(100vh - 160px); overflow-y: scroll;">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>type</th>
            <th>title</th>
          </tr>
        </thead>
        <tbody>
          <tr class="" v-for="(item, key) in $root.leftTable.getDict" :key="key">
            <td class="notranslate" @click="$root.saveWordHistorySend(item.word + ': ' + item.desc)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
            <td class="notranslate">{{item.type}}|{{item.word}}</td>
            <td class="">

             <span  class="notranslate text-primary text-capitalize1 font-weight-bold"> <span class="" v-for="keyw in item.desc.split(' ')" @mouseup="$root.textSelector($event)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9;':?]+)/gi, ''))">
                {{keyw}}
              </span>
              </span>
              <br>
              <span>
                {{item.desc}}
              </span>
          </td>

          </tr>

        </tbody>
      </table>

    </div>
    <div class="table-responsive" style="height: calc(100vh - 150px);"   v-if="showModeLeft == 3">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, key) in $root.leftTable.getVideos" :class="">
            <td>{{item.ID}} </td>
            <td>
              <a :href="item.resourceId">

                {{item.title}}
              </a>
            </td>
            <td>
              <img class="video_img" @click="setViewer('video',item)"  :src="item.image" style="">
            </td>
          </tr>
        </tbody>
      </table>
    </div>


    <div v-if="showModeLeft == 4" style="height: calc(100vh - 160px); overflow-y: scroll;">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>category</th>
            <th>title</th>
          </tr>
        </thead>
        <tbody>
          <tr class="notranslate" v-for="(item, key) in $root.leftTable.getArticles" :key="key">
            <td>{{item.id}}</td>
            <td>{{item.category}}</td>
            <td class="text-primary text-capitalize1 font-weight-bold curp" v-html="item.title" @click="setViewer('url',item)">{{item.title}}
            </td>
            <td>{{new URL(item.content).hostname}}</td>

          </tr>

        </tbody>
      </table>

    </div>
    <div v-if="showModeLeft == 5" style="height: calc(100vh - 160px); overflow-y: scroll;">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>type</th>
            <th>title</th>
          </tr>
        </thead>
        <tbody>
          <tr class="" v-for="(item, key, index) in $root.leftTable.getWords" :key="key">
            <td  class="notranslate" @click="$root.saveWordHistorySend(item.type + ': ' + item.text)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
            <td class="notranslate">{{item.type}}</td>
            <td class="">

              <span class="notranslate  text-primary text-capitalize1 font-weight-bold" v-for="keyw in item.text.split(' ')" @mouseup="$root.textSelector($event)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9]+)/gi, ''))">
                {{keyw}}
              </span>
              <br>
              <span>
                {{item.text}}
              </span>
          </td>

          </tr>

        </tbody>
      </table>

    </div>
    <div v-if="showModeLeft == 7" style="height: calc(100vh - 160px); overflow-y: scroll;">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>type</th>
            <th>title</th>
          </tr>
        </thead>
        <tbody>
          <tr class="" v-for="(item, key) in $root.leftTable.getDictFamily" :key="key">
            <td  class="notranslate" @click="$root.saveWordHistorySend(item.type + ': ' + item.text)"><span class="badge badge-pill badge-warning curp">{{item.ID}}</span></td>
            <td class="notranslate">{{item.type}}</td>
            <td class="">

              <span class="notranslate  text-primary text-capitalize1 font-weight-bold" v-for="keyw in item.text.split(' ')" @mouseup="$root.textSelector($event)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9]+)/gi, ''))">
                {{keyw}}
              </span>
              <br>
              <span>
                {{item.text}}
              </span>
          </td>

          </tr>

        </tbody>
      </table>

    </div>

    <word-buttons v-if="1==0" :datat="_.pluck($root.tableHelperWords, 'text').join(' ')" :typet="'translate_link'"></word-buttons>
  </div>
  <div class="" :class="[$root.tableHelperWords ? 'col-md-6' : 'col-md-6']">
    <div class="table-responsive" style="height: calc(100vh - 130px);">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th class="">Main</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, key) in getData" v-if="item.length > 1">
            <td class="notranslate" @click="$root.saveWordHistorySend(item)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
            <td class="" style="">
              <span @mouseup="$root.textSelector($event)" class="notranslate  text-primary text-capitalize1 font-weight-bold" v-for="keyw in item.replace('.,', '. ').replace(',', ', ').replace(', ,', ', ').replace(',,', ', ').replace('  ', ' ').split(' ')" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9’;:',]+)/gi, ''))" :class="$root.highlightText && $root.highlightText === $root.replaceSidebarAtoZ(keyw) ? 'bg-yellow' : ''">
                {{keyw}}
              </span>
              <br>
              <span>
                {{item.replace('.,', '. ').replace(',', ', ')}}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <word-buttons v-if="1==0" :datat="getData.join(' ')" :typet="'translate_link'"></word-buttons>
  </div>
</div>
</template>
<script>
// @dblclick="$root.doubleClick(keyw)"
module.exports = {
  name: "user",
  props: ['datat', 'type'],
  data() {
    return {
      selectedVideo: 0,
      article: '',
      showModeLeft: 1,
      articleForm: '',
      highlightText: '',
      linkText: '',
      minSize: 20,
      showDictionary: true,
      showWordsTab: false,
      regexQuery: '',
      viewer: {type: 'none', data: {}},
    }
  },
  computed: {
    getData() {
      return this.datat;
    },
    getLastWords() {
      return this.$root.saveWordHistoryCollection1.reverse().slice(0, 8);
    }
  },
  methods: {
    setTabLeft(tabId){
this.showModeLeft = 0
setTimeout(()=> {

this.showModeLeft = tabId
}, 300)
    },
    setViewer(type, data){
      this.viewer.type = type
      this.viewer.data = data
    }
  }
}
</script>
<style scoped>
.bg-yellow {
  background-color: yellowgreen;
}
.mb-20{
  margin-bottom: 20px;
}
.color-white{
  color:white !important;
}
</style>
