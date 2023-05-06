<template>
    <AppLayout>
        <template v-slot:main-1>
            <div class="main">
                <div class="px-[8px] mt-[18px] mb-[8px] relative pb-[18px] border-b-[2px] border-b-[#000]">
                    <div class="mb-[8px] text-[17px] font-bold">Từ khóa tìm kiếm</div>
                    <el-input
                        v-model="dataForm.search"
                        class="w-[150px]"
                        size="large"
                        placeholder="Nhập nội dung tìm kiếm"
                        @keyup.enter="fecthData"
                    />
                    <div class="w-[70px] bg-[red] absolute top-[33px] right-0 h-[42px] cursor-pointer flex items-center 
                      justify-center text-white text-[18px]" @click="fecthData">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
                <div class="mt-[12px] p-[8px]">
                    <div class="text-[16px] font-bold mb-[18px]">
                        Kết quả tìm kiếm ({{ countResult }}) :
                    </div>
                    <div class="row">
                        <div v-if="this.countResult == 0" class="text-center text-[16px] pt-[18px] pb-[32px]">
                            Không có kết quả tìm kiếm
                        </div>
                        <template v-else v-for="post in listSearchPosts">
                            <div class="post-item flex py-[18px] border-b-[2px]">
                                <Link :href="route('post', post.slug)">
                                    <img :src="post.image" :alt="post.description" class="post-image min-w-[220px] w-[220px] h-[150px] object-cover">
                                </Link>
                                <div class="ml-[12px]">
                                    <Link :href="route('post', post.slug)">
                                        <div class="post-title text-[16px] font-bold">{{ post.title }}</div>
                                    </Link>
                                    <div class="mt-[12px] flex items-end">
                                        <Link :href="route('list-category', post.categorySlug)">
                                            <div class="text-[15px] font-bold text-[#076db6]">
                                                {{ post.categoryName }}
                                            </div>
                                        </Link>
                                        <div class="text-[13px] mx-[16px]">{{ convertTime(post.created_at) }}</div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="px-[18px] pb-[32px]">
                            <div v-if="isLoadPost" class="btn mt-[28px] border-[1px] border-[#adb5bd] py-[8px] 
                                text-center cursor-pointer text-[15px] active:bg-[#eff1f3]" @click="loadPost">
                                Xem thêm bài viết
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import axios from 'axios';
import AppLayout from '../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import moment  from 'moment';
import { Search } from '@element-plus/icons-vue'

export default{
    components:{
        AppLayout,
        Link,
        Search
    },
    data() {
        return {
            currentTab: 'tab-0',
            dataForm: {
                search: '',
                limit: 15
            },
            countResult: 0,
            isLoadPost: true,
            listSearchPosts: []
        }  
    },
    created() {
        this.dataForm.search = this.$page.props.search
        this.fecthData()
        document.title = `Tìm kiếm - Báo mới`
    },
    methods: {
        moment,
        async fecthData() {
            const pagram = { ...this.dataForm }
            await axios.get(route('search-header', pagram))
                .then(response => {
                    this.listSearchPosts = response.data.data
                    this.countResult = response.data.meta.total

                    if(response.data.meta.current_page === response.data.meta.last_page) {
                        this.isLoadPost = false
                    }
                })
                .catch(errors => {})
        },
        loadPost() {
            this.dataForm.limit += 6
            this.fecthData()
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
    },

}

</script>
<style scoped>
main .main {
    background-color: #fff;
    padding: 12px;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}
</style>
  