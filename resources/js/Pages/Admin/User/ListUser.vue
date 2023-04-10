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
                    <el-input class="mx-[20px] max-w-[300px]" v-model="filterSearch.search"
                                   placeholder="Nhập từ khóa" clearable @keyup.enter="fetchData()"/>
                    <div class="text-[14px] bg-[red] w-[60px] h-[32px] leading-[32px] text-white 
                     text-center rounded-[4px] cursor-pointer" @click="deleteSelections">
                        Xóa
                    </div>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template class="flex justify-center" #status ="{ row }">
                        <div class="h-[36px] flex justify-center items-center" @click="changeStatus(row)">
                            <div class="w-[34px] h-[18px] cursor-pointer rounded-[12px] flex items-center bg-[red]"
                              :class="{ 'bg-[green] justify-end' : row.status }">
                                <div class="ml-[1px] w-[16px] h-[16px] rounded-[50%] bg-[#fff]"
                                  :class="{ 'mr-[1px]' : row.status }"/>
                            </div>
                            <span class="ml-[6px] text-[13px]" v-if="row.status">Activated</span>
                            <span class="ml-[6px] text-[13px]" v-else>Deactivated</span>
                        </div>
                    </template>
                    <template #options="{ row }">
                        <span class="px-[16px] py-[8px] text-[20px] cursor-pointer" @click="deleteSelection(row)">
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
import { ElMessage } from 'element-plus'
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
                { key: 'code', label: 'Code', align: 'center', width: 120 },
                { key: 'name', label: 'Họ tên', align: 'center', width: 200 },
                { key: 'email', label: 'Email', align: 'center', width: 240 },
                { key: 'updated_at', label: 'Ngày tạo', align: 'center', width: 180 },
                { key: 'created_at', label: 'Ngày cập nhật', align: 'center', width: 160 },
                { key: 'status', label: 'Trạng thái', align: 'center', width: 150 },
                { key: 'options', label: 'Tùy chỉnh', align: 'center', width: 130 },
            ],
            options: [10, 20, 30],
            filterSearch: {
                limit: 10,
                type: 'Reader',
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
            this.paginate = []
            this.tableData = []
        },
        async fetchData() {
            const pagram = { ...this.filterSearch }
            const response = await axios.get(route('admin.users.index', pagram))
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
            axios.get(route('admin.users.change-status', pagram))
                .then(response => {
                    row.status = !row.status
                })
                .catch(error => {})
        },
        deleteSelection(row) {
            axios.delete(route('admin.users.destroy', row.id))
                .then(response => {
                    this.fetchData()
                })
                .catch(error => {})
        },
        deleteSelections() {
            if(this.selectedValue.length == 0){
                ElMessage({
                    type: 'warning',
                    message: 'Chọn tài khoản người dùng muốn xóa',
                })
            }
        },
        handleEdit(index, row) {
            console.log(row)
        },
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
  