<template>
    <header class="fixed top-0 left-0 right-0 z-1000">
        <div class="header-search">
            <div class="flex items-center h-[62px] bg-[#ffffff] text-white">
                <div class="mx-auto max-w-[970px] w-[970px]">
                    <div class="row">
                        <div class="col-2 flex items-center cursor-pointer text-black pr-5">
                            <Link :href="route('home')">
                                <img src="/image/logo/logo.png" alt="Logo bao moi" class="h-[60px]">
                            </Link>
                        </div>
                        <div class="col-6 mt-1 flex items-center search relative">
                            <Dropdown align="left" class="right-0 w-[100%] text-[#000]" :contentClasses="[backgroundColor]"
                                @click="cleareDataSearch">
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
                                                    <div class="header-title text-[14px] px-[12px] py-[6px] hover:text-[#0d6efd]
                                                         hover:bg-[#e9ecef]">
                                                        {{ post.title }}
                                                    </div>
                                                </a>
                                            </template>
                                            <a :href="route('search', valueSearch.search)">
                                                <div class="header-title text-[14px] px-[12px] py-[6px] hover:text-[#0d6efd] 
                                                  hover:bg-[#e9ecef] text-[#17a2b8]">
                                                    Xem thêm kết quả '{{ valueSearch.search }}'
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                        <div class="col-4 flex items-center justify-end text-black pl-5">
                            <el-dropdown v-if="this.$page.props.auth.account" :placement="top-end" ref="dropdown2" trigger="contextmenu" class="mr-[18px]">
                                <span class="el-dropdown-link" @click="clickNotification()">
                                    <span class="text-[20px] mt-[8px] relative">
                                        <i class="bi bi-bell"></i>
                                        <span v-if="countNotice != 0" class="absolute left-[60%] top-[-4px] text-[11px] text-[#000] text-white font-bold
                                         bg-[red] max-w-[16px] h-[16px] leading-[17px] text-center rounded-[50%]">
                                            {{ this.countNotice }}
                                        </span>
                                    </span>
                                </span>
                                <template #dropdown>
                                    <el-dropdown-menu class="max-w-[310px] w-[310px]">
                                        <div class="h-[42px] leading-[42px] mb-[2px] border-b-[1px] border-b-[#adb5bd] text-[15px] text-center">
                                            <i class="bi bi-bell mr-[6px] text-[17px]"></i>Thông báo
                                        </div>
                                        <div id="list-notice" class="max-h-[320px] overflow-y-scroll"
                                         :class="{ 'mb-[12px]' : listNotice.length > 0}">
                                            <template v-if="listNotice.length > 0" v-for="notice in listNotice">
                                                <Link v-if="notice.type == 0" :href="route('post', [notice.post_slug, notice.notice_id])">
                                                    <div class="mx-[1px] py-[12px] px-[12px] flex items-center cursor-pointer border-b-[2px] hover:bg-[#e9ecef]"
                                                        :class="{ 'bg-[#e9ecef]' : !notice.is_read}">
                                                        <template v-if="notice.type == 0">
                                                            <img v-if="notice.creator_image" :src="notice.creator_image" class="w-[40px] h-[40px] rounded-[50%] object-cover">
                                                            <div v-else class="min-w-[40px] w-[40px] h-[40px] leading-[40px] text-center text-white
                                                                rounded-[50%] bg-[#5c6bc0]">
                                                                {{ notice.creator_name[0] }}
                                                            </div>
                                                        </template>
                                                        <div class="ml-[8px]">
                                                            <span v-if="notice.type == 0" class="font-bold text-[13px]">
                                                                {{ notice.creator_name }}
                                                            </span>
                                                            <span v-else class="font-bold text-[13px]">
                                                                Quản trị hệ thống
                                                            </span>
                                                            <span class="text-[13px] ml-[3px]">{{ notice.content }}</span>
                                                        </div>
                                                        <div v-if="!notice.is_read" class="ml-[8px] w-[8px] min-w-[8px] h-[8px] rounded-[50%] bg-[green]"></div>
                                                        <div v-else class="ml-[16px]"></div>
                                                    </div>
                                                </Link>
                                                <Link v-else :href="route(notice.notice_type, notice.notice_id)">
                                                    <div class="mx-[1px] py-[12px] px-[12px] flex items-center cursor-pointer border-b-[2px] hover:bg-[#e9ecef]"
                                                        :class="{ 'bg-[#e9ecef]' : !notice.is_read}">
                                                        <div class="ml-[8px]">
                                                            <span class="font-bold text-[13px]">
                                                                Quản trị hệ thống
                                                            </span>
                                                            <span class="text-[13px]">{{ notice.content }}</span>
                                                        </div>
                                                        <div v-if="!notice.is_read" class="ml-[8px] w-[8px] min-w-[8px] h-[8px] rounded-[50%] bg-[green]"></div>
                                                        <div v-else class="ml-[16px]"></div>
                                                    </div>
                                                </Link>
                                            </template>
                                            <template v-else>
                                                <div class="text-[14px] py-[18px] text-center text-[#6c757d]">
                                                    Không có thông báo nào
                                                </div>
                                            </template>
                                        </div>
                                        <div v-if="this.nextNotice" class="text-center py-[8px] text-[14px] cursor-pointer hover:text-[#17a2b8] hover:bg-[#e9ecef]"
                                            @click="nextMoreNotice">
                                            Đọc thêm
                                        </div>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="flex items-center bg-[#17a2b8] text-white">
                <div class="max-w-[970px] w-[970px] mx-auto flex justify-between items-center py-[2px]">
                    <div class="flex items-center">
                        <Link :href="route('home')">
                            <div class="main-item hover:bg-[#22b1c7]" :class="{ 'active-tab': 'home' == currentTab }">
                                Trang chủ
                            </div>
                        </Link>
                        <template v-for="(item, index) in this.$page.props.categories">
                            <Link :href="route('list-category', item.slug)" v-if="index <= 3">
                            <div class="main-item hover:bg-[#22b1c7] text-[14px]"
                                :class="{ 'active-tab': item.slug == currentTab }">
                                {{ item.name }}
                            </div>
                            </Link>
                        </template>
                        <template v-for="(hagtag, index) in listHagTag">
                            <Link v-if="index < 2" :href="route('list-post-hagtag', hagtag.slug)">
                                <div class="text-[12px] px-[12px] py-[2px] border-[2px] rounded-[16px] ml-[10px]">
                                    {{ hagtag.name }}
                                </div>
                            </Link>
                        </template>
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
                    <div v-for="item in listHagTag" class="w-[230px] inline-block my-[8px] px-[18px]">
                        <Link :href="route('list-post-hagtag', item.slug)">
                            <span class="border-l-[5px] border-l-[#076db6] pl-[12px] text-[15px] 
                                    font-bold hover:text-[#17a2b8] hover:border-l-[#17a2b8] relative"
                                :class="{ 'border-l-[#db562b] text-[#db562b] ': currentTab == item.slug }">
                                {{ item.name }}
                                <!-- <div class="absolute left-[102%] top-[-10px] bg-[#db562b] text-[#fff] h-[18px] min-w-[18px]
                                        leading-[19px] pl-[3px] pr-[4px] rounded-[50%] text-center text-[10px]"
                                    v-if="item.quality > 0"> {{ item.quality }}</div> -->
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
                    <div class="bg-[#fff] py-[12px] mb-[24px] rounded-[4px] box-shadow">
                        <div class="border-b-[2px] mt-[4px] mb-[8px]">
                            <div
                                class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                                Tin mới nhất
                            </div>
                        </div>
                        <div v-for="post in listNewPost" class="post-item flex border-b-[2px] mx-[8px] py-[8px] hover:bg-[#e9ecef]">
                            <Link :href="route('post', post.slug)">
                                <img :src="post.image" alt="" class="post-image w-[60px] min-w-[60px] h-[60px] rounded-[3px] object-cover">
                            </Link>
                            <div class="ml-[8px]">
                                <Link :href="route('post', post.slug)">
                                    <div class="post-new-title text-[15px] mr-[8px]"> {{ post.title }} </div>
                                </Link>
                                <div class="flex items-center mt-[6px]">
                                    <Link :href="route('list-category', post.categorySlug)">
                                        <div class="text-[#076db6] font-bold text-[13px]"> {{ post.categoryName }}</div>
                                    </Link>
                                    <div class="text-[12px] ml-[13px]">{{ this.convertTime(post.created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-[52px] mb-[22px] bg-[#fff] pt-[12px] pb-[8px] box-shadow">
                        <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold 
                         ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                            Đối tác hợp tác
                        </div>
                        <div class="mt-[12px]">
                            <el-carousel height="150px" :interval="10000">
                                <el-carousel-item v-for="partner in listPartners">
                                    <img :src="partner" alt="" class="object-contain">
                                </el-carousel-item>
                            </el-carousel>
                        </div>
                    </div>
                    <div class="bg-[#fff] py-[12px] mt-[52px] rounded-[4px] box-shadow">
                        <div class="border-b-[2px] mt-[4px] mb-[8px]">
                            <div
                                class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                                Bài viết bạn có thể quan tâm
                            </div>
                        </div>
                        <template v-for="post in listPostInterested">
                            <div class="post-item flex border-b-[2px] mx-[8px] py-[8px] hover:bg-[#e9ecef]">
                                <Link :href="route('post', post.slug)">
                                    <img :src="post.image" alt="" class="post-image w-[60px] min-w-[60px] h-[60px] rounded-[3px] object-cover">
                                </Link>
                                <div class="ml-[8px]">
                                    <Link :href="route('post', post.slug)">
                                        <div class="post-new-title text-[15px] mr-[8px]"> {{ post.title }} </div>
                                    </Link>
                                    <div class="flex items-center mt-[6px]">
                                        <Link :href="route('list-category', post.categorySlug)">
                                            <div class="text-[#076db6] font-bold text-[13px]"> {{ post.categoryName }}</div>
                                        </Link>
                                        <div class="text-[12px] ml-[13px]">{{ this.convertTime(post.created_at) }}</div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="border-t-2 border-zinc-300 bg-[#17a2b8] py-2">
            <div class="max-w-[970px] mx-auto flex justify-between">
                
                <div class="w-[450px]">
                    <el-input v-model="searchFooter" placeholder="Nhập nội dung tìm kiếm" clearable @keyup.enter="openPageSearch"/>
                </div>
            </div>
        </div>
        <div class="border-t-2 border-zinc-300 py-3 mb-[58px]">
            <div class="max-w-[970px] mx-auto flex justify-between text-[15px]">
                <div class="flex-1">
                    <div><b>Báo dành cho người Việt</b></div>
                    <div>Đánh giá rất hay trên các nền tảng</div>
                </div>
                <div class="flex-auto max-w-[440px] px-[24px]">
                    <div>Tổng biên tập: Nguyễn Viết Thanh</div>
                    <div>Địa chỉ: Thôn Đồng Trữ, Xã Phú Nghĩa, Huyện Chương Mỹ, TP. Hà Nội </div>
                    <div>Số điện thoại: 0358387102 </div>
                </div>
                <div class="flex-1 text-right">
                    <div>
                        © 1997-2023. Toàn bộ bản quyền thuộc quyền sở hữu của lập trình viên
                        <Link :href="route('home')" class="font-bold hover:underline">Nguyễn Viết Thanh</Link>
                    </div>
                    <div class="my-[5px] mt-[12px] hover:underline">
                        <Link :href="route('about-us')">Liên hệ</Link>
                    </div>
                    <div class="my-[5px] hover:underline">
                        <Link :href="route('term-of-use')">Điều khoản sử dụng</Link>
                    </div>
                    <div class="my-[5px] hover:underline">
                        <Link :href="route('private-policy')">Chính sách bảo mật</Link>
                    </div>
                    <div class="my-[5px] hover:underline">
                        <Link>Tiêu chuẩn vi phạm cộng đồng</Link>
                    </div>
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
import axios from 'axios';

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
            listNewPost: [],
            listPostInterested: [],
            listPartners: [
                '/image/partner/partner-1.png',
                '/image/partner/partner-2.png',
                '/image/partner/partner-3.png',
                '/image/partner/partner-4.png',
            ],
            searchFooter: '',
            listNotice: [],
            countNotice: 0,
            filterNotice: {
                limit: 5
            },
            nextNotice: true,
        }
    },
    mounted() {
        const thisChild = this.$refs.dropdown1
        const thisChild2 = this.$refs.dropdown2
        window.onscroll = function() {
            thisChild.handleClose()
            if(thisChild2) {
                thisChild2.handleClose()
            }
            if(this.scrollY <= 56) {
                document.querySelector('.header-search').classList.remove('hidden')
            }
            else{
                document.querySelector('.header-search').classList.add('hidden')
            }
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async searchData() {
            if(this.valueSearch.search) {
                const pagram = { ...this.valueSearch }
                await axios.get(route('search-header', pagram))
                    .then(response => {
                        this.dataSearch = response.data.data
                    })
                    .catch(() => { })
            }
            else {
                this.dataSearch = []
                this.valueSearch.search = ''
            }
        },
        cleareDataSearch() {
            if(!this.valueSearch.search) {
                this.dataSearch = []
            }
        },
        async fetchData() {
            this.listHagTag = this.$page.props.hagtags
            if (this.currentTab != 'main-full' && this.currentTab != 'main-creater') {
                const responseNewPost = await axios.get(route('post.get-new-all'))
                this.listNewPost = responseNewPost.data.data

                const responsePostInterested = await axios.get(route('post.get-post-interested'))
                this.listPostInterested = responsePostInterested.data.data
            }

            if (this.$page.props.auth.account) {
                this.loadNotice()
            }
        },
        async loadNotice() {
            const pagram = {
                ...this.filterNotice
            }
            const responseNotice = await axios.get(route('get-notices', pagram))
            this.listNotice = responseNotice.data.data

            const responseCountNotice = await axios.get(route('get-count-notices'))
            this.countNotice = responseCountNotice.data

            if(responseNotice.data.meta.last_page == responseNotice.data.meta.current_page) {
                this.nextNotice = false
            }
            else{
                this.nextNotice = true
            }
        },
        nextMoreNotice() {
            this.filterNotice.limit += 4
            this.loadNotice()
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
        clickNotification() {
            this.$refs.dropdown2.handleOpen()
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
        showClick() {
            this.$refs.dropdown1.handleOpen()
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
            .catch(() => {})
        },
        openPageSearch() {
            this.$inertia.visit(route('search', this.searchFooter))
        }
    }
}
</script>

<style>
#list-notice::-webkit-scrollbar {
    width: 8px !important;
}
#list-notice::-webkit-scrollbar-track {
    background: #fff !important;
}
#list-notice::-webkit-scrollbar-thumb {
    background: #ced4da !important;
    border-radius: 10px !important;
}
.header-title {
  max-height: 52px;
  line-height: 22px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
}
.el-dropdown {
    border-color: white !important;
}
header {
    z-index: 100;
}
header .absolute {
    width: 100%;
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
.post-new-title {
    max-height: 48px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>