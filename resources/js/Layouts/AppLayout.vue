<template>
    <header class="fixed top-0 left-0 right-0 z-1000">
        <div class="header-search">
            <div class="flex items-center h-[62px] bg-[#ffffff] text-white">
                <div class="main">
                    <div class="row">
                        <div class="col-2 flex items-center cursor-pointer text-black pr-5">
                            <Link :href="route('home')">
                            <img src="/image/logo/logo.png" alt="Logo bao moi" class="h-[60px]">
                            </Link>
                        </div>
                        <div class="col-6 mt-1 flex items-center search relative">
                            <Dropdown align="left" class="right-0 w-[100%] text-[#000]" :contentClasses="[backgroundColor]">
                                <template #trigger>
                                    <el-input v-model="valueSearch.search" placeholder="Nhập nội dung tìm kiếm" clearable
                                        @keyup="searchData()"/>
                                </template>
                                <template class="w-[100%]" #content>
                                    <div class="px-[2px] w-[100%] py-[6px]">
                                        <div v-if="dataSearch.length == 0" class="text-center text-[14px] py-[12px]">
                                            Không có dữ liệu
                                        </div>
                                        <div v-else class="pb-[12px]">
                                            <template  v-for="post in dataSearch">
                                                <a :href="route('post', post.slug)">
                                                    <div class="text-[14px] px-[12px] py-[6px] hover:text-[#0d6efd] hover:bg-[#e9ecef]">
                                                        {{ post.title }}
                                                    </div>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                        <div class="col-4 flex items-center justify-end text-black pl-5">
                            <el-dropdown ref="dropdown1" trigger="contextmenu">
                                <span class="el-dropdown-link" @click="clickDropdown()">
                                    <template v-if="this.$page.props.auth.account">
                                        <div class="flex items-center text-[13px]">
                                            <div v-if="!this.$page.props.auth.account.image" class="bg-[#5c6bc0] w-[23px] h-[23px] border-[1px] rounded-[50%]
                                                    flex justify-center items-center">
                                                <span class="text-[#fff] text-[10px]">{{
                                                    this.$page.props.auth.account.first_name[0] }}</span>
                                            </div>
                                            <img v-else :src="this.$page.props.auth.account.image" alt=""
                                                class="w-[23px] h-[23px] rounded-[50%]">
                                            <span class="ml-[4px]">
                                                {{ this.$page.props.auth.account.first_name + ' ' +
                                                    this.$page.props.auth.account.last_name }}
                                            </span>
                                            <span class="mr-[12px] ml-[4px] text-[10px]">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <i class="bi bi-person px-1 cursor-pointer" style="font-size: 1.76rem;"></i>
                                    </template>
                                </span>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <template v-if="this.$page.props.auth.account">
                                            <el-dropdown-item @click="redirctPage('user.list-save')">
                                                <div class="w-[23px]"><i class="bi bi-bookmark-check-fill text-[16px]"></i>
                                                </div>
                                                <span class="ml-[3px]">Tin đã lưu</span>
                                            </el-dropdown-item>
                                            <el-dropdown-item @click="redirctPage('user.list-read')">
                                                <div class="w-[23px]"><i class="bi bi-clock-history text-[15px]"></i></div>
                                                <span class="ml-[3px]">Đọc gần đây</span>
                                            </el-dropdown-item>
                                            <el-dropdown-item @click="redirctPage('user.my-profile')">
                                                <div class="w-[23px]"><i class="bi bi-card-list text-[16px"></i></div>
                                                <span class="ml-[3px]">Thông tin cá nhân</span>
                                            </el-dropdown-item>
                                            <el-dropdown-item @click="openChangePassword">
                                                <div class="w-[23px]"><i class="bi bi-key text-[17px]"></i></div>
                                                <span class="ml-[3px]">Thay đổi mật khẩu</span>
                                            </el-dropdown-item>
                                            <el-dropdown-item @click="logout">
                                                <div class="w-[23px]"><i class="bi bi-box-arrow-in-right text-[17px]"></i>
                                                </div>
                                                <span class="ml-[3px]">Đăng xuất</span>
                                            </el-dropdown-item>
                                        </template>
                                        <template v-else>
                                            <el-dropdown-item @click="openLogin">
                                                <div class="w-[22px]"><i class="bi bi-person-check-fill text-[19px]"></i>
                                                </div>
                                                <span class="ml-[3px]">Đăng nhập</span>
                                            </el-dropdown-item>
                                            <el-dropdown-item @click="openRegister">
                                                <div class="w-[22px]"><i class="bi bi-person-circle text-[17px]"></i></div>
                                                <span class="ml-[5px] min-w-[100px]">Đăng ký</span>
                                            </el-dropdown-item>
                                        </template>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                            <i class="bi bi-phone cursor-pointer mt-[2px]" style="font-size: 1.4rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="flex items-center bg-[#17a2b8] text-white">
                <div class="main flex items-center py-[2px]">
                    <div class="main flex items-center">
                        <Link :href="route('home')">
                        <div class="main-item hover:bg-[#22b1c7]" :class="{ 'active-tab': 'home' == currentTab }"> Trang
                            chủ</div>
                        </Link>
                        <template v-for="(item, index) in this.$page.props.categories">
                            <Link :href="route('list-category', item.slug)" v-if="index <= 3">
                            <div class="main-item hover:bg-[#22b1c7] text-[14px]"
                                :class="{ 'active-tab': item.slug == currentTab }">
                                {{ item.name }}
                            </div>
                            </Link>
                        </template>
                        <Link>
                        <div class="text-[12px] px-[12px] py-[2px] border-[2px] rounded-[16px] ml-[10px]">
                            # Năng lượng tích cực
                        </div>
                        </Link>
                        <Link>
                        <div class="text-[12px] px-[12px] py-[2px] border-[2px] rounded-[16px] ml-[10px]">
                            # Khám phá thế giới
                        </div>
                        </Link>
                    </div>
                    <div class="py-[1px] px-[12px] mr-[8px] text-[#fff] text-[24px] cursor-pointer hover:bg-[#22b1c7]"
                        :class="{ 'bg-[#22b1c7]': hiddenMenu == true }" @click="hiddenMenu = !hiddenMenu">
                        <i class="bi bi-list"></i>
                    </div>
                </div>
            </div>
            <div class="header-extend bg-[#e9ecef] border-b-[2px]" v-if="hiddenMenu">
                <div class="w-[970px] mx-auto pb-[18px] pt-[12px]">
                    <div class="text-[15px] font-bold mb-[4px] text-[#2b94a5]">Danh mục chủ đề:</div>
                    <div v-for="(item, index) in this.$page.props.categories" :key="index"
                        class="w-[180px] inline-block my-[8px] px-[18px]">
                        <Link :href="route('list-category', item.slug)">
                        <span class="border-l-[5px] border-l-[#076db6] pl-[12px] text-[15px] 
                                 font-bold hover:text-[#17a2b8] hover:border-l-[#17a2b8] relative"
                            :class="{ 'border-l-[#db562b] text-[#db562b] ': currentTab == item.slug }">
                            {{ item.name }}
                            <div class="absolute left-[102%] top-[-10px] bg-[#db562b] text-[#fff] h-[18px] min-w-[18px]
                                     leading-[19px] pl-[3px] pr-[4px] rounded-[50%] text-center text-[10px]"
                                v-if="item.quality > 0"> {{ item.quality }}</div>
                        </span>
                        </Link>
                    </div>
                    <div class="text-[15px] font-bold mb-[4px] mt-[12px] text-[#2b94a5]">Danh mục hagtag:</div>
                    <div v-for="(item, index) in listHagTag" :key="index" class="w-[230px] inline-block my-[8px] px-[18px]">
                        <Link :href="route(item.route, item.category)">
                        <span class="border-l-[5px] border-l-[#076db6] pl-[12px] text-[15px] 
                                 font-bold hover:text-[#17a2b8] hover:border-l-[#17a2b8] relative"
                            :class="{ 'border-l-[#db562b] text-[#db562b] ': currentTab == item.category }">
                            {{ item.name }}
                            <div class="absolute left-[102%] top-[-10px] bg-[#db562b] text-[#fff] h-[18px] min-w-[18px]
                                     leading-[19px] pl-[3px] pr-[4px] rounded-[50%] text-center text-[10px]"
                                v-if="item.quality > 0"> {{ item.quality }}</div>
                        </span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container-fuild">
            <div v-if="currentTab == 'main-full'" class="main flex justify-center">
                <slot name="main-full" />
            </div>
            <div v-else class="main flex justify-center">
                <div class="main-1 flex-1">
                    <slot name="main-1" />
                </div>
                <div v-if="currentTab == 'main-creater'" class="main-2 w-[310px]">
                    <slot name="main-2" />
                </div>
                <div v-else class="main-2 w-[310px]">
                    <div class="bg-[#fff] py-[12px] mb-[24px] rounded-[4px]"
                        style="box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);">
                        <div class="border-b-[2px] mt-[4px] mb-[8px]">
                            <div
                                class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                                Tin mới nhất
                            </div>
                        </div>
                        <div v-for="item in listNewPost" class="new-item flex border-b-[2px] mx-[8px] py-[8px] hover:bg-[#e9ecef]">
                            <Link :href="route('post', item.slug)">
                            <img :src="item.image" alt="" class="w-[60px] min-w-[60px] h-[60px] rounded-[3px] object-cover">
                            </Link>
                            <div class="ml-[8px]">
                                <Link :href="route('post', item.slug)">
                                <div class="text-[15px]">
                                    {{ item.title }}
                                </div>
                                </Link>
                                <div class="flex items-center mt-[6px]">
                                    <Link :href="route('list-category', item.categorySlug)">
                                    <div class="text-[#076db6] font-bold text-[13px]"> {{ item.categoryName }}</div>
                                    </Link>
                                    <div class="text-[12px] ml-[13px]">{{ this.convertTime(item.created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-[52px] mb-[22px] bg-[#fff]" style="box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);">
                        <div class="partner-headline transform-uppercase">Đối tác chính thức</div>
                        <div class="main">
                            <div class="flex">
                                <div class="partner-item">Chào mừng 1</div>
                                <div class="partner-item">Chào mừng 2</div>
                                <div class="partner-item">Chào mừng 3</div>
                                <div class="partner-item">Chào mừng 4</div>
                                <div class="partner-item">Chào mừng 5</div>
                                <div class="partner-item">Chào mừng 6</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#fff] py-[12px] mt-[52px] rounded-[4px]"
                        style="box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);">
                        <div class="border-b-[2px] mt-[4px] mb-[8px]">
                            <div
                                class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                                Bài viết bạn có thể quan tâm
                            </div>
                        </div>
                        <div class="new-item flex border-b-[2px] mx-[8px] py-[8px]">
                            <Link :href="route('post', 'chao-mung-ban-nhe')">
                            <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt=""
                                class="w-[60px] min-w-[60px] h-[60px] rounded-[3px]">
                            </Link>
                            <div class="ml-[8px]">
                                <Link :href="route('post', 'chao-mung-ban-nhe')">
                                <div class="text-[15px]">
                                    Tổng Bí thư Nguyễn Phú Trọng nhấn mạnh 3 vấn đề cốt yếu của Công an nhân dân
                                </div>
                                </Link>
                                <div class="flex items-center mt-[6px]">
                                    <Link :href="route('list-category', 'chinh-tri')">
                                    <div class="text-[#076db6] font-bold text-[13px]">Kinh tế chính trị</div>
                                    </Link>
                                    <div class="text-[12px] ml-[13px]">15 phút trước</div>
                                </div>
                            </div>
                        </div>
                        <div class="new-item flex border-b-[2px] mx-[8px] py-[8px]">
                            <Link :href="route('post', 'chao-mung-ban-nhe')">
                            <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt=""
                                class="w-[60px] min-w-[60px] h-[60px] rounded-[3px]">
                            </Link>
                            <div class="ml-[8px]">
                                <Link :href="route('post', 'chao-mung-ban-nhe')">
                                <div class="text-[15px]">
                                    Tổng Bí thư Nguyễn Phú Trọng nhấn mạnh 3 vấn đề cốt yếu của Công an nhân dân
                                </div>
                                </Link>
                                <div class="flex items-center mt-[6px]">
                                    <Link :href="route('list-category', 'chinh-tri')">
                                    <div class="text-[#076db6] font-bold text-[13px]">Kinh tế chính trị</div>
                                    </Link>
                                    <div class="text-[12px] ml-[13px]">15 phút trước</div>
                                </div>
                            </div>
                        </div>
                        <div class="new-item flex mx-[8px] py-[8px]">
                            <Link :href="route('post', 'chao-mung-ban-nhe')">
                            <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt=""
                                class="w-[60px] min-w-[60px] h-[60px] rounded-[3px]">
                            </Link>
                            <div class="ml-[8px]">
                                <Link :href="route('post', 'chao-mung-ban-nhe')">
                                <div class="text-[15px]">
                                    Tổng Bí thư Nguyễn Phú Trọng nhấn mạnh 3 vấn đề cốt yếu của Công an nhân dân
                                </div>
                                </Link>
                                <div class="flex items-center mt-[6px]">
                                    <Link :href="route('list-category', 'chinh-tri')">
                                    <div class="text-[#076db6] font-bold text-[13px]">Kinh tế chính trị</div>
                                    </Link>
                                    <div class="text-[12px] ml-[13px]">15 phút trước</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="border-t-2 border-zinc-300 bg-[#17a2b8] py-2">
            <div class="main flex justify-between">
                <img src="" alt="Logo bao moi">
                <div class="search">
                    <el-input v-model="input" placeholder="Nhập nội dung tìm kiếm" clearable />
                </div>
            </div>
        </div>
        <div class="border-t-2 border-zinc-300 py-3">
            <div class="main flex justify-between">
                <div class="infor">
                    <div><b>Báo dành cho người Việt</b></div>
                    <div>Đánh giá rất hay trên các nền tảng</div>
                </div>
                <div class="infor">
                    <div>Tổng biên tập: Nguyễn Viết Thanh</div>
                    <div>Địa chỉ: Thôn Đồng Trữ, Xã Phú Nghĩa, Huyện Chương Mỹ, TP. Hà Nội </div>
                    <div>Số điện thoại: 0358387102 </div>
                </div>
                <div class="infor">
                    © 1997-2023. Toàn bộ bản quyền thuộc
                    <Link :href="route('home')">Nguyễn Viết Thanh</Link>
                </div>
            </div>

        </div>
    </footer>

    <LoginForm ref="loginForm" @login="login"></LoginForm>
    <RegisterForm ref="registerForm" @register="register"></RegisterForm>
    <ChangePasswordForm ref="changePasswordForm" @change-password="changePassword"></ChangePasswordForm>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import Dropdown from "@/Components/Dropdown.vue";
import LoginForm from '../Components/Auth/Login.vue';
import RegisterForm from '../Components/Auth/Register.vue';
import ChangePasswordForm from '../Components/Auth/ChangePassword.vue';
import moment from "moment";

export default {
    components: {
        Link,
        Dropdown,
        LoginForm,
        RegisterForm,
        ChangePasswordForm,
    },
    props: {
        title: String,
        currentTab: { type: String, required: true },
        backgroundColor: {
            type: String,
            default: "bg-[#fff]",
        },
    },
    data() {
        return {
            input: "",
            hiddenMenu: false,
            isSearchData: false,
            valueSearch: {
                search: ''
            },
            dataSearch: [],
            options: [],
            listHagTag: [],
            listNewPost: []
        }
    },
    mounted() {
        // window.onscroll = function() {
        //     if(this.scrollY <= 56) {
        //         document.querySelector('.header-search').classList.remove('hidden')
        //     }
        //     else{
        //         document.querySelector('.header-search').classList.add('hidden')
        //     }
        // }
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async searchData() {
            const pagram = { ...this.valueSearch }
            await axios.get(route('search-header', pagram))
                .then(response => {
                    this.dataSearch = response.data.data
                })
                .catch(() => { })
        },
        async fetchData() {
            if (this.currentTab != 'main-full' && this.currentTab != 'main-creater') {
                const responseNewPost = await axios.get(route('post.get-new-all'))
                this.listNewPost = responseNewPost.data.data
            }
        },
        convertTime(created_at) {
            const now = moment()
            const time = moment(created_at)

            if (now.diff(time, 'years') > 0) {
                return `${now.diff(time, 'years')} năm trước`
            }
            else if (now.diff(time, 'months') > 0) {
                return `${now.diff(time, 'months')} tháng trước`
            }
            else if (now.diff(time, 'days') > 0) {
                return `${now.diff(time, 'days')} ngày trước`
            }
            else if (now.diff(time, 'hours') > 0) {
                return `${now.diff(time, 'hours')} giờ trước`
            }
            else if (now.diff(time, 'minutes') > 0) {
                return `${now.diff(time, 'minutes')} phút trước`
            }
            else if (now.diff(time, 'seconds') > 0) {
                return `${now.diff(time, 'seconds')} giây trước`
            }
        },
        clickDropdown() {
            this.$refs.dropdown1.handleOpen()
        },
        openLogin() {
            this.$refs.loginForm.open()
        },
        login() {
            location.reload()
        },
        openRegister() {
            this.$refs.registerForm.open()
        },
        register() {
            location.reload()
        },
        openChangePassword() {
            this.$refs.changePasswordForm.open()
        },
        changePassword() {

        },
        querySearch() {

        },
        showClick() {
            this.$refs.dropdown1.handleOpen()
        },
        searchNews() {
            alert(this.input)
        },
        redirctPage(url, tab) {
            this.$inertia.visit(route(url))
        },
        async logout() {
            ElMessageBox.confirm(
                'Bạn có muốn đăng xuất tài khoản khỏi hệ thống không?',
                'Đăng xuất',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                }
            )
                .then(() => {
                    axios.get(route('guest.logout'))
                        .then(response => {
                            ElMessage({
                                type: 'success',
                                message: 'Đăng xuất tài khoản thành công',
                            })
                            location.reload()
                        })
                        .catch(errors => {
                            ElMessage({
                                type: 'error',
                                message: errors.data,
                            })
                        })
                })
                .catch(() => { })
        }
    }
}
</script>

<style>
.el-dropdown {
    border-color: white !important;
}

header {
    z-index: 100;
}

header .absolute {
    width: 100%;
}

header .main {
    width: 970px;
    margin: 0 auto;
}

header .header-extend {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    border-radius: 5px;
    -moz-user-select: none !important;
    -webkit-touch-callout: none !important;
    -webkit-user-select: none !important;
    -khtml-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}

header .main-item {
    padding: 9px 12px;
    border-left: 1px solid #ffffffc3;
    font-size: 0.82rem;
    text-transform: uppercase;
    cursor: pointer;
}

header .main-item a {
    height: 100%;
    width: 100%;
}

header .main-hagtag {
    padding: 1px 8px;
    border-radius: 20px;
    margin-left: 12px;
    border: 1px solid white;
    font-size: 0.82rem;
}

header .header-search .search {
    padding: 0 !important;
}

.active-tab {
    background-color: #2b94a5;
}

.sticky {
    position: fixed;
    top: 0;
    width: 100%
}

.sticky+.content {
    padding-top: 58px;
}

main .container-fuild {
    width: 1070px;
    margin: 0 auto;
    padding-top: 118px;
    padding-bottom: 30px;
}

main .container-fuild .main-1 {
    margin-right: 16px;
    flex: 2;
}

footer .main {
    width: 970px;
    margin: 0 auto;
}

footer .main .infor {
    font-size: 0.9rem;
}

footer .main .infor:nth-child(2) {
    padding: 0 24px;
}

footer .main .search {
    width: 450px;
}</style>