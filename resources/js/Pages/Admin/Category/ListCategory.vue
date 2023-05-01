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
                    <el-input class="mx-[20px] max-w-[300px]" v-model="filterSearch.search"
                                   placeholder="Nhập từ khóa" clearable @keyup="fetchData()"/>
                    <div class="bg-[blue] text-[14px] py-[5px] px-[18px] text-white rounded-[4px] cursor-pointer" @click="addCategory">
                        Thêm mới
                    </div>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template #options="{ row }">
                        <span class="px-[8px] py-[8px] text-[18px] cursor-pointer" @click="editCategory(row)">
                            <i class="bi bi-pencil-fill"></i>
                        </span>
                        <span class="px-[8px] py-[8px] text-[18px] cursor-pointer" @click="deleteSelection(row)">
                            <i class="bi bi-trash3-fill"></i>
                        </span>
                    </template>
                </DataTable>
                <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                    <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                      paginate-background/>
                </div>
            </div>
            <AddCategoryForm ref="addCategoryForm" @change-category="fetchData"/>
            <EditCategoryForm ref="editCategoryForm" @change-category="fetchData"/>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import AddCategoryForm from './Dialog/AddCategory.vue'
import EditCategoryForm from './Dialog/EditCategory.vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        AddCategoryForm,
        EditCategoryForm
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'name', label: 'Tên chủ đề', align: 'center'},
                { key: 'slug', label: 'Slug', align: 'center'},
                { key: 'created_at', label: 'Ngày tạo', align: 'center', width: 190 },
                { key: 'updated_at', label: 'Ngày cập nhật', align: 'center', width: 170 },
                { key: 'options', label: 'Tùy chỉnh', align: 'center', width: 180 },
            ],
            options: [10, 20, 30],
            filterSearch: {
                limit: 10,
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
        handleCurrentPage(value) {
            this.filterSearch.page = value
            this.fetchData()
        },
        handleSelectionChange(value) {
            this.selectedValue = value
        },
        changeStatus(row) {
            axios.get(route('admin.categories.change-status', row.id))
        },
        editCategory(row) {
            this.$refs.editCategoryForm.open(row)
        },
        addCategory() {
            this.$refs.addCategoryForm.open()
        },
        deleteSelection(row) {
            ElMessageBox.confirm(
                `Bạn có muốn xóa chủ đề ${row.name} không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.delete(route('admin.categories.destroy', row.id))
                    .then(response => {
                        this.fetchData()
                        ElMessage({
                            type: 'success',
                            message: 'Xóa chủ đề thành công',
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
</style>
  