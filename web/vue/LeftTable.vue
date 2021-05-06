<template>

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
                <button type="button" class="btn btn-sm btn-outline-secondary hide" @click="setTabLeft(3)" :class="[showModeLeft == 3 ? 'btn-primary color-white' : '']">
                    Videos
                    <b>{{$root.leftTable.getVideos ? $root.leftTable.getVideos.length : 0}}</b>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary hide" @click="setTabLeft(4)" :class="[showModeLeft == 4 ? 'btn-primary color-white' : '']">
                    Articles
                    <b>{{$root.leftTable.getArticles ? $root.leftTable.getArticles.length : 0}}</b>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" @click="setTabLeft(5)" :class="[showModeLeft == 5 ? 'btn-primary color-white' : '']">
                    BestWords
                    <b>{{$root.leftTable.getWords ? $root.leftTable.getWords.length : 0}}</b>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary hide" @click="setTabLeft(6)" :class="[showModeLeft == 6 ? 'btn-primary color-white' : '']">
                    Viewer <b></b>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary " @click="setTabLeft(7)" :class="[showModeLeft == 7 ? 'btn-primary color-white' : '']">
                    Synonyms
                    <b>{{$root.leftTable.getSynonyms ? $root.leftTable.getSynonyms.length : 0}}</b>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary hide" @click="setTabLeft(8)" :class="[showModeLeft == 8 ? 'btn-primary color-white' : '']">
                    Subtitles
                    <b>{{$root.leftTable.getSubtitles ? $root.leftTable.getSubtitles.length : 0}}</b>
                </button>
            </div>
        </div>
        <h2 class="notranslate">{{$root.highlightText || 'empty'}} </h2>
        <div class="notranslate btn-group" v-if="$root.saveWordHistoryCollection1.length > 0">
            <button class="notranslate  text-primary text-capitalize1 font-weight-bold btn btn-sm btn-outline-secondary" v-for="(keyw, kin) in getLastWords"
            @click="$root.searchWord(keyw)" @click.middle="$router.push('search?text=' + keyw.toLowerCase().replace(/([^a-z0-9]+)/gi, ''))">
            {{keyw}}
        </button>
    </div>



    <!-- Sentences -->
    <div  v-if="showModeLeft == 1" class="table-responsive" style="height: calc(100vh - 350px);">
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

    <!-- Dictionary -->
    <div v-if="showModeLeft == 2" style="height: calc(100vh - 350px); overflow-y: scroll;">
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
                    <td style="white-space:nowrap;" class="notranslate">{{item.type}}|{{item.word}}</td>
                    <td class="">



                    <div v-for="keyw in item.defn.split('\n')" v-if="keyw">
                        <span class="notranslate text-primary text-capitalize1 font-weight-bold" style="white-space: pre-line;" @mouseup="$root.textSelector($event)">
                            {{keyw}}
                        </span>
                        {{keyw}}
                    </div>
                </td>
            </tr>

        </tbody>
    </table>

</div>

<!-- Videos -->
<div  v-if="showModeLeft == 3" class="table-responsive" style="height: calc(100vh - 150px);">
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
                    <img class="video_img" @click="setViewer('video',item)" :src="item.image" style="">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Articles -->
<div v-if="showModeLeft == 4" style="height: calc(100vh - 350px); overflow-y: scroll;">
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
<!-- BestWords -->
<div v-if="showModeLeft == 5" style="height: calc(100vh - 350px); overflow-y: scroll;">
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
                <td class="notranslate" @click="$root.saveWordHistorySend(item.type + ': ' + item.text)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
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

<!-- Viewer -->
<div class="card" v-if="showModeLeft == 6">
    <div class="card-header notranslate">viewer</div>
    <iframe v-if="viewer.type == 'url'" :src="viewer.data.content" style="width: 100%;height:calc(100vh - 100px);
    border: 0;"></iframe>
    <iframe v-if="viewer.type == 'video'" id="ytplayer" allowFullScreen="allowFullScreen" frameBorder="0" type="text/html" width="100%" height="680" :src="'https://www.youtube.com/embed/'+viewer.data.resourceId.split('v=')[1]+'?autoplay=1&origin=http://example.com'" frameborder="0"></iframe>
</div>


