<template>
    <AppLayoutAdmin :currentTab="'tab-2'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Danh sách chủ đề
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
                    <el-select v-model="filterSearch.isApproved" class="max-w-[140px] ml-[20px]" @change="fetchData()">
                        <el-option label="Tất cả" value="2"/>
                        <el-option label="Đã kích hoạt" value="1"/>
                        <el-option label="Chưa kích hoạt" value="0"/>
                    </el-select>
                    <el-input class="mx-[20px] max-w-[300px]" v-model="filterSearch.search"
                                   placeholder="Nhập từ khóa" clearable @keyup.enter="fetchData()"/>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template class="flex justify-center" #status ="{ row }">
                        <div class="h-[36px] flex justify-center items-center">
                            <el-switch v-model="row.status"  @click="changeStatus(row)"/>
                            <span class="ml-[6px] text-[13px]" v-if="row.status">Activated</span>
                            <span class="ml-[6px] text-[13px]" v-else>Deactivated</span>
                        </div>
                    </template>
                    <template #options="{ row }">
                        <span class="px-[8px] py-[8px] text-[20px] cursor-pointer" @click="editCategory(row)">
                            <i class="bi bi-pencil-fill"></i>
                        </span>
                        <span class="px-[8px] py-[8px] text-[20px] cursor-pointer" @click="deleteSelection(row)">
                            <i class="bi bi-trash3-fill"></i>
                        </span>
                    </template>
                </DataTable>
                <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                    <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                      paginate-background/>
                </div>
            </div>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'name', label: 'Tên chủ đề', align: 'center'},
                { key: 'slug', label: 'Slug', align: 'center'},
                { key: 'created_at', label: 'Ngày tạo', align: 'center', width: 190 },
                { key: 'updated_at', label: 'Ngày cập nhật', align: 'center', width: 170 },
                { key: 'status', label: 'Trạng thái', align: 'center', width: 180 },
                { key: 'options', label: 'Tùy chỉnh', align: 'center', width: 180 },
            ],
            options: [10, 20, 30],
            filterSearch: {
                limit: 10,
                isApproved: "2",
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
            const response = await axios.get(route('admin.categories.index', pagram))
            this.tableData = response.data.data
            this.paginate = response.data.meta
        },
        changeTab(tab) {
            this.tab = tab
            this.clearFilter()
            if(this.tab == 'tab-0') {
                this.filterSearch.type = 'Reader'
            }
            else {
                this.filterSearch.type = 'Creator'
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
        changeStatus(row) {
            const pagram = {
                ...{ 'id': row.id }
            }
            axios.get(route('admin.categories.change-status', pagram))
        },
        editCategory(row) {
            alert('thay doi nhe')
        },
        deleteSelection(row) {
            ElMessageBox.confirm(
                `Bạn có muốn xóa tài khoản ${row.email} không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.delete(route('admin.users.destroy', row.id))
                    .then(response => {
                        this.fetchData()
                        ElMessage({
                            type: 'success',
                            message: 'Delete completed',
                        })
                    })
            })
            .catch(() => {})
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
</style>
  