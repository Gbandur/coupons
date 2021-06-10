<!--<template>-->
<!--    <v-app v-resize="onResize">-->
<!--        <v-app-bar app color="primary" dark v-if="isAuthorized">-->
<!--            <div class="d-flex align-center">-->
<!--                <v-img alt="Company Logo" class="shrink" contain src="./assets/logo.png" transition="scale-transition" height="40"/>-->
<!--            </div>-->

<!--            <v-spacer></v-spacer>-->

<!--            <v-btn text @click="goToRouteName('sales')" :color="$router.currentRoute.name === 'sales' ? 'black' : 'white'">-->
<!--                <v-icon small left>fas fa-piggy-bank</v-icon>-->
<!--                <span>{{ $vuetify.lang.t('$vuetify.menu.salesManagement') }}</span>-->
<!--            </v-btn>-->

<!--            <v-btn text @click="goToRouteName('orders')" :color="$router.currentRoute.name === 'orders' ? 'black' : 'white'">-->
<!--                <v-icon small left>fas fa-cash-register</v-icon>-->
<!--                <span>{{ $vuetify.lang.t('$vuetify.menu.ordersManagement') }}</span>-->
<!--            </v-btn>-->

<!--            <v-btn text @click="goToRouteName('products')" :color="$router.currentRoute.name === 'products' ? 'black' : 'white'">-->
<!--                <v-icon small left>fas fa-store</v-icon>-->
<!--                <span>{{ $vuetify.lang.t('$vuetify.menu.productsManagement') }}</span>-->
<!--            </v-btn>-->

<!--            <v-menu offset-y origin="center center" transition="scale-transition" v-model="settings_menu">-->
<!--                <template v-slot:activator="{ on }">-->
<!--                    <v-btn v-on="on" icon>-->
<!--                        <v-icon>fas fa-user-tie</v-icon>-->
<!--                    </v-btn>-->
<!--                </template>-->
<!--                <v-list>-->
<!--                    <v-menu :left="$vuetify.lang.current !== 'he'" :right="$vuetify.lang.current === 'he'" offset-x>-->
<!--                        <template v-slot:activator="{ on }">-->
<!--                            <v-list-item v-on="on" @click="null">-->
<!--                                <v-list-item-icon>-->
<!--                                    <v-icon v-if="$vuetify.lang.current !== 'he'">fas fa-angle-left</v-icon>-->
<!--                                    <v-icon v-else>fas fa-angle-right</v-icon>-->
<!--                                </v-list-item-icon>-->
<!--                                <v-list-item-content>-->
<!--                                    {{ $vuetify.lang.t('$vuetify.buttons.language') }}-->
<!--                                </v-list-item-content>-->
<!--                            </v-list-item>-->
<!--                        </template>-->
<!--                        <v-list>-->
<!--                            <v-list-item @click="setLang('ru')">-->
<!--                                <v-list-item-action>-->
<!--                                    <v-img src="./assets/en.png" :max-width="'24px'"></v-img>-->
<!--                                </v-list-item-action>-->
<!--                                <v-list-item-title>{{ $vuetify.lang.t('$vuetify.menu.langNameEn') }}</v-list-item-title>-->
<!--                            </v-list-item>-->
<!--                            <v-list-item @click="setLang('he')">-->
<!--                                <v-list-item-action>-->
<!--                                    <v-img src="./assets/he.png" :max-width="'24px'"></v-img>-->
<!--                                </v-list-item-action>-->
<!--                                <v-list-item-title>{{ $vuetify.lang.t('$vuetify.menu.langNameHe') }}</v-list-item-title>-->
<!--                            </v-list-item>-->
<!--                        </v-list>-->
<!--                    </v-menu>-->

<!--                    <v-list-item @click="signOut">-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>fas fa-sign-out-alt</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            {{ $vuetify.lang.t('$vuetify.menu.signOut') }}-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                </v-list>-->
<!--            </v-menu>-->

<!--        </v-app-bar>-->

<!--        <v-main class="grey lighten-3">-->
<!--            <v-container class="main-container container&#45;&#45;fluid" :class="{'landing fill-height': !isAuthorized}">-->
<!--                <transition name="fade" mode="out-in">-->
<!--                    <router-view :key="$route.meta.key"></router-view>-->
<!--                </transition>-->
<!--            </v-container>-->
<!--        </v-main>-->

<!--        <ErrorDialog/>-->
<!--    </v-app>-->
<!--</template>-->

<!--<script>-->

<!--// import {mapState} from "vuex";-->
<!--// import LocalValues from "@/plugins/localValues";-->
<!--// import ErrorDialog from "@/modals/ErrorDialog";-->
<!--//-->
<!--// // Import FilePond styles-->
<!--// import 'filepond/dist/filepond.min.css';-->
<!--// import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.css';-->
<!--// import 'doka/doka.css';-->