<!-- Synonyms -->
<div v-if="showModeLeft == 7" style="height: calc(100vh - 350px); overflow-y: scroll;">
    <table class="table table-striped table-sm">
        <thead>
            <tr>

                <th>synonyms</th>
                <th>antonyms</th>
            </tr>
        </thead>
        <tbody>
            <tr class="" v-for="(item, key) in $root.leftTable.getSynonyms" :key="key">

                <td>
                    <template v-for="keyw in item.synonyms.split(',')">
                        <span class="notranslate  text-primary text-capitalize1 font-weight-bold"  @mouseup="$root.textSelector($event)">

                            {{keyw}}
                        </span>
                        <br/>
                        <span>
                            {{keyw}}
                        </span>
                        <br/>
                    </template>


                </td>
                <td class="">

                    <span class="notranslate  text-primary text-capitalize1 font-weight-bold"  @mouseup="$root.textSelector($event)">

                        {{item.antonyms}}
                    </span>
                    <br>
                    <span>
                        {{item.antonyms}}
                    </span>
                </td>

            </tr>

        </tbody>
    </table>

</div>

<!-- Subtitles -->
<div  v-if="showModeLeft == 8" class="table-responsive" style="height: calc(100vh - 350px);">
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



</div>


</template>

<script>
// @dblclick="$root.doubleClick(keyw)"
module.exports = {
    name: "user",
    props: ['datat', 'type', 'typet'],
    data() {
        return {
            showIframe: 0,
            selectedVideo: 0,
            article: '',
            showModeLeft: 5,
            articleForm: '',
            highlightText: '',
            linkText: '',
            minSize: 20,
            showDictionary: true,
            showWordsTab: false,
            regexQuery: '',
            viewer: {
                type: 'none',
                data: {}
            },
        }
    },
    computed: {
        getData() {
            console.log('GETDATA', this.datat)

            return this.datat;
        },
        getLastWords() {
            return this.$root.saveWordHistoryCollection1.slice(0, 10);
        }
    },
    methods: {
        setTabLeft(tabId) {
            this.showModeLeft = 0
            setTimeout(() => {

                this.showModeLeft = tabId
            }, 300)
        },
        setViewer(type, data) {
            this.viewer.type = type
            this.viewer.data = data
        },
        insertScriptIntoHead() {

            this.showIframe = 1;
            // just do anything
            //document.getElementById('iframetest').contentDocument.body.prepend("Hello, world1!");

            // var head = document.getElementById('iframetest').contentWindow.document.getElementsByTagName('head')[0];
            var script = document.getElementById('iframetest').contentWindow.document.createElement('script');
            script.textContent = `
            if (!location.host.split(".").includes("test")) {
                if (!window.console) window.console = {};
                var methods = [
                "log",
                "debug",
                "warn",
                "info",
                "error",
                "trace",
                "dir",
                "dirxml",
                "group",
                "groupEnd",
                "time",
                "timeEnd",
                "assert",
                "profile",
                ];
                for (var i = 0; i < methods.length; i++) {
                    console[methods[i]] = function() {};
                }
            }
            console.log(document.title)
            document.addEventListener('mouseup', (e) => {
                //e.preventDefault();
                var text = window.getSelection().toString()
                if (text.trim()) {
                   /* parent.postMessage(text, "*")
                   console.log(text, 'mouseup action initiated')
                   */
               };
           });
           document.addEventListener('dblclick', (e) => {
            //e.preventDefault();
            var text = window.getSelection().toString()
            if (text.trim()) {
              parent.postMessage(text, "*")
              console.log(text, 'dblclick action initiated')
          };
      });
      /*
      window.addEventListener('message', function (e) {
        var mainWindow = e.source;
        console.log(e)
        mainWindow.postMessage('burası ifr4ame', e.origin);
    });
    */

    `;
    script.type = 'text/javascript';
    script.id = 'iframecontent';
    document.getElementById('iframetest').contentDocument.body.appendChild(script);
            //head.appendChild(script);
        }
    },
    mounted() {

        var self = this.$root
        window.addEventListener("message", function (e) {
            self.textSelectorEvent(e.data)

        });
    }
}
</script>

<style scoped>
.bg-yellow {
    background-color: yellowgreen;
}

.mb-20 {
    margin-bottom: 20px;
}

.color-white {
    color: white !important;
}
</style>
