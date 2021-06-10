<template>
    <v-dialog v-model="isActive" persistent max-width="800" scrollable>
        <v-card>
            <v-toolbar flat dark color="primary">
                <v-toolbar-title>
                    {{ $vuetify.lang.t('$vuetify.ordersView.addProduct') }}
                </v-toolbar-title>
                <v-spacer/>
                <v-btn icon @click="close">
                    <v-icon>fas fa-times-circle</v-icon>
                </v-btn>
            </v-toolbar>
            <v-divider/>
            <v-card-text class="mt-3" style="min-height: 30vh; max-height: 90vh;">
                <v-data-table :items="items" v-model="selected" :headers="headers" :show-select="!isSaveNow" fixed-header height="calc(90vh - 280px)" :footer-props="{itemsPerPageOptions: [15,30,50]}" :options.sync="options" :server-items-length="itemsInDb" :loading="isLoading" :loader-height="1" class="elevation-3 bordered-td">
                    <template v-slot:top>
                        <v-toolbar flat>

                            <v-btn color="primary" :x-small="isMobile" :fab="isMobile" :disabled="isSaveNow" class="mx-3" @click="isShowSearchDialog=true">
                                <v-icon small :left="!isMobile">fas fa-search</v-icon>
                                <span class="hidden-xs-only">{{ $vuetify.lang.t('$vuetify.productsView.searchProduct') }}</span>
                            </v-btn>

                            <v-spacer/>

                            <v-btn color="primary" :x-small="isMobile" :fab="isMobile" :loading="isSaveNow" @click="$emit('addItems', selected)" :disabled="!selected.length || isSaveNow">
                                <v-icon small :left="!isMobile">fas fa-plus-square</v-icon>
                                <span class="hidden-xs-only">{{ $vuetify.lang.t('$vuetify.ordersView.addProduct') }}</span>
                            </v-btn>
                        </v-toolbar>
                    </template>

                    <template v-slot:item.sku="props">
                        <span class="d-block" v-for="sku of props.item.sku" :key="sku">{{sku}}</span>
                    </template>

                    <template v-slot:item.image="{ item }">
                        <v-img :src="item.image" :max-height="48" :max-width="80" contain/>
                    </template>

                    <template v-slot:item.name="props">
                        {{ props.item.name[$vuetify.lang.current] }}
                    </template>

                    <template v-slot:item.finally_price="props">
                        {{ formatNumber(props.item.finally_price) }}
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

        <SearchProductDialog :is-active.sync="isShowSearchDialog" v-on:apply="startSearch"/>
    </v-dialog>
</template>

<script>
import SearchProductDialog from "@/modals/SearchProductDialog";

export default {
    name: "AddProductToOrderDialog",
    components: {SearchProductDialog},
    props: {
        isActive: {
            type: Boolean,
            default: false
        },
        isSaveNow: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isLoading: false,
            items: [],
            headers: [
                { text: this.$vuetify.lang.t('$vuetify.dataTableHeaders.sku'), value: 'sku', sortable: false, align: this.$vuetify.rtl ? 'right' : 'left'},
                { text: this.$vuetify.lang.t('$vuetify.dataTableHeaders.image'), value: 'image', width: 80, sortable: false, align: this.$vuetify.rtl ? 'right' : 'left'},
                { text: this.$vuetify.lang.t('$vuetify.dataTableHeaders.name'), value: 'name', width: 300, align: this.$vuetify.rtl ? 'right' : 'left'},
                { text: this.$vuetify.lang.t('$vuetify.dataTableHeaders.finallyPrice'), value: 'finally_price', align: this.$vuetify.rtl ? 'right' : 'left'}
            ],
            options: {
                itemsPerPage: 30,
                page: 1
            },
            itemsInDb: 0,
            selected: [],
            isShowSearchDialog: false,
            searchObj: null
        }
    },
    watch: {
        '$props.isActive': function (val) {
            if (val) {
                this.loadData();
            } else {
                this.items = [];
                this.selected = [];
            }
        },
        options: {
            handler () {
                this.loadData()
            },
            deep: true,
        },
    },
    methods: {
        loadData() {
            this.isLoading = true;
            this.items = [];
            if (this.searchObj) {
                this.options.search_type = this.searchObj.type;
                this.options.search_value = JSON.stringify(this.searchObj.value);
            }
            this.$web.get.call(this, 'products_filtered', this.options).then(response => {
                if (response.data) {
                    this.items = response.data.data;
                    this.itemsInDb = response.data.meta.total;
                }
            }).finally(() => { this.isLoading = false; });
        },
        close() {
            this.$emit('update:isActive', false);
        },
        startSearch(search) {
            this.searchObj = search;
            this.loadData();
        }
    }
}
</script>

<style scoped>

</style>
