<template>
    <div class="" :class="[$root.tableHelperWords ? 'col-md-6' : 'col-md-6']">
        <template v-if="showIframe && $route.name == 'TranslateLink' && $root.linkText.trim()" v-if="typet = 'translate_link'">

            <iframe v-show="showIframe" id="iframetest" class="notranslate" @load="insertScriptIntoHead" frameborder="0" style="overflow:hidden;height:360px;width:100%" height="900px" width="100%" :src="location.origin+'/api/getLinkFrame?url=' + $root.linkText.trim()">
            </iframe>
        </template>
        <div class="btn-group mr-2 notranslate">
            <button type="button" class="btn btn-sm btn-outline-secondary" @click="currentTab = 'sentences'">Sentences</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" @click="currentTab = 'words'">difference</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" @click="currentTab = 'hiddens'">intersection</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" @click="setMark()">SetMark</button>
            <button v-if="$route.name == 'TranslateLink' &&  $root.linkText.trim().length > 10" type="button" class="btn btn-sm btn-outline-secondary" @click="showIframe = !showIframe">showIframe</button>
        </div>
        <div v-show="currentTab == 'sentences'" class="table-responsive right-table" style="height: calc(100vh - 250px);">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="">Main</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in getData" v-if="item.length > 1 && item.length < 200">
                        <td class="notranslate" @click="$root.saveWordHistorySend(item)"><span class="badge badge-pill badge-warning curp">{{key}}</span></td>
                        <td class="" style="">
                            <span @mouseup="$root.textSelector($event)" class="notranslate  text-primary text-capitalize1 font-weight-bold">
                                {{item.toLowerCase()}}

                            </span>
                            <br>
                            <span>
                                {{item.toLowerCase()}}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="currentTab == 'words'" class="table-responsive" style="height: calc(100vh - 250px);">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="">Main</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indexa) in _.difference($root.sidebarOneToArray(getData.join(' ')), $root.favoritedWords)" :key="indexa" v-if="!$root.banWords(item)">
                        <td class="notranslate" @click="$root.saveWordHistorySend(item)"><span class="badge badge-pill badge-warning curp">{{indexa}}</span></td>
                        <td class="" style="">
                            <span @mouseup="$root.textSelector($event)" class="notranslate  text-primary text-capitalize1 font-weight-bold">
                                {{item}}
                            </span>
                            <br>
                            <span>
                                {{item.replace('.,', '. ').replace(',', ', ').toLowerCase()}}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="currentTab == 'hiddens'" class="table-responsive" style="height: calc(100vh - 250px);">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="">Main</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indexa) in _.intersection($root.sidebarOneToArray(getData.join(' ')), $root.favoritedWords)" :key="indexa">
                        <td class="notranslate" @click="$root.saveWordHistorySend(item)"><span class="badge badge-pill badge-warning curp">{{indexa}}</span></td>
                        <td class="" style="">
                            <span @mouseup="$root.textSelector($event)" class="notranslate  text-primary text-capitalize1 font-weight-bold">
                            {{item.replace('.,', ' . ').replace(',', ' , ').toLowerCase()}} </span>
                            <br>
                            <span>
                                {{item.replace('.,', '. ').replace(',', ', ').toLowerCase()}}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <word-buttons  v-if="currentTab == 'words' && 1==0" :datat="getData.join(' ')" :typet="'translate_link'"></word-buttons>
    </div>
</template>

<script>

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase();
}
// @dblclick="$root.doubleClick(keyw)"
module.exports = {
    name: "RightTable",
    props: ['datat', 'type', 'typet'],
    data() {
        return {
            currentTab: 'sentences',
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
            //console.log('GETDATA', this.datat)

            //__.difference([1, 2, 3, 4, 5], [5, 2, 10])

            let data = this.datat && this.datat.length ? this.datat.map(item => {
                return item.replace('.,', '. ').replace(',', ', ')
                .replace(', ,', ', ')
                .replace(',,', ', ')
                .replace('  ', ' ')
                .replace(/[^a-zA-Z0-9.,’<>'":;| ]/g, '').replace(/(<([^>]+)>)/gi,'').capitalize()
            }) : [];



            return data
        },
        getLastWords() {
            return this.$root.saveWordHistoryCollection1.reverse().slice(0, 8);
        }
    },
    methods: {
        setMark() {
            var rightTable = $(".right-table span.notranslate")
            var favoritedWords = _.difference(this.$root.sidebarOneToArray(this.getData.join(' ')), this.$root.favoritedWords)

            _.chunk(favoritedWords, 500).map((favchunk) => {
                setTimeout(() => {
                    favchunk.map((value) => {
                        if (value.length > 3) {
                            rightTable.each((index, el) => {
                                if (el.innerText.includes(value)) {
                                 el.innerHTML =  el.innerHTML.replace(value, '<mark>' + value + '</mark>')
                                 return false;
                             };
                             console.log(index)
                         })
                        };
                    })
                }, 2000)

            })


        },

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
mark{
    padding: 0;
    background: yellow;
    color: black;
}
</style>
