<template>
    <header class="fixed top-0 left-0 right-0 h-[56px] leading-[56px] bg-[#fff] border-b-[2px] border-b-[#ced4da]">
        <div class="mr-[18px] flex justify-between">
            <div>
                <div class="flex justify-between items-center text-[16px] mx-[12px]">
                    <div class="text-[28px] cursor-pointer ml-[3px]" @click="triggerMenu">
                        <i class="bi bi-list"></i>
                    </div>
                    <span class="text-[17px] ml-[16px]">Trang chủ</span>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-[18px] text-[20px] cursor-pointer">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="flex items-center">
                    <span class="text-[13px] mr-[4px]">{{ this.$page.props.auth.user.name }}</span>
                    <img src="/image/cf2a58bd5ff0b6aeefe1.jpg" alt="" class="w-[32px] h-[32px] rounded-[50%] object-cover cursor-pointer">
                </div>
            </div>
        </div>
    </header>
    <main>
        <div id="slide" class="fixed top-[56px] bottom-0 w-[260px] border-r-[2px] bg-[#4e73df] text-white py-[12px]"
         :class="{ 'slide-menu' : !isOpenMenu }">
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[24px]"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="ml-[8px]">Thống kê</div>
                </div>
            </div>
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[24px]"><i class="bi bi-people-fill"></i></div>
                    <div class="ml-[8px]">Quản lý người dùng</div>
                </div>
            </div>
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[24px]"><i class="bi bi-book"></i></div>
                    <div class="ml-[8px]">Quản lý chủ đề</div>
                </div>
            </div>
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[24px]"><i class="bi bi-tags"></i></div>
                    <div class="ml-[8px]">Quản lý hagtag</div>
                </div>
            </div>
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[24px]"><i class="bi bi-card-text"></i></div>
                    <div class="ml-[8px]">Quản lý bài báo</div>
                </div>
            </div>
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[24px]"><i class="bi bi-card-text"></i></div>
                    <div class="ml-[8px]">Quản lý bài báo</div>
                </div>
            </div>
            <div class="mx-[3px] text-[15px]">
                <div class="px-[12px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer border-b-[1px]">
                    <div class="text-[18px] w-[22px]"><i class="bi bi-flag"></i></div>
                    <div class="ml-[8px]">Quản lý báo cáo vi phạm</div>
                </div>
            </div>
        </div>
        <slot name="main-full"/>
    </main>
    <footer>
        agag
    </footer>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import Dropdown from "@/Components/Dropdown.vue";

export default {
    components: {
        Link,
        Dropdown,
    },
    data() {
        return {
            isOpenMenu: true,
        }
    },
    created() {
    },
    methods: {
        triggerMenu() {
            this.isOpenMenu = !this.isOpenMenu
        }
    }
}
</script>

<style>
.slide-menu {
    display: none;
    transition: linear all 1s;
}
header,
#slide{
    -moz-user-select: none !important;
    -webkit-touch-callout: none!important;
    -webkit-user-select: none!important;
    -khtml-user-select: none!important;
    -moz-user-select: none!important;
    -ms-user-select: none!important;
    user-select: none!important;
}
</style>
