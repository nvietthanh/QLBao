<template>
    <AppLayout :currentTab="this.$page.props.category">
        <template v-slot:main-1>
            <div class="main">
                <div class="border-l-[5px] pl-[12px] border-l-[red] font-bold text-[red]">{{ this.$page.props.categoryName }}</div>
                <div class="mb-[24px]">
                    <div class="mt-[20px] grid grid-cols-2 gap-3">
                        <div v-for="(item, index) in listPost" class="post-item">
                            <template v-if="index < 2">
                                <Link :href="route('post', item.slug)">
                                    <img :src="item.image" :alt="item.description" class="post-image border-[1px] rounded-[4px] h-[260px] w-[100%] object-cover">
                                </Link>
                                <div class="mt-[12px] mx-[4px]">
                                    <Link :href="route('post', item.slug)">
                                        <div class="post-title font-bold text-[17px]">{{ item.title }}</div>
                                    </Link>
                                    <Link :href="route('list-category', item.categorySlug)">
                                        <div class="text-[#076db6] font-bold text-[15px] my-[4px]">{{ item.categoryName }}</div>
                                    </Link>
                                    <div class="text-[14px]">{{ convertTime(item.created_at) }}</div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="mt-[24px]">
                        <template v-for="(item, index) in listPost">
                            <div class="flex mt-[24px] post-item" v-if="index >= 2">
                                <Link :href="route('post', item.slug)" class="mr-[4px]">
                                    <img :src="item.image" :alt="item.description" class="post-image rounded-[4px] border-[1px] min-w-[260px] w-[260px] h-[200px] object-cover">
                                </Link>
                            <div class="ml-[12px]">
                                    <Link :href="route('post', item.slug)">
                                        <div class="post-title font-bold text-[17px]" style="height: auto;">{{ item.title }}</div>
                                    </Link>
                                    <Link :href="route('list-category', item.categorySlug)">
                                        <div class="text-[#076db6] mt-[8px] font-bold text-[15px] my-[4px]">{{ item.categoryName }}</div>
                                    </Link>
                                    <div class="text-[14px]">{{ convertTime(item.created_at) }}</div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="flex mt-[24px] mb-[64px] justify-center">
                        <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filter.page || 1"
                            paginate-background/>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '../Layouts/AppLayout.vue';
import moment from "moment";
import { Link } from '@inertiajs/vue3'
import Paginate from "@/Components/UI/Paginate.vue";

export default{
    components:{
        AppLayout,
        Link,
        Paginate
    },
    data() {
        return {
            filter: {
                limit: 14,
                page: 1,
            },
            paginate: [],
            listPost: []
        }  
    },
    created() {
        this.fetchData()
        document.title = `Tin tức - ${this.$page.props.categoryName}`
    },
    methods: {
        moment,
        async fetchData() {
            const pagram = { ...this.filter }
            const response = await axios.post(route('category.list-post', this.$page.props.category), pagram)
            this.listPost = response.data.data
            this.paginate = response.data.meta
        },
        handleCurrentPage(value) {
            this.filter.page = value
            this.fetchData()
        },
        convertTime(created_at) {
            const now = moment()
            const time = moment(created_at)

            if( now.diff(time, 'years') > 0 ) {
                return `${now.diff(time, 'years')} năm trước`
            }
            else if(now.diff(time, 'months') > 0) {
                return `${now.diff(time, 'months')} tháng trước`
            }
            else if(now.diff(time, 'days') > 0) {
                return `${now.diff(time, 'days')} ngày trước`
            }
            else if(now.diff(time, 'hours') > 0) {
                return `${now.diff(time, 'hours')} giờ trước`
            }
            else if(now.diff(time, 'minutes') > 0) {
                return `${now.diff(time, 'minutes')} phút trước`
            }
            else if(now.diff(time, 'seconds') > 0) {
                return `${now.diff(time, 'seconds')} giây trước`
            }
        },
    }
}

</script>
<style scoped>
main .main {
    background-color: #fff;
    padding: 12px;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}
main .container-fuild .main-1 .heading {
    margin-top: 12px;
    text-transform: uppercase;
    color: #db562b;
    font-size: 17px;
    border-left: 4px solid #db562b;
    padding-left: 12px;
}
.post-title {
    height: 80px;
    max-height: 80px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
  