<!--export default {-->
<!--    name: 'App',-->
<!--    components: {ErrorDialog},-->
<!--    data: () => ({-->
<!--        settings_menu: false,-->
<!--        products_menu: false-->
<!--    }),-->
<!--    computed: {-->
<!--        ...mapState({-->
<!--            isAuthorized: state => state.isAuthorized,-->
<!--        })-->
<!--    },-->
<!--    mounted() {-->
<!--        document.querySelector('#loader').remove();-->
<!--    },-->
<!--    methods: {-->
<!--        signOut() {-->
<!--            this.$web.post.call(this,'auth/logout', null).then().finally(() => {-->
<!--                LocalValues.setKey(null);-->
<!--                this.settings_menu = false;-->
<!--            });-->
<!--            this.$store.commit('CHANGE_AUTHORIZED_STATUS', false);-->
<!--            this.$store.commit('SET_ACCESS_LEVEL', 0);-->
<!--            localStorage.removeItem('one_pc');-->
<!--            this.$router.push('/login');-->
<!--        },-->
<!--        onResize() {-->
<!--            this.$store.commit('SET_IS_MOBILE', window.innerWidth < 600);-->
<!--            this.$store.commit('SET_IS_SMALL', window.innerWidth >= 600 && window.innerWidth < 960);-->
<!--            this.$store.commit('SET_IS_MEDIUM', window.innerWidth >= 960 && window.innerWidth < 1264);-->
<!--            this.$store.commit('SET_IS_LARGE', window.innerWidth >= 1264 && window.innerWidth < 1904);-->
<!--            this.$store.commit('SET_IS_EXTRA_LARGE', window.innerWidth >= 1904);-->
<!--            this.$store.commit('SET_CURRENT_WIDTH', window.innerWidth);-->
<!--        },-->
<!--        setLang(lang) {-->
<!--            this.$vuetify.lang.current = lang;-->
<!--            this.$vuetify.rtl = lang === 'he';-->
<!--        }-->
<!--    }-->
<!--};-->
<!--</script>-->

<!--<style lang="scss">-->
<!--.v-application {-->
<!--    width: 100%;-->
<!--}-->
<!--.w-100 {-->
<!--    width: 100%;-->
<!--}-->
<!--.ltr {-->
<!--    direction: ltr !important;-->
<!--}-->
<!--.main-container {-->
<!--    max-height: calc(100vh - 65px);-->
<!--    overflow-y: auto;-->
<!--    -webkit-overflow-scrolling: touch;-->
<!--}-->
<!--.landing {-->
<!--    max-height: 100vh !important;-->
<!--}-->
<!--.position-relative {-->
<!--    position: relative !important;-->
<!--}-->
<!--.tb-height {-->
<!--    min-height: 60vh;-->
<!--}-->

<!--.menu-list-item {-->
<!--    .v-list-group__header__append-icon {-->
<!--        min-width: 24px !important;-->
<!--    }-->
<!--}-->
<!--@import url('https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&display=swap');-->

<!--.current_item_color {-->
<!--    background-color: #fffaf7;-->
<!--}-->

<!--.filepond&#45;&#45;credits {-->
<!--    display: none !important;-->
<!--}-->

<!--.theme&#45;&#45;light.v-data-table.bordered-td > .v-data-table__wrapper > table > tbody > tr > td:not(:last-child) {-->
<!--    border-left: thin solid rgba(0, 0, 0, 0.12);-->
<!--}-->

<!--.theme&#45;&#45;light.v-data-table.bordered-td > .v-data-table__wrapper > table > thead > tr > th {-->
<!--    background: #daecfb;-->
<!--    color: #1d2f41;-->
<!--    font-size: 13px;-->
<!--    font-weight: 500;-->
<!--}-->

<!--.theme&#45;&#45;light.v-data-table.bordered-td > .v-data-table__wrapper > table > thead > tr > th:not(:last-child) {-->
<!--    border-left: thin solid rgba(0, 0, 0, 0.12);-->
<!--}-->

<!--.filepond&#45;&#45;file-poster-overlay {-->
<!--    aspect-ratio: auto;-->
<!--}-->

<!--.filepond&#45;&#45;item {-->
<!--    width: calc(33.333% - .5em);-->
<!--    height: calc(10.4vw - .5em) !important;-->
<!--    min-height: 150px !important;-->
<!--}-->

<!--.radius-8 {-->
<!--    border-radius: 8px;-->
<!--}-->

<!--.video&#45;&#45;header {-->
<!--    border-radius: 8px;-->
<!--    position: absolute;-->
<!--    width: 100%;-->
<!--    color: white;-->
<!--    z-index: 1;-->
<!--    display: flex;-->
<!--    justify-content: flex-end;-->
<!--    height: 100px;-->
<!--    background: rgb(2,0,36);-->
<!--    background: linear-gradient(180deg, rgba(2,0,36,0.9) 0%, rgba(1,0,23,0.7) 30%, rgba(0,0,0,0) 100%);-->
<!--}-->

<!--.video&#45;&#45;delete-btn {-->
<!--    font-size: 1em !important;-->
<!--    width: 2em !important;-->
<!--    height: 2em !important;-->
<!--    min-width: 2em !important;-->
<!--    padding: 0.1875em !important;-->
<!--    cursor: pointer;-->
<!--    color: #fff !important;-->
<!--    border-radius: 50% !important;-->
<!--    background-color: rgba(0, 0, 0, .5) !important;-->
<!--    background-image: none;-->
<!--    left: 0.65em;-->
<!--    top: 0.65em;-->
<!--    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);-->
<!--    transition: box-shadow 0.25s ease-in;-->

<!--    &:hover, &:focus {-->
<!--        box-shadow: 0 0 0 0.125em rgba(255, 255, 255, 0.9);-->
<!--    }-->
<!--}-->

<!--.video&#45;&#45;play-btn {-->
<!--    z-index: 2;-->
<!--    top: calc(50% - 16px);-->
<!--    left: calc(50% - 26px);-->

<!--    span {-->
<!--        i {-->
<!--            font-size: 3.4em !important;-->
<!--        }-->
<!--    }-->
<!--}-->

<!--.quill-editor {-->
<!--    .ql-toolbar {-->
<!--        border-radius: 5px 5px 0 0;-->
<!--    }-->
<!--    .ql-container {-->
<!--        border-radius: 0 0 5px 5px;-->
<!--    }-->
<!--}-->

<!--</style>-->
