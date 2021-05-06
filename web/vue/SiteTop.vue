<template>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                    <div class="logo">
                        <!-- Text Logo -->
                        <!--<a href="index.html" class="logo">-->
                            <!--<span class="logo-small"><i class="mdi mdi-radar"></i></span>-->
                            <!--<span class="logo-large"><i class="mdi mdi-radar"></i> Simple</span>-->
                        <!--</a>-->
                        <!-- Image Logo -->
                        <a href="index.html" class="logo">
                            <img src="assets/images/logo_sm.png" alt="" height="26" class="logo-small">
                            <img src="assets/images/logo.png" alt="" height="26" class="logo-large">
                        </a>

                    </div>
                    <!-- End Logo container-->


                    <div class="navbar-custom">
                        <div id="navigation">
                            <!-- Navigation Menu-->
                            <ul class="navigation-menu">
                                <li class="has-submenu">
                                    <a href="index.html">
                                        <span><i class="ti-home"></i></span><span> AnaSayfa </span> </a>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"> <span><i class="ti-files"></i></span><span> İngilizce </span> </a>
                                    <ul class="submenu">
                                        <li><a href="/#/TranslateRaw">Raw Content</a></li>
                                        <li><a href="/#/SourceSubtitle">Alt Yazılar</a></li>
                                        <li><a href="/#/TranslateLink">Link Çeviri</a></li>
                                        <li><a href="/#/search">Kelimeler</a></li>
                                        <li><a href="/#/SourceNews">Okuma Kaynakları</a></li>
                                        <li><a href="/#/BlogSources">Konu Anlatımları</a></li>
                                        <li><a href="/#/SourceFavoriteWords">Favori Kelimeler</a></li>
                                        <li><a href="/#/SourceFavoriteSentences">Favori Cümleler</a></li>
                                        <li><a href="/#/SourceLongSentences">Uzun Cümleler</a></li>
                                        <li><a href="/#/TopWords">Kelime İndeks</a></li>
                                        <li><a href="/#/SourceDictionary">Kelime Grupları</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"><span><i class="ti-spray"></i></span><span> Kişisel Kaynaklar </span> </a>
                                    <ul class="submenu">


                                        <li class="has-submenu">
                                            <a href="#">İngilizce Notlar</a>
                                            <ul class="submenu">
                                                <li><a href="components-range-slider.html">Zamanlar</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-submenu">
                                            <a href="#">Matematik</a>
                                            <ul class="submenu">
                                                <li><a href="components-range-slider.html">Üslü Sayılar</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-submenu">
                                            <a href="#">Css</a>
                                            <ul class="submenu">
                                                <li><a href="components-range-slider.html">Flex</a></li>
                                            </ul>
                                        </li>
                                         <li class="has-submenu">
                                            <a href="#">Javascript</a>
                                            <ul class="submenu">
                                                <li><a href="components-range-slider.html">Async</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-submenu">
                                            <a href="#">AWS</a>
                                            <ul class="submenu">
                                                <li><a href="">S3</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"> <span><i class="ti-widget"></i></span><span> Frontend </span> </a>
                                    <ul class="submenu">
                                        <li><a href="extras-timeline.html">Css</a></li>
                                        <li><a href="extras-invoice.html">Html</a></li>
                                        <li><a href="extras-profile.html">Javascript</a></li>
                                    </ul>
                                </li>

                            </ul>
                            <!-- End navigation menu -->
                        </div> <!-- end #navigation -->
                    </div> <!-- end navbar-custom -->


                    <div class="menu-extras topbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <li class="menu-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>


                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle hide"> <span class="ml-1 pro-user-name">Admin <i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title hide">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item hide">
                                        <i class="ti-user"></i> <span>My Account</span>
                                    </a>

                                    <!-- item-->
                                    <a href="/manage/?sqlite=&username=admin" class="dropdown-item notify-item" target="_blank">
                                        <i class="ti-settings"></i> <span>Database</span>
                                    </a>
                                    <!-- item-->
                                    <a href="/blog/wp-admin/" class="dropdown-item notify-item" target="_blank">
                                        <i class="ti-settings"></i> <span>Blog Admin</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item hide">
                                        <i class="ti-lock"></i> <span>Lock Screen</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item hide">
                                        <i class="ti-power-off"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

        </header>
        <!-- End Navigation Bar-->

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
</style>

