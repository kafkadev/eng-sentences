<template>
    <!-- section -->
    <div class="section">
      <!-- container -->
      <div class="container">
        <!-- row -->
        <div class="row">
          <!-- Post content -->
          <div class="col-md-8">
            <div class="section-row sticky-container">
              <div class="main-post">
                <h3>{{post.title ? post.title.rendered : ''}}</h3>
                <p v-html="post.content.rendered">{{post.content.rendered}}</p>
              </div>

            </div>







          </div>
          <!-- /Post content -->

          <!-- aside -->
          <div class="col-md-4">
            <!-- ad -->
            <div class="aside-widget text-center">
              <a href="#" style="display: inline-block;margin: auto;">
                <img class="img-responsive" src="./img/ad-1.jpg" alt="">
              </a>
            </div>
            <!-- /ad -->




            <!-- tags -->
            <div class="aside-widget">
                            <div class="section-title">
                <h2>Catagories</h2>
              </div>
              <div class="tags-widget">
                <ul>
                  <li><a href="/#/BlogSources?text=Simple Past Tense">Geçmiş Zaman</a></li>
                  <li><a href="/#/BlogSources?text=Modals">Modals</a></li>
                  <li><a href="/#/BlogSources?text=Koşul">Koşul,Şart</a></li>
                </ul>
              </div>
            </div>
            <!-- /tags -->

          </div>
          <!-- /aside -->
        </div>
        <!-- /row -->
      </div>
      <!-- /container -->
    </div>
    <!-- /section -->
</template>

<script>
//NOTLAR: /blog/wp-json/wp/v2/posts?search=Modal%20Verbs
module.exports = {
    props: ['postId'],
  data() {
    return {
      post: {
        title:{},
        content:{}
      }
    };
  },
  methods: {

},
created(){
    fetch("/blog/wp-json/wp/v2/posts/" + this.postId)
  .then(response => {
    return response.json();
  })
  .then(data => {
   this.post =  data
   document.title = this.post.title.rendered

  })
  .catch(error => {
    console.log("Request failed", error);
  });
}
}
</script>

<style>
.hello {
  background-color: #ffe;
}
</style>

