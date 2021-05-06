<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <h4 class="header-title m-t-0 m-b-20">Hoşgeldin !</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-4">
                <div class="card-box">
                    <a href="#" class="btn btn-sm btn-default pull-right">View</a>
                    <h6 class="text-muted font-13 m-t-0 text-uppercase">Favori Kelimeler</h6>
                    <h3 class="m-b-20 mt-3"><span>1,890</span></h3>

                </div>
            </div>

            <div class="col-sm-4">
                <div class="card-box">
                    <a href="#" class="btn btn-sm btn-default pull-right">View</a>
                    <h6 class="text-muted font-13 m-t-0 text-uppercase">Favori Cümleler</h6>
                    <h3 class="m-b-20 mt-3"><span>22.56</span></h3>

                </div>
            </div>

            <div class="col-sm-4">
                <div class="card-box">
                    <a href="#" class="btn btn-sm btn-default pull-right">View</a>
                    <h6 class="text-muted m-t-0 font-13 text-uppercase">Toplam Cümle</h6>
                    <h3 class="m-b-20 mt-3">9,754</h3>

                </div>
            </div>

        </div>
        <!-- end row -->



        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <h6 class="m-t-0">Son Okuma Kaynakları</h6>


                    <div class="table-responsive" v-if="$root.sourceLinks">
                        <table class="table table-hover mails m-0 table table-actions-bar">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, key) in $root.sourceLinks">
                                    <td>{{key}}</td>
                                    <td><a class="text-primary font-weight-bold curp"
                                        :href="'/#/TranslateLink?text=' + item.value">{{item.text}}  - {{item.value}}</a></td>
                                    </tr>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end container -->

    </template>

    <script>
    module.exports = {

        data() {
            return {
                issubtitle: true,
                queryText: '',
                article: '',
                articleForm: '',
                highlightText: '',
                linkText: '',
                minSize: 20,
                regexQuery: '',
                nowDate: new Date().toISOString()
            }
        },
        methods: {

        getLinks(text = '') {
            window.scrollTo(0, 0)
            setTimeout(() => {


                fetch('/api/getLinkHistory').then((response) => {
                    console.log(response)
                    return response.json()
                }).then((data) => {


                    this.$root.sourceLinks = _.map(data, (val) => {


                        val.text = val.ID
                        val.value = val.link
                        return val;
                    })

                    // val.text = val.text.replace(/(<\s*[^>]*>)/gi, ' ');
                })

            }, 100)
        },


    },
    created(){
        setTimeout(() => {

            this.getLinks('css')

        }, 100)

    }
}
</script>

<style scoped>
.bg-yellow {
    background-color: yellowgreen;
}
</style>
