<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="min-w-[280px] w-[280px]">
                <Navigation :currentTab="'tab-2'"/>
            </div>
            <div class="flex-auto ml-[16px]">
                <div class="py-[20px] bg-[#fff] box-shadow">
                    <div class="border-b-[2px] mb-[8px]">
                        <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                            Danh sách đã xem
                        </div>
                    </div>
                    <template v-if="formData.length == 0">
                        <div class="text-center text-[16px] mt-[18px] mb-[6px]">
                            Bạn chưa lưu bài viết nào
                        </div>
                    </template>
                    <template v-else>
                        <div class="mt-[24px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                            <div v-for="item in formData" class="mt-[8px] post-item">
                                <Link :href="route('post', item.slug)">
                                    <img :src="item.image" :alt="item.description" class="post-image w-[100%] h-[150px] object-cover">
                                </Link>
                                <div class="px-[2px]">
                                    <Link :href="route('post', item.slug)">
                                        <div class="font-bold text-[15px] mt-[4px]">{{ item.title }}</div>
                                    </Link>
                                    <div class="flex items-center mt-[8px]">
                                        <Link :href="route('list-category', item.categorySlug)">
                                            <div class="text-[14px] font-bold text-[#076db6]">{{ item.categoryName }}</div>
                                        </Link>
                                        <div class="ml-[16px] text-[13px] mt-[4px]">{{ convertTime(item.created_at) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex mt-[34px] mb-[54px] justify-center">
                            <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filter.page || 1"
                              paginate-background/>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import Navigation from '@/Components/User/Navigation.vue'
import Paginate from "@/Components/UI/Paginate.vue";
import moment from "moment";

export default{
    components:{
        AppLayout,
        Link,
        Paginate,
        Navigation
    },
    data() {
        return {
            currentTab: 'tab-2',
            filter: {
                limit: 18,
                page: 1,
            },
            paginate: [],
            formData: [],
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async fetchData() {
            const pagram = { ...this.filter }
            const response = await axios.get(route('get-list-read', pagram))
            this.formData = response.data.data
            this.paginate = response.data.meta
        },
        handleCurrentPage(value) {
            this.filter.page = value
            this.fetchData()
        },
        convertTime(created_at) {
            const now = moment()
            const time = moment(created_at)

            if (now.diff(time, 'years') > 0) {
                return `${now.diff(time, 'years')} năm trước`
            }
            else if (now.diff(time, 'months') > 0) {
                return `${now.diff(time, 'months')} tháng trước`
            }
            else if (now.diff(time, 'days') > 0) {
                return `${now.diff(time, 'days')} ngày trước`
            }
            else if (now.diff(time, 'hours') > 0) {
                return `${now.diff(time, 'hours')} giờ trước`
            }
            else if (now.diff(time, 'minutes') > 0) {
                return `${now.diff(time, 'minutes')} phút trước`
            }
            else if (now.diff(time, 'seconds') > 0) {
                return `${now.diff(time, 'seconds')} giây trước`
            }
        },
    }
}

</script>
<style scoped>
.post-item:hover .post-image {
    transform: scale(1.03);
    transition: .1s linear all;
}
.box-shadow {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
</style>
  