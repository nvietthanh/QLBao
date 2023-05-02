<template>
    <AppLayoutAdmin :currentTab="'tab-3'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Danh sách hagtag
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
                    <div class="bg-[blue] text-[14px] py-[5px] px-[18px] text-white rounded-[4px] cursor-pointer" @click="addHagtag">
                        Thêm mới
                    </div>
                    <div class="ml-[24px] bg-[red] text-[14px] py-[5px] px-[24px] text-white rounded-[4px] cursor-pointer"
                     @click="deleteSelections">
                        Xóa
                    </div>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template #options="{ row }">
                        <span class="px-[8px] py-[8px] text-[20px] cursor-pointer" @click="editHagtag(row)">
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
            <AddHagtagForm ref="addHagtagForm" @change-hagtag="fetchData()"/>
            <EditHagtagForm ref="editHagtagForm" @change-hagtag="fetchData()"/>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import AddHagtagForm from './Dialog/AddHagtag.vue'
import EditHagtagForm from './Dialog/EditHagtag.vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        AddHagtagForm,
        EditHagtagForm
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'name', label: 'Tên chủ đề', align: 'center', sortable: true},
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
            this.filterSearch.search = ""
            this.filterSearch.limit = 10
            this.paginate = []
            this.tableData = []
        },
        async fetchData() {
            const pagram = { ...this.filterSearch }
            const response = await axios.get(route('admin.hagtags.index', pagram))
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
        addHagtag() {
            this.$refs.addHagtagForm.open()
        },
        editHagtag(row) {
            this.$refs.editHagtagForm.open(row)
        },
        deleteSelection(row) {
            ElMessageBox.confirm(
                `Bạn có muốn xóa hagtag ${row.name} không?`,
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                    draggable: true,
                }
            )
            .then(() => {
                axios.delete(route('admin.hagtags.destroy', row.id))
                    .then(response => {
                        this.fetchData()
                        ElMessage({
                            type: 'success',
                            message: 'Xóa hagtag thành công',
                        })
                    })
            })
            .catch(() => {})
        },
        deleteSelections() {
            if(this.selectedValue.length == 0){
                ElMessage({
                    type: 'warning',
                    message: 'Chọn hagtag muốn xóa',
                })
            }
            else{
                ElMessageBox.confirm(
                    `Bạn có muốn xóa các hagtag đã chọn không?`,
                    'Warning',
                    {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                        type: 'warning',
                        draggable: true,
                    }
                )
                .then(() => {
                    const pagram = { ...{'hagtags' : this.selectedValue} }
                    axios.post(route('admin.hagtags.delete-hagtags'), pagram)
                        .then(response => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Xoá hagtag thành công',
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
  