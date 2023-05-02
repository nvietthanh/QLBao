<template>
    <AppLayoutAdmin :currentTab="'tab-1'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Danh sách người dùng
            </div>
            <div class="mt-[12px] flex items-center text-[15px] border-b-[3px] border-b-[#adb5bd]">
                <div class="w-[120px] text-center py-[6px] cursor-pointer"
                 :class="{ 'bg-[#495057] text-white' : tab == 'tab-0' }" @click="changeTab('tab-0')">
                    Người đọc
                </div>
                <div class="w-[120px] text-center py-[6px] cursor-pointer"
                 :class="{ 'bg-[#495057] text-white' : tab == 'tab-1' }" @click="changeTab('tab-1')">
                    Tác giả
                </div>
            </div>
            <div class="my-[28px]">
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
                    <div class="text-[14px] bg-[red] w-[130px] h-[32px] leading-[32px] text-white 
                     text-center rounded-[4px] cursor-pointer" @click="deleteSelections">
                        Xóa người dùng
                    </div>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template class="flex justify-center" #status ="{ row }">
                        <div class="h-[36px] flex justify-center items-center">
                            <el-switch v-model="row.status"
                              style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                              inline-prompt
                              active-text="Activated"
                              inactive-text="Deactivated"
                              disabled
                            />
                        </div>
                    </template>
                    <template #options="{ row }">
                        <span v-if="tab == 'tab-0'" class="px-[6px] py-[8px] text-[22px] cursor-pointer"
                         @click="changeToCreator(row)">
                            <i class="bi bi-person-check"></i>
                        </span>
                        <span v-else class="px-[6px] py-[8px] text-[22px] cursor-pointer"
                         @click="changeToReader(row)">
                            <i class="bi bi-person-fill-dash"></i>
                        </span>
                        <span class="px-[6px] py-[8px] text-[20px] cursor-pointer" @click="changeStatus(row)">
                            <i class="bi bi-gear-fill"></i>
                        </span>
                        <span class="px-[6px] py-[8px] text-[20px] cursor-pointer" @click="deleteSelection(row)">
                            <i class="bi bi-trash3-fill"></i>
                        </span>
                    </template>
                </DataTable>
                <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                    <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                      paginate-background/>
                </div>
            </div>
            <ShowChangeStatustForm ref="showChangeStatusForm" @change-account="fetchData()"/>
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
import ShowChangeStatustForm from './Dialog/ChangeStatusForm.vue'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        ShowChangeStatustForm
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'code', label: 'Code', align: 'center', width: 120 },
                { key: 'name', label: 'Họ tên', align: 'center' },
                { key: 'email', label: 'Email', align: 'center' },
                { key: 'created_at', label: 'Ngày tạo', align: 'center', width: 180 },
                { key: 'status', label: 'Trạng thái', align: 'center', width: 150 },
                { key: 'status_expires_at', label: 'Thời gian mở khóa', align: 'center', width: 160 },
                { key: 'options', label: 'Tùy chỉnh', align: 'center', width: 130 },
            ],
            options: [10, 20, 30],
            filterSearch: {
                limit: 10,
                type: 'Reader',
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
            const response = await axios.get(route('admin.accounts.index', pagram))
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
            this.$refs.showChangeStatusForm.open(row)
        },
        changeToCreator(row) {
            ElMessageBox.confirm(
                `Bạn có muốn chuyển người dùng ${row.email} thành tác giả không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.get(route('admin.accounts.change-to-creator', row.id))
                .then(response => {
                    this.fetchData()
                    ElMessage({
                        type: 'success',
                        message: 'Chuyển người dùng thành tác giả thành công',
                    })
                })
            })
            .catch(() => {})
        },
        changeToReader(row) {
            ElMessageBox.confirm(
                `Bạn có muốn chuyển tác giả ${row.email} thành độc giả không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.get(route('admin.accounts.change-to-reader', row.id))
                .then(response => {
                    this.fetchData()
                    ElMessage({
                        type: 'success',
                        message: 'Chuyển người dùng thành độc giả thành công',
                    })
                })
            })
            .catch(() => {})
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
                axios.delete(route('admin.accounts.destroy', row.id))
                    .then(response => {
                        this.fetchData()
                        ElMessage({
                            type: 'success',
                            message: 'Xoá tài khoản người dùng thành công',
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
                    axios.post(route('admin.accounts.delete-accounts'), pagram)
                        .then(response => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Xoá tài khoản người dùng thành công',
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
  