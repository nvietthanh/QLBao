<template>
    <AppLayoutAdmin :currentTab="'tab-4'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Danh sách bài viết 
            </div>
            <div class="mt-[12px] flex items-center text-[15px] border-b-[3px] border-b-[#adb5bd]">
                <div class="w-[120px] text-center py-[6px] cursor-pointer"
                 :class="{ 'bg-[#495057] text-white' : tab == 'tab-0' }" @click="changeTab('tab-0')">
                    Đã duyệt
                </div>
                <div class="w-[120px] text-center py-[6px] cursor-pointer"
                 :class="{ 'bg-[#495057] text-white' : tab == 'tab-1' }" @click="changeTab('tab-1')">
                    Chưa duyệt
                </div>
            </div>
            <div class="my-[24px]">
                <div class="mb-[18px] flex items-center">
                    <el-select v-model="filterSearch.limit" class="max-w-[60px] ml-[8px]" @change="fetchData()">
                        <el-option
                            v-for="item in options"
                            :key="item"
                            :label="item"
                            :value="item"
                        />
                    </el-select>
                    <el-select class="ml-[18px]" v-model="filterSearch.categorySelect" placeholder="Chọn danh mục" 
                        multiple multiple-limit="2" clearable @change="fetchData">
                        <el-option
                            v-for="item in this.$page.props.categories"
                            :key="item.slug"
                            :label="item.name"
                            :value="item.slug"
                        />
                    </el-select>
                    <el-input class="mx-[20px] max-w-[300px]" v-model="filterSearch.search"
                        placeholder="Nhập từ khóa" clearable @keyup.enter="fetchData()"/>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template #title="{ row }">
                        <div class="text-left cursor-pointer hover:text-[blue]" @click="editPost(row)">
                            {{row.title}}
                        </div>
                    </template>
                    <template #slug="{ row }">
                        <div class="text-left hover:text-[blue]">
                            <Link :href="route('post', row.slug)">{{row.slug}}</Link>
                        </div>
                    </template>
                    <template #content="{ row }">
                        <div class="text-left post-content" v-html="row.content"></div>
                    </template>
                    <template #image="{ row }">
                        <img :src="row.image" alt="" class="object-cover h-[140px] w-[100%]">
                    </template>
                    <template #created_at="{ row }">
                        {{ row.created_at }}
                        <div class="mx-[6px]">({{ row.creator }})</div>
                    </template>
                    <template #updated_at="{ row }">
                        {{ row.updated_at }}
                        <div class="mx-[6px]">({{ row.updater }})</div>
                    </template>
                </DataTable>
                <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                    <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                      paginate-background/>
                </div>
            </div>
            <EditPostForm ref="editPostForm" @change-post="fetchData"/>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import ShowPostForm from './Dialog/ShowPost.vue'
import EditPostForm from './Dialog/EditPost.vue'
import AddPostForm from './Dialog/AddPost.vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        ShowPostForm,
        EditPostForm
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'title', label: 'Tiêu đề', align: 'center', width: 220 },
                { key: 'categoryName', label: 'Chủ đề', align: 'center', width: 180 },
                // { key: 'description', label: 'Mô tả', align: 'center', width: 180 },
                { key: 'content', label: 'Nội dung', align: 'center' },
                { key: 'image', label: 'Hình ảnh', align: 'center', width: 180 },
                { key: 'count_view', label: 'View', align: 'center', width: 70 },
                { key: 'created_at', label: 'Ngày tạo', align: 'center', width: 140 },
                { key: 'updated_at', label: 'Ngày cập nhật', align: 'center', width: 140 },
            ],
            options: [6, 12, 24, 32],
            filterSearch: {
                limit: 6,
                categorySelect: [],
                search: '',
                page: 1
            },
            paginate: [],
            tableData: [],
            selectedValue: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        clearFilter() {
            this.filterSearch.page = 1
            this.filterSearch.isApproved = "2"
            this.filterSearch.search = ""
            this.filterSearch.limit = 10
            this.paginate = []
            this.tableData = []
        },
        async fetchData() {
            const pagram = { ...this.filterSearch }
            const response = await axios.get(route('admin.posts.index', pagram))
            this.tableData = response.data.data
            this.paginate = response.data.meta
        },
        changeTab(tab) {
            this.tab = tab
            this.clearFilter()
            if(this.tab == 'tab-0') {
                this.filterSearch.isApproved = true
            }
            else {
                this.filterSearch.isApproved = false
            }
            this.fetchData()
        },
        handleCurrentPage(value) {
            this.filterSearch.page = value
            this.fetchData()
        },
        handleSelectionChange(value) {
            this.selectedValue = value
        },
        editPost(row) {
            this.$refs.editPostForm.open(row)
        },
        deleteSelections() {
            if(this.selectedValue.length == 0){
                ElMessage({
                    type: 'warning',
                    message: 'Chọn tài khoản người dùng muốn xóa',
                })
            }
            else{
                ElMessageBox.confirm(
                    `Bạn có muốn xóa các tài khoản đã chọn không?`,
                    'Warning',
                    {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                        type: 'warning',
                        draggable: true,
                    }
                )
                .then(() => {
                    const pagram = { ...{'accounts' : this.selectedValue} }
                    axios.post(route('admin.users.delete-accounts'), pagram)
                        .then(response => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Delete completed',
                            })
                        })
                })
                .catch(() => {})
            }
        }
    }
}
</script>
<style>
    .el-table__header-wrapper thead {
        color: #000;
    }
    .cell .el-checkbox{
        height: 30px !important;
    }
    .post-content {
        height: 160px;
        max-height: 160px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 7;
        line-clamp: 7;
        -webkit-box-orient: vertical;
    }
</style>
  