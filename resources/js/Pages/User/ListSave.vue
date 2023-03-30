<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="min-w-[280px] w-[280px]">
                <Navigation :currentTab="'tab-3'"/>
            </div>
            <div class="flex-auto ml-[16px]">
                <div class="py-[14px] bg-[#fff] box-shadow">
                    <div class="border-b-[2px] mb-[8px]">
                        <div class="flex items-center justify-between mb-[8px]">
                            <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] text-[17px]">
                                Danh sách đã lưu
                            </div>
                            <div class="text-[15px] border-[2px] py-[6px] px-[12px] rounded-[6px] cursor-pointer 
                              mr-[32px] hover:bg-[#e9ecef] active:scale-95" @click="deleteAllSave">
                                <i class="bi bi-trash3 ml-[4px]"></i>
                                Xóa tất cả
                            </div>
                        </div>
                    </div>
                    <div class="mt-[24px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                        <div v-for="item in formData" class="mt-[8px] relative post-item">
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
                            <div class="post-icon absolute top-[6px] right-[6px] cursor-pointer active:scale-95
                              bg-[#fff] text-[24px] rounded-[50%] hover:bg-[#ced4da] p-[2px] box-shadow" @click="unSavePost(item)">
                                <i class="bi bi-x"></i>
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
        },
        unSavePost(item) {
            ElMessageBox({
                title: 'Hủy theo dõi',
                message: h('p', null, [
                    h('span', null, `Bạn có muốn bỏ lưu bài viết không ?`),
                ]),
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy bỏ',
                beforeClose: (action, instance, done) => {
                    if (action === 'confirm') {
                        instance.confirmButtonLoading = true
                        instance.confirmButtonText = 'Loading...'
                        instance.closeForm = false
                        setTimeout(() => {
                            instance.confirmButtonLoading = false
                            done()
                        }, 3000)
                    } else {
                        done()
                    }
                },
            }).then(() => {
                ElMessage({
                    type: 'success',
                    message: `Bỏ lưu bài viết thành công`,
                })
                this.isEditProfile = 'tab-0'
            }).catch(() => {})
        },
        deleteAllSave() {
            ElMessageBox({
                title: 'Bỏ lưu bài viết',
                message: h('p', null, [
                    h('span', null, `Bạn có muốn bỏ lưu bài viết tất cả bài viết không ?`),
                ]),
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy bỏ',
                beforeClose: (action, instance, done) => {
                    if (action === 'confirm') {
                        instance.confirmButtonLoading = true
                        instance.confirmButtonText = 'Loading...'
                        instance.closeForm = false
                        setTimeout(() => {
                            instance.confirmButtonLoading = false
                            done()
                        }, 3000)
                    } else {
                        done()
                    }
                },
            }).then(() => {
                ElMessage({
                    type: 'success',
                    message: `Bỏ lưu tất cả bài viết thành công`,
                })
                this.isEditProfile = 'tab-0'
            }).catch(() => {})
        }
    }
}

</script>
<style scoped>
.post-item:hover .post-image {
    transform: scale(1.03);
    transition: .1s linear all;
}
.post-item .post-icon {
    display: none;
}
.post-item:hover .post-icon {
    display: block;
}
.box-shadow {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
</style>
  