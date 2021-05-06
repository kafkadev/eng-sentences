<template>
<div v-if="getData" class="row">

    <left-table ></left-table>
    <right-table :datat="datat" :typet="typet"></right-table>

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
            return this.datat;
        },
        getLastWords() {
            return this.$root.saveWordHistoryCollection1.reverse().slice(0, 8);
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
