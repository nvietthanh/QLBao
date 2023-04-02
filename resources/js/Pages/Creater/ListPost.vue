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
                    <div class="mt-[12px] mb-[16px] mx-[12px] grid grid-cols-3 gap-3">
                        <div v-for="item in postsData" class="mt-[8px] relative post-item">
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
                                    <div class="ml-[16px] text-[13px] mt-[4px]">{{ item.time }}</div>
                                </div>
                            </div>
                            <div class="post-icon absolute top-[8px] right-[8px] h-[24px] w-[28px] text-center
                              cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[18px] active:scale-95 hover:bg-[#ced4da]" 
                              @click="showPost(item)">
                                <i class="bi bi-eye"></i>
                            </div>
                            <div class="post-icon absolute top-[38px] right-[8px] h-[24px] w-[28px] text-center pt-[3px]
                              cursor-pointer bg-[#fff] rounded-[4px] box-shadow text-[14px] active:scale-95 hover:bg-[#ced4da]" 
                              @click="editPost(item)">
                                <i class="bi bi-pen mb-[4px]"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-[24px] mb-[64px] justify-center">
                        <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filter.page || 1"
                          paginate-background/>
                    </div>
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
            filter: {
                limit: 15,
                categorySelect: [],
                search: '',
                page: 1,
            },
            paginate: [],
            postsData: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
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
        }
    }
}
</script>