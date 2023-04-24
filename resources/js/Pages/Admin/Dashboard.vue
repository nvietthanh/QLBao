<template>
    <AppLayoutAdmin :currentTab="'tab-0'">
        <template v-slot:main-full>
            <div class="mt-[12px] mb-[24px] font-bold text-[20px] uppercase">
                Thống kê
            </div>
            <div class="mb-[24px]">
                <el-date-picker
                    v-model="filters.dateRange"
                    type="daterange"
                    start-placeholder="Ngày bắt đầu"
                    end-placeholder="Ngày kết thúc"
                    :size="small"
                    format="DD-MM-YYYY"
                    value-format="DD-MM-YYYY"
                    class="max-w-[260px] mx-[28px]"
                    @change="fetchData()"
                />
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-[#01A3A4] text-white p-[24px] rounded-[8px]">
                    <div class="text-[26px] font-bold">24</div>
                    <div class="mt-[18px] text-[15px] uppercase">Người dùng</div>
                </div>
                <div class="bg-[#0ABDE3] text-white p-[24px] rounded-[8px]">
                    <div class="text-[26px] font-bold">24</div>
                    <div class="mt-[18px] text-[15px] uppercase">Tác giả</div>
                </div>
                <div class="bg-[#F46B9C] text-white p-[24px] rounded-[8px]">
                    <div class="text-[26px] font-bold">24</div>
                    <div class="mt-[18px] text-[15px] uppercase">Bài viết</div>
                </div>
            </div>
            <div class="mt-[32px]">

            </div>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'

export default{
    components:{
        AppLayoutAdmin,
        Link,
    },
    data() {
        return {
            currentTab: 'kinh-te',
            filters: {
                dateRange: ''
            },
            comment: ''
        }  
    },
    methods: {
        fetchData() {

        }
    }
}
</script>

<style>
    .el-date-editor {
        margin: 0;
    }
</style>
  