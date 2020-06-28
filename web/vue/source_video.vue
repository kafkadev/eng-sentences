<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom notranslate">
            <input v-on:keyup.enter="getVideos(sourceId, getMode)" v-model="sourceId" class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" style="
            max-width: 60%;
            ">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="getVideos(sourceId, getMode)">Get</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" :class="[getMode == 'playlist' ? 'btn-primary text-white' : '']" @click="getMode = 'playlist',getVideosApi(sourceId, getMode)">Playlist</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" :class="[getMode == 'channel' ? 'btn-primary text-white' : '']" @click="getMode = 'channel', getVideosApi(sourceId, getMode)">Channel</button>
                </div>
                <div class="form-group mb-0">
                    <select class="custom-select" v-model="queryText" @change="getLinks(queryText)">
                        <option value="">Select a Source</option>
                        <option v-for="(item, key) in sourceDomains">{{item}}</option>
                    </select>

                </div>
                <nav-list></nav-list>
            </div>
        </div>
        <h2 class="hide">Section title</h2>
        <div class="row row-cols-1 row-cols-md-6 hide">
          <div class="col mb-2" v-for="(item, key) in videos">
            <div class="card h-100">
              <img :src="item.image" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{item.title}}</h5>
                <p class="card-text hide">This is a short card.</p>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-8">
        <div v-if="selectedVideo" >

            <iframe id="ytplayer" allowFullScreen="allowFullScreen" frameBorder="0" type="text/html" width="100%" height="680"
            :src="'https://www.youtube.com/embed/'+selectedVideo.resourceId.split('v=')[1]+'?autoplay=1&origin=http://example.com'"
            frameborder="0"></iframe>
        </div>
        <h3>
            {{selectedVideo.ID}}: {{selectedVideo.title}}
        </h3>
    </div>
    <div class="col-md-4">
        <div class="table-responsive" style="height: calc(100vh - 150px);">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in videos" :class="[selectedVideo.resourceId == item.resourceId ? 'bg-yellow' : '']">
                      <td>{{item.ID}} </td>
                      <td>
                        <a :href="item.resourceId">

                            {{item.title}}
                        </a>
                    </td>
                    <td>
                        <img class="video_img" @click="selectedVideo = item"  :src="item.image" style="">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

</div>
</template>

<script>
//http://sentences.test/api/youtubeapi.php?type=channel&playlistId=PLxX2m2Np79VfE8qgLtUZHwCF0VyuFH8QI&channelId=UC13zcuPSSBkmUXnj41BPFTA
module.exports = {

    data() {
        return {
            sourceDomains: [
            'https://www.techradar.com/',
            'https://www.pcworld.com/',
            'https://www.engadget.com/tags/cameras/',
            'https://www.digitaltrends.com/',
            'https://ourcodeworld.com/',
            'https://css-tricks.com/archives/',
            'https://techcrunch.com/startups/',
            'https://dev.to/latest',
            'https://dev.to/t/css/latest',
            'https://www.latimes.com/science',
            'https://medium.com/tag/css',
            'https://medium.com/tag/javascript',
            'https://www.clickz.com/type/news/',
            'https://www.dailywritingtips.com/category/expressions/',
            ],
            selectedVideo: 0,
            issubtitle: true,
            queryText: '',
            article: '',
            articleForm: '',
            highlightText: '',
            linkText: '',
            minSize: 20,
            sourceId: 'çeviri',
            regexQuery: '',
            getMode: 'channel',
            videos: [],
        }
    },
    methods: {
        getVideos(text, type) {
            window.scrollTo(0, 0)
            setTimeout(() => {

                fetch('http://sentences.test/api/NewsSources.php?type=video&text=' + text).then((response) => {
                    return response.json()
                }).then((data) => {
                    console.log(data);
                    this.videos = data
                })

            }, 100)
        },
        getVideosApi(id = 0, type = 'channel') {
            this.videos = []
            this.sourceId = 0
            window.scrollTo(0, 0)
            setTimeout(() => {

                fetch('http://sentences.test/api/youtubeapi.php?type='+type+'&playlistId='+id+'&channelId=' + id).then((response) => {
                    return response.json()
                }).then((data) => {

                    if (type == 'playlist') {

                        this.videos = data
                    } else {
                        this.videos = _.flatten(_.pluck(data, 'videos'))
                    }

                    console.log(this.videos)
                })

            }, 100)
        },

    }
}
</script>

<style scoped>
.bg-yellow {
    background-color: yellowgreen!important;
}
.video_img{
    height: 30px;
}
</style>
