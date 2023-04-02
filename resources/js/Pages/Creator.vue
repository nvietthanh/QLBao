<template>
    <AppLayout :current-tab="'main-creater'">
        <template v-slot:main-1>
            <div class="p-[20px] bg-[#fff] box-shadow">
                <div>
                    <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold pl-[8px] mb-[12px] text-[17px]">
                        Thông tin tác giả
                    </div>
                    <div class="flex mt-[16px] mx-[12px] justify-between items-center">
                        <div class="flex mr-[16px]">
                            <div class="min-w-[96px]">
                                <img v-if="dataInfor.image" :src="dataInfor.image" alt="" class="w-[96px] h-[96px] rounded-[50%]">
                                <div v-else class="w-[96px] h-[96px] flex items-center justify-center
                                  bg-[#5c6bc0] rounded-[50%] text-white text-[24px] object-contain">
                                    {{ dataInfor.first_name[0] }}
                                </div>
                            </div>
                            <div class="ml-[10px] flex-auto">
                                <div class="font-bold text-[20px] mt-[4px]">{{ dataInfor.first_name + ' ' + dataInfor.last_name }}</div>
                                <div class="text-[15px] mt-[4px] text-[#333]">{{ dataInfor.description }}</div>
                            </div>
                        </div>
                        <div v-if="dataInfor.code != this.$page.props.auth.account.code" class="btn text-[15px] text-center py-[6px] border-[2px] rounded-[4px] 
                          cursor-pointer hover:bg-[#e9ecef] active:scale-95 min-w-[120px]" @click="changeFollowing">
                            <template v-if="!dataInfor.is_follow">
                                <i class="bi bi-plus text-[16px] mr-[4px]"></i>Theo dõi
                            </template>
                            <template v-if="dataInfor.is_follow">
                                <i class="bi bi-check-circle text-[16px] mr-[8px]"></i>Đã theo dõi
                            </template>
                        </div>
                    </div>
                    <div class="mt-[18px] text-[17px] mx-[16px] border-b-[2px] pb-[18px] whitespace-pre-line">
                        {{ dataInfor.remark }}
                    </div>
                </div>
                <div class="mt-[16px] mb-[42px]">
                    <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold pl-[8px] mb-[12px] text-[17px]">
                       Các bài viết liên quan
                    </div>
                    <div class="mt-[10px] mb-[16px] grid grid-cols-3 gap-3">
                        <div v-for="item in listPostCreator" class="mt-[8px] post-item">
                            <Link :href="route('post', item.slug)">
                                <img :src="item.image" :alt="item.description" class="h-[200px] object-cover w-[100%] post-image">
                            </Link>
                            <div class="px-[2px]">
                                <Link :href="route('post', item.slug)">
                                    <div class="font-bold text-[15px] mt-[8px]">{{ item.title }}</div>
                                </Link>
                                <div class="flex items-center mt-[4px]">
                                    <Link :href="route('list-category', item.categorySlug)">
                                        <div class="text-[14px] font-bold text-[#076db6]">{{ item.categoryName }}</div>
                                    </Link>
                                    <div class="ml-[16px] text-[13px] mt-[4px]">{{ convertTime(item.created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="isLoadPost" class="btn mt-[28px] mx-[8px] border-[1px] border-[#adb5bd] py-[8px] 
                        flex justify-center cursor-pointer text-[15px] active:bg-[#eff1f3]" @click="loadPost">
                        Xem thêm bài viết
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:main-2>
            <div class="py-[12px] bg-[#fff] box-shadow">
                <div class="border-b-[2px] mb-[8px]">
                    <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[15px]">
                       Tác giả được đọc nhiều nhất
                    </div>
                </div>
                <div v-for="item in listCreatorPopular" class="mx-[2px]">
                    <Link :href="route('creator', item.code)">
                        <div class="flex px-[8px] items-center py-[8px] border-b-[2px] hover:bg-[#e9ecef]">
                            <img v-if="item.image" :src="item.image" alt="" class="min-w-[58px] h-[58px] rounded-[50%]">
                            <div v-else class="min-w-[58px] h-[58px] rounded-[50%] flex justify-center items-center
                             bg-[#5c6bc0] text-white text-[16px]">
                                {{ item.first_name[0] }}
                            </div>
                            <div class="ml-[10px] mt-[2px]">
                                <div class="text-[15px] font-bold">{{ item.first_name + ' ' + item.last_name }}</div>
                                <div class="description mr-[4px] text-[13px] mt-[1px]">{{ item.description }}</div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </template>
    </AppLayout>

    <LoginForm ref="loginForm" @login="login"></LoginForm>
</template>
<script>
import AppLayout from '../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import LoginForm from '../Components/Auth/Login.vue';
import moment from "moment";
import { ElMessage } from 'element-plus'

export default{
    components:{
        AppLayout,
        Link,
        LoginForm
    },
    data() {
        return {
            currentTab: 'kinh-te',
            isLoadPost: true,
            dataInfor: {
                'code': '',
                'first_name': '',
                'last_name': '',
                'image': '',
                'description': '',
                'remark': '',
                'is_follow' : false,
            },
            listPostCreator: [],
            listCreatorPopular: [],
            number_data: 12,
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async fetchDataInfor() {
            const responseInfor = await axios.get(route('cretor.get-infor', this.$page.props.id))
            this.dataInfor = responseInfor.data.data
        },
        async fetchData() {
            this.fetchDataInfor()

            const responseListPostCreator = await axios.get(route('post.get-list-post-creator', 
               {'id': this.$page.props.id, number_data: this.number_data}))
            this.listPostCreator = responseListPostCreator.data.data

            if(responseListPostCreator.data.meta.current_page === responseListPostCreator.data.meta.last_page) {
                this.isLoadPost = false
            }
            const responseListCreatorPopular = await axios.get(route('cretor.get-list-popular', this.dataInfor.code))
            this.listCreatorPopular = responseListCreatorPopular.data.data
        },
        loadPost() {
            this.number_data += 6
            this.fetchData()
        },
        changeFollowing() {
            if(this.$page.props.auth.account) {
                if(!this.dataInfor.is_follow) {
                    axios.get(route('follow-account', this.dataInfor.code))
                        .then(response => {
                            ElMessage({
                                type: 'success',
                                message: 'Theo dõi tác giả thành công',
                            })
                            this.dataInfor.is_follow = true
                        })
                        .catch(() => {
                        })
                }
                else {
                    axios.get(route('unfollow-account', this.dataInfor.code))
                        .then(response => {
                            ElMessage({
                                type: 'success',
                                message: 'Hủy theo dõi tác giả thành công',
                            })
                            this.dataInfor.is_follow = false
                        })
                        .catch(() => {})
                }
            }
            else{
                this.$refs.loginForm.open()
            }
        },
        login() {
            location.reload()
        },
        convertTime(created_at) {
            const now = moment()
            const time = moment(created_at)

            if( now.diff(time, 'years') > 0 ) {
                return `${now.diff(time, 'years')} năm trước`
            }
            else if(now.diff(time, 'months') > 0) {
                return `${now.diff(time, 'months')} tháng trước`
            }
            else if(now.diff(time, 'days') > 0) {
                return `${now.diff(time, 'days')} ngày trước`
            }
            else if(now.diff(time, 'hours') > 0) {
                return `${now.diff(time, 'hours')} giờ trước`
            }
            else if(now.diff(time, 'minutes') > 0) {
                return `${now.diff(time, 'minutes')} phút trước`
            }
            else if(now.diff(time, 'seconds') > 0) {
                return `${now.diff(time, 'seconds')} giây trước`
            }
        },
    }
}

</script>
<style scoped>
main .box-shadow {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
.description {
  height: 40px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>
  