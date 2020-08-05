<template>
      <nav class="col-md-1 d-none d-md-block bg-light sidebar pt0 notranslate hide2" style="padding:0">
                <div class="sidebar-sticky">
                          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Tools</span>
                      </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#/translate-link">

                                Get Link
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#/translate-raw">
                                Raw Content
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#/search">

                                Words
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Sources</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="/#/">Lang Source</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#/source-news">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#/source_favorite_words"> Best Words </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#/source_favorite_sentences"> Best Sentences </a>
                            <a class="nav-link" href="/#/source_dictionary"> S.Dictionary </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#/SourceSubtitle"> Subtitles </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> Stories </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> Files </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#/source-video"> Videos </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Dil Bilgisi</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="/#">
                                Kalıplar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> Modal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> Irregular Verbs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> Verbs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> Adjectives</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#"> infinitive</a>
                        </li>
                    </ul>

<div class="btn-group hide" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary">Left</button>
  <button type="button" class="btn btn-secondary">Middle</button>
  <button type="button" class="btn btn-secondary">Right</button>
</div>

<div class="input-group mb-3" style="
    position: absolute;
    bottom: 0px;
">
  <input v-model="$root.sidebarAddWordText" type="text" class="form-control" placeholder="word@note" aria-label="word" aria-describedby="basic-addon2">
  <div style="cursor:pointer;" class="input-group-append" @click="$root.saveWordHistorySend($root.sidebarAddWordText)">
    <span class="input-group-text" id="basic-addon2">add</span>
  </div>
</div>

                </div>
            </nav>

</template>

<script>
module.exports = {
          data() {
      return {
      }
  },
  methods: {}
}
</script>

<style>
.hello {
    background-color: #ffe;
}
</style>

