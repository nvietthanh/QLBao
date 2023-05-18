<template>
    <AppLayoutAdmin :currentTab="'tab-6'" :currentTabChild="'tab-4'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Danh sách đối tác quảng cáo
            </div>
            <div class="mb-[24px] mt-[12px]">
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
                    <div class="bg-[blue] text-[14px] py-[5px] px-[18px] text-white rounded-[4px] cursor-pointer" @click="addAdvertist">
                        Thêm mới
                    </div>
                    <div class="ml-[18px] text-[14px] px-[24px] py-[5px] rounded-[4px] bg-[red] text-white cursor-pointer" @click="deletePosts">
                        Xóa quảng cáo
                    </div>
                </div>
                <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                    <template #slug="{ row }">
                        <div class="text-left hover:text-[blue]">
                            <Link :href="route('post', row.slug)">{{row.slug}}</Link>
                        </div>
                    </template>
                    <template #content="{ row }">
                        <div class="text-left post-content" v-html="row.content"></div>
                    </template>
                    <template #image="{ row }">
                        <img :src="row.image" alt="" class="object-cover h-[180px] w-[100%]">
                    </template>
                    <template #status="{ row }">
                        <div class="h-[36px] flex justify-center items-center">
                            <el-switch v-model="row.status"
                              style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                              inline-prompt
                              active-text="Activated"
                              inactive-text="Deactivated"
                              size="default"
                              @click="changeStatus(row)"
                            />
                        </div>
                    </template>
                    <template #options="{ row }">
                        <div class="flex justify-center">
                            <span class="text-[18px] cursor-pointer" @click="editAdvertist(row)">
                                <i class="bi bi-pencil-fill"></i>
                            </span>
                            <span class="pl-[8px] text-[18px] cursor-pointer" @click="deleteSelection(row)">
                                <i class="bi bi-trash3-fill"></i>
                            </span>
                        </div>
                    </template>
                </DataTable>
                <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                    <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                      paginate-background/>
                </div>
            </div>
            <AddAdvertistForm ref="addAdvertistForm" @change-advertist="fetchData"/>
            <EditAdvertistForm ref="editAdvertistForm" @change-advertist="fetchData"/>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import AddAdvertistForm from './Dialog/AddAdvertist.vue'
import EditAdvertistForm from './Dialog/EditAdvertist.vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'

export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        AddAdvertistForm,
        EditAdvertistForm
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'name', label: 'Tên đối tác', align: 'center' },
                { key: 'image', label: 'Hình ảnh', align: 'center', width: 300 },
                { key: 'status', label: 'Trạng thái', align: 'center', width: 120 },
                { key: 'created_at', label: 'Ngày tạo', align: 'center', width: 160 },
                { key: 'updated_at', label: 'Ngày cập nhật', align: 'center', width: 160 },
                { key: 'options', label: 'Options', align: 'center', width: 90 },
            ],
            options: [6, 12, 24, 32],
            filterSearch: {
                limit: 6,
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
        document.title = `Quản lý quảng cáo - Admin hệ thống`
    },
    methods: {
        clearFilter() {
            this.filterSearch.page = 1
            this.filterSearch.search = ""
            this.filterSearch.limit = 6
            this.paginate = []
            this.tableData = []
        },
        async fetchData() {
            const pagram = { ...this.filterSearch }
            const response = await axios.get(route('admin.advertists.index', pagram))
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
        addAdvertist() {
            this.$refs.addAdvertistForm.open()
        },
        editAdvertist(row) {
            console.log(row)
            this.$refs.editAdvertistForm.open(row.id)
        },
        changeStatus(row) {
            axios.get(route('admin.advertists.change-status', row.id))
                .then(response => {
                    this.fetchData()
                })
        },
        deletePosts() {
            if(this.selectedValue.length == 0) {
                ElMessage({
                    type: 'warning',
                    message: 'Vui lòng chọn bài viết muốn xóa',
                })
            }
            else {
                ElMessageBox.confirm(
                    `Bạn có muốn xóa các bài viết vừa chọn không?`,
                    'Warning',
                    {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                        type: 'warning',
                        draggable: true,
                    }
                )
                .then(() => {
                    const pagram = { ...{
                        'advertists': this.selectedValue
                    } }
                    axios.post(route('admin.advertists.delete-advertists'), pagram)
                        .then(response => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Xóa bài viết thành công',
                            })
                        })
                })
                .catch(() => {})
            }
        },
        deleteSelection(row) {
            axios.delete(route('admin.advertists.destroy', row.id))
                .then(response => {
                    this.fetchData()
                    ElMessage({
                        type: 'success',
                        message: 'Xóa bài viết thành công',
                    })
                })
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
  