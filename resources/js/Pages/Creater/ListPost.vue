<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="min-w-[280px] w-[280px]">
                <Navigation :currentTab="'tab-4'"/>
            </div>
            <div class="flex-auto ml-[16px]">
                <div class="py-[20px] bg-[#fff] box-shadow">
                    <div class="border-b-[2px]">
                        <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                            Danh sách bài viết của bạn
                        </div>
                    </div>
                    <div class="flex mx-[12px] mt-[28px] mb-[24px] text-[15px] font-bold">
                        <div class="w-[130px] border-[2px] text-center py-[6px] rounded-[4px] border-[#dee2e6] cursor-pointer"
                         :class="{ 'bg-[#17a2b8] text-white' : tab == 'tab-0' }"
                         @click="changeTab('tab-0')">
                            Đã duyệt
                        </div>
                        <div class="ml-[8px] w-[130px] border-[2px] text-center py-[6px] rounded-[4px] border-[#dee2e6] cursor-pointer"
                         :class="{ 'bg-[#17a2b8] text-white' : tab == 'tab-1' }"
                         @click="changeTab('tab-1')">
                           Chưa duyệt
                        </div>
                    </div>
                    <div class="mt-[18px] mx-[12px] flex justify-between items-center text-[16px]">
                        <div class="flex">
                            <div class="flex items-center ">
                                <el-select v-model="filter.limit" class="max-w-[60px] ml-[8px]" @change="changeSearch">
                                    <el-option
                                        v-for="item in options"
                                        :key="item"
                                        :label="item"
                                        :value="item"
                                    />
                                </el-select>
                                <el-select class="ml-[18px]" v-model="filter.categorySelect" placeholder="Chọn danh mục" 
                                  multiple multiple-limit="2" clearable @change="changeSearch">
                                    <el-option
                                        v-for="item in this.$page.props.categories"
                                        :key="item.slug"
                                        :label="item.name"
                                        :value="item.slug"
                                    />
                                </el-select>
                                <el-input class="ml-[20px] min-w-[270px]" v-model="filter.search"
                                   placeholder="Nhập từ khóa" clearable @keyup.enter="changeSearch"/>
                            </div>
                        </div>
                        <div class="border-[2px] px-[12px] rounded-[4px] cursor-pointer mr-[2px] bg-[#198754] text-[15px] 
                          text-[#fff] active:scale-95 h-[36px] leading-[34px]" @click="addPost()">
                            Thêm bài viết
                        </div>
                    </div>
                    <template v-if="postsData.length == 0">
                        <div class="text-center text-[16px] mt-[32px] mb-[28px] mb-[6px]">
                            Không có bài viết nào
                        </div>
                    </template>
                    <template v-else>
                        <template v-if="filter.is_approved">
                            <div class="mt-[12px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                                <div v-for="item in postsData" class="mt-[8px] relative post-item">
                                    <Link :href="route('post', item.slug)">
                                        <img :src="item.image" alt="" class="post-image w-[100%] h-[150px] object-cover">
                                    </Link>
                                    <div class="px-[2px]">
                                        <Link :href="route('post', item.slug)">
                                            <div class="description font-bold text-[15px] mt-[8px]">{{ item.title }}</div>
                                        </Link>
                                        <div class="flex items-center mt-[8px]">
                                            <Link :href="route('list-category', item.categorySlug)">
                                                <div class="text-[14px] font-bold text-[#076db6]">{{ item.categoryName }}</div>
                                            </Link>
                                            <div class="ml-[16px] text-[13px] mt-[4px]">{{ convertTime(item.created_at) }}</div>
                                        </div>
                                    </div>
                                    <div class="post-icon absolute top-[8px] right-[8px] h-[24px] w-[28px] text-center
                                      cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[18px] active:scale-95 hover:bg-[#ced4da]" 
                                      @click="showPost(item)">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <div v-if="!filter.is_approved" class="post-icon absolute top-[38px] right-[8px] h-[24px] w-[28px] text-center pt-[3px]
                                      cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[14px] active:scale-95 hover:bg-[#ced4da]" 
                                      @click="editPost(item)">
                                        <i class="bi bi-pen mb-[4px]"></i>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="filter.is_approved">
                            <div class="mt-[12px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                                <div v-for="item in postsData" class="mt-[8px] relative post-item">
                                    <Link :href="route('post', item.slug)">
                                        <img :src="item.image" alt="" class="post-image w-[100%] h-[150px] object-cover">
                                    </Link>
                                    <div class="px-[2px]">
                                        <Link :href="route('post', item.slug)">
                                            <div class="description font-bold text-[15px] mt-[8px]">{{ item.title }}</div>
                                        </Link>
                                        <div class="flex items-center mt-[8px]">
                                            <Link :href="route('list-category', item.categorySlug)">
                                                <div class="text-[14px] font-bold text-[#076db6]">{{ item.categoryName }}</div>
                                            </Link>
                                            <div class="ml-[16px] text-[13px] mt-[4px]">{{ convertTime(item.created_at) }}</div>
                                        </div>
                                    </div>
                                    <div class="post-icon absolute top-[8px] right-[8px] h-[24px] w-[28px] text-center
                                      cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[18px] active:scale-95 hover:bg-[#ced4da]" 
                                      @click="showPost(item)">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <div v-if="!filter.is_approved" class="post-icon absolute top-[38px] right-[8px] h-[24px] w-[28px] text-center pt-[3px]
                                      cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[14px] active:scale-95 hover:bg-[#ced4da]" 
                                      @click="editPost(item)">
                                        <i class="bi bi-pen mb-[4px]"></i>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="mt-[12px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                                <div v-for="item in postsData" class="mt-[8px] relative post-item">
                                    <img :src="item.image" alt="" class="post-image w-[100%] h-[150px] object-cover">
                                    <div class="px-[2px]">
                                        <div class="description font-bold text-[15px] mt-[8px]">{{ item.title }}</div>
                                        <div class="flex items-center mt-[8px]">
                                            <Link :href="route('list-category', item.categorySlug)">
                                                <div class="text-[14px] font-bold text-[#076db6]">{{ item.categoryName }}</div>
                                            </Link>
                                            <div class="ml-[16px] text-[13px] mt-[4px]">{{ convertTime(item.created_at) }}</div>
                                        </div>
                                    </div>
                                    <div class="post-icon absolute top-[8px] right-[8px] h-[24px] w-[28px] text-center
                                      cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[18px] active:scale-95 hover:bg-[#ced4da]" 
                                      @click="showPost(item)">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <div v-if="!filter.is_approved" class="post-icon absolute top-[38px] right-[8px] h-[24px] w-[28px] text-center pt-[3px]
                                      cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[14px] active:scale-95 hover:bg-[#ced4da]" 
                                      @click="editPost(item)">
                                        <i class="bi bi-pen mb-[4px]"></i>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="flex mt-[24px] mb-[64px] justify-center">
                            <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filter.page || 1"
                              paginate-background/>
                        </div>
                    </template>
                </div>
            </div>
            <ShowPostForm ref="showPostForm"/>
            <AddPostForm ref="formPostForm" @change-post="fetchData"/>
            <EditPostForm ref="editPostForm" @change-post="fetchData"/>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Navigation from '@/Components/User/Navigation.vue'
import Paginate from "@/Components/UI/Paginate.vue";
import { Link } from '@inertiajs/vue3'
import ShowPostForm from './Dialog/ShowPost.vue'
import AddPostForm from './Dialog/AddPost.vue'
import EditPostForm from './Dialog/EditPost.vue'
import moment from "moment";

export default{
    components:{
        AppLayout,
        Navigation,
        Paginate,
        ShowPostForm,
        AddPostForm,
        EditPostForm,
        Link,
    },
    data() {
        return {
            currentTab: 'tab-2',
            options: [15, 21, 25],
            tab: 'tab-0',
            filter: {
                limit: 15,
                categorySelect: [],
                search: '',
                page: 1,
                is_approved: true,
            },
            paginate: [],
            postsData: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async fetchData() {
            const pagram = { ...this.filter }
            const response = await axios.get(route('creator.posts.index', pagram));
            this.postsData = response.data.data
            this.paginate = response.data.meta
        },
        handleCurrentPage(value) {
            this.filter.page = value
            this.fetchData()
        },
        showPost(postItem) {
            this.$refs.showPostForm.open(postItem)
        },
        addPost() {
            this.$refs.formPostForm.open()
        },
        editPost(postItem) {
            this.$refs.editPostForm.open(postItem.id)
        },
        changeSearch() {
            this.fetchData()
        },
        changeTab(tab) {
            this.tab = tab
            if(tab == 'tab-0') {
                this.filter.is_approved = true
            }
            else {
                this.filter.is_approved = false
            }
            this.filter.limit = 15
            this.filter.categorySelect = []
            this.filter.search = ''
            this.filter.page = 1
            this.filter.paginate = []
            this.postsData = []
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
        }
    }
}
</script>
<style>
.description {
  height: 40px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>