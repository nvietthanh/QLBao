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
                    <template v-if="formData.length == 0">
                        <div class="text-center text-[16px] mt-[18px] mb-[6px]">
                            Bạn chưa lưu bài viết nào
                        </div>
                    </template>
                    <template v-else>
                        <div class="mt-[24px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                            <div v-for="item in formData" class="mt-[8px] relative post-item">
                                <Link :href="route('post', item.slug)">
                                    <img :src="item.image" class="post-image h-[160px] w-[100%] object-cover">
                                </Link>
                                <div class="px-[2px]">
                                    <Link :href="route('post', item.slug)">
                                        <div class="post-title font-bold text-[15px] mt-[4px]">{{ item.title }}</div>
                                    </Link>
                                    <div class="flex items-center mt-[8px]">
                                        <Link :href="route('list-category', item.categorySlug)">
                                            <div class="text-[14px] font-bold text-[#076db6]">{{ item.categoryName }}</div>
                                        </Link>
                                        <div class="ml-[16px] text-[13px] mt-[4px]">{{ item.time }}</div>
                                    </div>
                                </div>
                                <div class="post-icon absolute top-[6px] right-[6px] cursor-pointer active:scale-95 w-[30px] h-[30px]
                                  bg-[#fff] text-[22px] rounded-[50%] hover:bg-[#ced4da] box-shadow text-center" 
                                  @click="unSavePost(item)">
                                    <i class="bi bi-x"></i>
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
import { ElMessage, ElMessageBox } from 'element-plus'
import { h } from 'vue'
import Navigation from '@/Components/User/Navigation.vue'
import Paginate from "@/Components/UI/Paginate.vue";

export default{
    components:{
        AppLayout,
        Link,
        Navigation,
        Paginate
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
        async fetchData() {
            const pagram = { ...this.filter }
            const response = await axios.get(route('get-list-save', pagram))
            this.formData = response.data.data
            this.paginate = response.data.meta
        },
        handleCurrentPage(value) {
            this.filter.page = value
            this.fetchData()
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
                        axios.get(route('unsave-post', item.id))
                            .then(response => {
                                done()
                                this.fetchData()
                            })
                            .catch(errors => {})
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
                        axios.get(route('unsave-all-post'))
                            .then(response => {
                                done()
                                this.fetchData()
                            })
                            .catch(errors => {})
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
  