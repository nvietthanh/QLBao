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
                    <div class="mt-[24px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                        <div v-for="item in formData" class="mt-[8px] post-item">
                            <Link :href="route('post', item.slugPost)">
                                <img :src="item.image" :alt="item.description" class="post-image">
                            </Link>
                            <div class="px-[2px]">
                                <Link :href="route('post', item.slugPost)">
                                    <div class="font-bold text-[15px] mt-[4px]">{{ item.title }}</div>
                                </Link>
                                <div class="flex items-center mt-[8px]">
                                    <Link :href="route('list-category', item.slugCategory)">
                                        <div class="text-[14px] font-bold text-[#076db6]">{{ item.category }}</div>
                                    </Link>
                                    <div class="ml-[16px] text-[13px] mt-[4px]">{{ item.time }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import { h } from 'vue'
import Navigation from '@/Components/User/Navigation.vue'

export default{
    components:{
        AppLayout,
        Link,
        Navigation
    },
    data() {
        return {
            currentTab: 'tab-2',
            formData: [
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
                {
                    title: 'Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ',
                    description: 'Tình hình giá xăng dầu hiện tại',
                    slugPost: 'chung-ta-cua-hien-tai',
                    image: '/image/cf2a58bd5ff0b6aeefe1.jpg',
                    category: 'Chính trị',
                    slugCategory: 'chinh-tri',
                    time: '1 giờ trước'
                },
            ]
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        fetchData() {
        }
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
  