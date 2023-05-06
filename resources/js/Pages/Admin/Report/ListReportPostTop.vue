<template>
    <AppLayoutAdmin :currentTab="'tab-5'" :currentTabChild="'tab-2'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Danh sách báo cáo vi phạm
            </div>
            <div class="mt-[12px] flex items-center text-[15px] border-b-[3px] border-b-[#adb5bd]">
                <Link :href="route('admin.list-report-account-top')">
                    <div class="w-[120px] text-center py-[6px] cursor-pointer">
                        Người dùng
                    </div>
                </Link>
                <div class="w-[120px] text-center py-[6px] cursor-pointer bg-[#495057] text-white">
                    Bài viết
                </div>
            </div>
            <div class="my-[18px]">
                <div class="mb-[18px] flex items-center">
                    <el-select v-model="filterSearch.limit" class="max-w-[60px] ml-[8px]" @change="fetchData()">
                        <el-option
                            v-for="item in options"
                            :key="item"
                            :label="item"
                            :value="item"
                        />
                    </el-select>
                    <el-date-picker
                        v-model="filterSearch.date"
                        type="month"
                        class="max-w-[280px] mx-[28px]"
                        placeholder="Chọn theo tháng năm"
                        format="MM-YYYY"
                        value-format="DD-MM-YYYY"
                        @change="fetchData()"
                    />
                    <el-input class="max-w-[300px]" v-model="filterSearch.search"
                        placeholder="Nhập từ khóa" clearable @keyup.enter="fetchData()"/>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template #post_title="{ row }">
                        <div class="text-left cursor-pointer hover:text-[blue]" @click="openPost(row)">
                            {{row.post_title}}
                        </div>
                    </template>
                    <template #post_status="{ row }">
                        <div class="h-[36px] flex justify-center items-center">
                            <el-switch v-model="row.post_status"
                              style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                              inline-prompt
                              active-text="Activated"
                              inactive-text="Deactivated"
                              disabled/>
                        </div>
                    </template>
                    <template #post_image="{ row }">
                        <img :src="row.post_image" class="h-[140px] w-[100%] object-cover">
                    </template>
                    <template #options="{ row }">
                        <div class="flex justify-center items-center">
                            <el-dropdown>
                                <span class="p-[4px] text-[20px] cursor-pointer outline-none">
                                    <i class="bi bi-gear-fill"></i>
                                </span>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item @click="deletePost(row)">
                                            <div class="w-[130px]">
                                                Xóa bài viết
                                            </div>
                                        </el-dropdown-item>
                                        <el-dropdown-item @click="changeStatusPost(row)">
                                            <div class="w-[130px]">
                                                Thay đổi trạng thái
                                            </div>
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                        </div>
                    </template>
                </DataTable>
                <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                    <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                      paginate-background/>
                </div>
            </div>
            <ShowPostForm ref="showPostForm"/>
            <ShowReportForm ref="showReportForm" />
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import { ElMessage, ElMessageBox } from 'element-plus'
import ShowPostForm from './DialogPost/ShowPost.vue'
import ShowReportForm from './DialogPost/ShowReport.vue'
import axios from 'axios'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        ShowPostForm,
        ShowReportForm
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'post_title', label: 'Bài viết', align: 'center'},
                { key: 'post_image', label: 'Hình ảnh', align: 'center', width: 240},
                { key: 'post_status', label: 'Trạng thái', align: 'center', width: 200},
                { key: 'count_report', label: 'Số lượng', align: 'center', sortable: true, width: 160 },
                { key: 'options', label: 'Tùy chỉnh', align: 'center', width: 120 },
            ],
            options: [10, 20, 30],
            filterSearch: {
                limit: 10,
                date: '',
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
        document.title = `Quản lý báo cáo bài viết - Admin hệ thống`
    },
    methods: {
        clearFilter() {
            this.filterSearch.page = 1
            this.filterSearch.type = "0"
            this.filterSearch.search = ""
            this.filterSearch.limit = 10
            this.paginate = []
            this.tableData = []
        },
        async fetchData() {
            const pagram = { ...this.filterSearch }
            const response = await axios.get(route('admin.report-posts.list-top', pagram))
            this.tableData = response.data.data
            this.paginate = response.data.meta
        },
        handleCurrentPage(value) {
            this.filterSearch.page = value
            this.fetchData()
        },
        handleSelectionChange(value) {
            this.selectedValue = value
        },
        openPost(row) {
            this.$refs.showPostForm.open(row)
        },
        deletePost(row) {
            ElMessageBox.confirm(
                `Bạn có muốn xoá bài viết ${row.post_title} không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.delete(route('admin.posts.destroy', row.post_id))
                    .then(response => {
                        this.fetchData()
                        ElMessage({
                            type: 'success',
                            message: 'Xóa bài viết thành công',
                        })
                    })
            })
            .catch(() => {})
        },
        changeStatusPost(row) {
            ElMessageBox.confirm(
                `Bạn có muốn thay đổi trạng thái bài viết ${row.post_title} không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.get(route('admin.posts.change-status', row.post_id))
                    .then(response => {
                        this.fetchData()
                        ElMessage({
                            type: 'success',
                            message: 'Thay đổi trạng thái bài viết thành công',
                        })
                    })
            })
            .catch(() => {})
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
    .el-range-input {
        font-size: 13px !important;
    }
</style>
  