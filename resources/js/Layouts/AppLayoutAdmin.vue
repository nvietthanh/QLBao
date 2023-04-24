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
                <Dropdown align="right" class="text-[#000]" :contentClasses="[backgroundColor]">
                    <template #trigger>
                        <div class="flex items-center">
                            <span class="text-[13px] mr-[4px]">{{ this.$page.props.auth.user.name }}</span>
                            <img src="/image/cf2a58bd5ff0b6aeefe1.jpg" alt="" class="w-[32px] h-[32px] rounded-[50%] object-cover cursor-pointer">
                        </div>
                    </template>
                    <template #content>
                        <div class="py-[8px]">
                            <Link>
                                <div class="text-[14px] h-[36px] flex items-center pl-[18px] cursor-pointer hover:bg-[#dee2e6]">
                                    <span class="text-[16px]"><i class="bi bi-person-vcard"></i></span>
                                    <span class="ml-[8px]">Quản lý thông tin</span>
                                </div>
                            </Link>
                            <div class="text-[14px] h-[36px] flex items-center pl-[18px] cursor-pointer hover:bg-[#dee2e6]"
                                @click="logout">
                                <span class="text-[16px]"><i class="bi bi-box-arrow-right"></i></span>
                                <span class="ml-[8px]">Đăng xuất</span>
                            </div>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>
    </header>
    <main>
        <div id="slide" class="fixed top-[56px] bottom-0 w-[286px] border-r-[2px] bg-[#4e73df] text-white pt-[12px]
            pb-[58px] max-h-[100%] overflow-y-scroll"
         :class="{ 'slide-menu' : !isOpenMenu }">
            <div class="w-[100%]">                    
                <div v-for="menu in menus" class="text-[15px]" :id="menu.tab">
                    <template v-if="menu.route">
                        <Link :href="route(menu.route)">
                            <div class="px-[24px] py-[10px] hover:bg-[#6f8cdf] flex items-center
                            cursor-pointer"
                            :class="{ 'bg-[#6f8cdf]' : menu.tab == currentTab }">
                                <div v-html="menu.icon" class="text-[18px] w-[24px]"></div>
                                <div class="mx-[8px]">{{ menu.name }}</div>
                            </div>
                        </Link>
                    </template>
                    <template v-else>
                        <div class="menu" :class="{ 'menu-active' : currentTab == menu.tab }">
                            <div class="px-[24px] py-[10px] hover:bg-[#6f8cdf] flex items-center cursor-pointer"
                              @click="openMenuChild(menu.tab)">
                                <div v-html="menu.icon" class="text-[18px] w-[24px]"></div>
                                <div class="mx-[8px]">{{ menu.name }}</div>
                                <span class="text-[12px]">
                                    <i class="bi bi-chevron-down"></i>
                                    <i class="bi bi-chevron-up"></i>
                                </span>
                            </div>
                            <div class="menu-childs ml-[32px]">
                                <div v-for="menuChild in menu.menuChild" class="text-[15px]">
                                    <Link :href="route(menuChild.route)">
                                        <div class="px-[24px] py-[12px] hover:bg-[#6f8cdf] flex items-center cursor-pointer"
                                        :class="{ 'bg-[#6f8cdf]' : menuChild.tab == currentTabChild && currentTab == menu.tab }">
                                            {{ menuChild.name }}
                                        </div>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <form method="POST" @click="logout" class="flex justify-center">
                <div class="w-[130px] h-[36px] leading-[36px] rounded-[4px] text-[15px] text-center mt-[42px] 
                  cursor-pointer border-[1px] hover:bg-[#6f8cdf]">
                    <span class="text-[18px]"><i class="bi bi-box-arrow-right"></i></span>
                    <span class="ml-[8px]">Đăng xuất</span>
                </div>
            </form>
        </div>
        <div class="mt-[57px] min-h-[630px] py-[12px] px-[24px]" :class="{ 'px-[28px]' : !isOpenMenu, 'ml-[280px]' : isOpenMenu}">
            <slot name="main-full"/>
        </div>
    </main>
    <footer :class="{ 'ml-[280px]' : isOpenMenu }">
        <div class="mx-[18px] flex justify-between my-[24px] text-[14px] text-[#6c757d]">
            <div>Copyright © Nguyễn Viết Thanh</div>
            <div>Privacy Policy · Terms & Conditions</div>
        </div>
    </footer>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import Dropdown from "@/Components/Dropdown.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        Link,
        Dropdown,
    },
    props: {
        title: String,
        currentTab: { type: String, required: true },
        currentTabChild: { type: String, required: true },
        backgroundColor: {
            type: String,
            default: "bg-[#fff]",
        },
    },
    data() {
        return {
            menus: [
                {
                    icon: '<i class="bi bi-graph-up-arrow"></i>',
                    name: 'Thống kê',
                    route: 'admin.dashboard',
                    tab: 'tab-0'
                },
                {
                    icon: '<i class="bi bi-people-fill"></i>',
                    name: 'Quản lý người dùng',
                    route: 'admin.list-account',
                    tab: 'tab-1'
                },
                {
                    icon: '<i class="bi bi-book"></i>',
                    name: 'Quản lý chủ đề',
                    route: 'admin.list-category',
                    tab: 'tab-2'
                },
                {
                    icon: '<i class="bi bi-tag-fill"></i>',
                    name: 'Quản lý hagtag',
                    route: 'admin.list-hagtag',
                    tab: 'tab-3'
                },
                {
                    icon: '<i class="bi bi-card-text"></i>',
                    name: 'Quản lý bài báo',
                    route: 'admin.list-post',
                    tab: 'tab-4'
                },
                {
                    icon: '<i class="bi bi-flag"></i>',
                    name: 'Quản lý báo cáo vi phạm',
                    route: '',
                    tab: 'tab-5',
                    menuChild: [
                        {
                            name: 'Thống kê theo ngày',
                            route: 'admin.list-report-account',
                            tab: 'tab-1'
                        },
                        {
                            name: 'Thống kê theo số lượng',
                            route: 'admin.list-report-account-top',
                            tab: 'tab-2'
                        },
                    ]
                },
                {
                    icon: '<i class="bi bi-fullscreen"></i>',
                    name: 'Trang chủ',
                    route: '',
                    tab: 'tab-6',
                    menuChild: [
                        {
                            name: 'Liên hệ',
                            route: 'admin.about-us',
                            tab: 'tab-3'
                        },
                        {
                            name: 'Điều khoản sử dụng',
                            route: 'admin.term-of-use',
                            tab: 'tab-1'
                        },
                        {
                            name: 'Chính sách bảo mật',
                            route: 'admin.private-policy',
                            tab: 'tab-2'
                        },
                        {
                            name: 'Tiêu chuẩn cộng đồng',
                            route: 'admin.private-policy',
                            tab: 'tab-2'
                        },
                    ]
                }
            ],
            isOpenMenu: true,
        }
    },
    created() {
    },
    methods: {
        triggerMenu() {
            this.isOpenMenu = !this.isOpenMenu
        },
        logout() {
            Inertia.get(route("admin.logout"));
        },
        openMenuChild(menu) {
            document.getElementById(menu).querySelector('.menu').classList.toggle('menu-active')
        }
    }
}
</script>

<style>
.slide-menu {
    display: none;
    transition: linear all 1s;
}
header {
    z-index: 1000;
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

#slide::-webkit-scrollbar {
    width: 10px;
}

/* Track */
#slide::-webkit-scrollbar-track {
    background: #fff;
}

/* Handle */
#slide::-webkit-scrollbar-thumb {
    background: #ced4da;
    border-radius: 10px;
}

/* .menu:hover .menu-childs, */
.menu-active .menu-childs {
    display: block;
    transition: all 3s linear;
}
.menu-childs {
    display: none;
}
.bi-chevron-down {
    display: none;
}
.bi-chevron-up {
    display: contents;
}
/* .menu:hover .bi-chevron-up, */
.menu-active .bi-chevron-up {
    display: none;
}
/* .menu:hover .bi-chevron-down, */
.menu-active .bi-chevron-down {
    display: contents;
}
</style>
