<template>
    <AppLayout :currentTab="this.$page.props.hagtag">
        <template v-slot:main-1>
            <div class="main">
                <div class="heading">{{ this.$page.props.hagtagName }}</div>
                <div class="news mb-[24px]">
                    <div class="mt-[20px] grid grid-cols-2 gap-2">
                        <div v-for="(item, index) in listPost"  class="new-item-default">
                            <template v-if="index < 2">
                                <Link :href="route('post', item.slug)">
                                    <img :src="item.image" :alt="item.description" class="border-[1px] h-[260px] w-[100%] object-cover">
                                </Link>
                                <div class="mt-[12px] mx-[4px]">
                                    <Link :href="route('post', item.slug)">
                                        <div class="title mt-[8px]">{{ item.title }}</div>
                                    </Link>
                                    <Link :href="route('list-category', item.categorySlug)">
                                        <div class="category my-[4px]">{{ item.categoryName }}</div>
                                    </Link>
                                    <div class="time">{{ convertTime(item.created_at) }}</div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="mt-[24px]">
                        <template v-if="listPost.length == 0">
                            <div class="text-center text-[17px] my-[36px]">
                                Không có bài viết
                            </div>
                        </template>
                        <template v-else v-for="(item, index) in listPost">
                            <div class="new-item flex mt-[24px]" v-if="index >= 2">
                                <Link :href="route('post', item.slug)">
                                    <img :src="item.image" :alt="item.description" class="h-[200px] w-[100%] object-cover">
                                </Link>
                                <div class="ml-[12px]">
                                    <Link :href="route('post', item.slug)">
                                        <div class="title">{{ item.title }}</div>
                                    </Link>
                                    <Link :href="route('list-category', item.categorySlug)">
                                        <div class="category mt-[8px] mb-[4px]">{{ item.categoryName }}</div>
                                    </Link>
                                    <div class="time">{{ convertTime(item.created_at) }}</div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div v-if="listPost.length > 0" class="flex mt-[54px] mb-[64px] justify-center">
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
                limit: 15,
                page: 1,
            },
            paginate: [],
            listPost: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async fetchData() {
            const pagram = { ...this.filter }
            const response = await axios.post(route('post.get-list-post-hagtag', this.$page.props.hagtag), pagram)
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
main .container-fuild .main-1 .new-item-default img,
main .container-fuild .main-1 .new-item img {
    border-radius: 4px;
}
main .container-fuild .main-1 .new-item img {
    min-width: 260px;
    width: 260px;
}
main .container-fuild .main-1 .title {
    font-size: 1.0rem;
    font-weight: 600;
}
main .container-fuild .main-1 .category {
    font-size: 0.8rem;
    color: #076db6;
    font-weight: 600;
}
main .container-fuild .main-1 .time {
    font-size: 0.9rem;
}
main .container-fuild .main-1 .heading {
    margin-top: 12px;
    text-transform: uppercase;
    color: #db562b;
    font-size: 17px;
    border-left: 4px solid #db562b;
    padding-left: 12px;
}
</style>
  