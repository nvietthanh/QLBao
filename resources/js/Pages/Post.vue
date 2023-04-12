<template>
    <AppLayout>
        <template v-slot:main-1>
            <div class="main mb-[24px] relative">
                <div class="py-[12px] px-[12px]">
                    <div class="text-[22px] font-bold">
                        {{ dataForm.title }}
                    </div>
                    <div class="flex items-center my-[12px]">
                        <Link :href="route('list-category', dataForm.categorySlug)">
                            <div class="text-[16px] text-[#076db6] font-bold"> {{ dataForm.categoryName }}</div>
                        </Link>
                        <Link :href="route('creator', dataForm.creatorCode)">
                            <div class="creator text-[16px] font-bold text-[#333]">
                                {{ dataForm.creator }}
                            </div>
                        </Link>
                        <div class="text-[14px]">{{ convertTime(dataForm.created_at) }}</div>
                    </div>
                    <div class="mt-[18px]">
                        <img :src="dataForm.image" alt="" class="w-[100%] min-h-[400px]">
                        <div class="text-[14px] text-center mt-[8px]">
                            {{ dataForm.description }}
                        </div>
                    </div>
                    <div v-html="dataForm.content" class="mt-[12px] text-[16px] mb-[18px]"></div>
                    <div class="mt-[42px]" v-if="dataForm.hagtagNames.length > 0">
                        <span class="text-[16px] font-bold">Hagtag: </span>
                        <template v-for="hagtag in dataForm.hagtagNames">
                            <span class="mr-[8px] text-[16px] text-[#17a2b8]">
                                <a :href="route('list-post-hagtag', hagtag.slug)">{{ hagtag.name }}</a>
                            </span>
                        </template>
                    </div>
                </div>
                <div class="py-[12px] pt-[18px]">
                    <div class="font-bold text-[17px]">Bình luận ({{totalcomment}})</div>
                    <div class="mt-[12px]">
                        <el-input
                            v-model="contentComment"
                            type="textarea"
                            :autosize="{ minRows: 3, maxRows: 4 }" 
                            placeholder="Nhập bình luận của bạn"
                        />
                        <div v-if="errors.content" class="mt-[5px] text-[#ff0000] text-[15px]">
                            {{ errors.content[0] }}
                        </div>
                        <div class="flex justify-end mt-[18px] mr-[18px]">
                            <div class="btn border-[1px] px-[16px] py-[8px] bg-[#2877af] text-white text-[14px] cursor-pointer 
                                rounded-[4px] active:scale-95"
                                @click="sendComment">
                                Gửi bình luận
                            </div>
                        </div>
                    </div>
                    <div class="mt-[12px] pb-[18px]">
                        <div class="flex border-b-[1px] px-[4px]">
                            <div class="mr-[24px] text-[15px] font-bold cursor-pointer"
                              @click="changeTabComment('tab-0')"
                             :class="{ 'active-comment' : filters.tabComment == 'tab-0'}">Quan tâm nhất</div>
                            <div class="text-[15px] font-bold cursor-pointer"
                              @click="changeTabComment('tab-1')"
                             :class="{ 'active-comment' : filters.tabComment == 'tab-1'}">Mới nhất</div>
                        </div>
                        <div class="mt-[18px] mx-[8px]">
                            <template v-if="comments.length > 0" v-for="comment in comments">
                                <div class="flex mb-[18px]">
                                    <Link :href="route('home')">
                                        <img v-if="comment.creator_image" :src="comment.creator_image" alt="" class="w-[36px] min-w-[36px] h-[36px] rounded-[50%]">
                                        <div v-else class="bg-[#5c6bc0] w-[36px] h-[36px] border-[1px] rounded-[50%]
                                                flex justify-center items-center">
                                            <span class="text-[#fff] text-[14px]">{{
                                                comment.creator[0] }}</span>
                                        </div>
                                    </Link>
                                    <div class="ml-[12px] mt-[-4px]">
                                        <span class="font-bold text-[16px]">
                                            <Link :href="route('home')">
                                                <span v-if="dataForm.creatorCode == comment.creator_code">Tác giả: </span>
                                                <span v-else>{{ comment.creator }}: </span>
                                            </Link>
                                        </span>
                                        <span class="text-[15px] whitespace-pre-line">{{ comment.content }}</span>
                                        <div class="mt-[8px] text-[14px] text-[#9F9F9F]">
                                            <span class="cursor-pointer">
                                                <i class="bi bi-heart-fill hover:text-[red]" 
                                                  :class="{ 'text-[red]' : comment.is_like_comment }" @click="changeStatusLike(comment)"></i>
                                                <span v-if="comment.count_like_comment > 0" class="ml-[4px]">{{ comment.count_like_comment }}</span>
                                            </span>
                                            <span class="mx-[14px] hover:text-[red] cursor-pointer">
                                                Trả lời
                                            </span>
                                            <span>{{ convertTime(comment.created_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="text-center my-[32px] text-[15px]">Không có bình luận, hãy là người bình luận đầu tiên</div>
                            </template>
                        </div>
                        <div v-if="nextComment" class="btn mt-[28px] mx-[8px] border-[1px] border-[#adb5bd] text-center py-[12px] 
                            cursor-pointer text-[17px] active:bg-[#eff1f3]" @click="loadComment">
                            Xem thêm bình luận
                        </div>
                    </div>
                </div>
                <div class="absolute top-[18%] right-[100%]">
                    <div class="mr-[12px]">
                        <div class="rounded-[50%] w-[36px] h-[36px] bg-[#fff] box-shadow flex justify-center items-center
                          text-[22px] text-[#6c757d] cursor-pointer hover:text-[#17a2b8] hover:scale-[1.1]" @click="backHome">
                            <i class="bi bi-house-door-fill"></i>
                        </div>
                        <div class="mt-[12px] rounded-[50%] w-[36px] h-[36px] bg-[#fff] box-shadow flex justify-center items-center
                         text-[19px] text-[#6c757d] cursor-pointer hover:text-[#17a2b8] hover:scale-[1.1]" 
                         :class=" {'text-[red]' : dataForm.is_save} " @click="savePost">
                            <i class="bi bi-bookmark-fill mt-[2px]"></i>
                        </div>
                        <div class="mt-[12px] rounded-[50%] w-[36px] h-[36px] bg-[#fff] box-shadow flex justify-center items-center
                          text-[19px] text-[#6c757d] cursor-pointer hover:text-[#17a2b8] hover:scale-[1.1]" @click="reportPost">
                            <i class="bi bi-flag-fill mt-[2px]"></i>
                        </div>
                        <div class="mt-[12px] rounded-[50%] w-[36px] h-[36px] bg-[#fff] box-shadow flex justify-center items-center
                          text-[19px] text-[#6c757d] cursor-pointer hover:text-[#17a2b8] hover:scale-[1.1]"
                           @click="backPage">
                            <i class="bi bi-arrow-left mt-[2px]"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="py-[12px] px-[12px]">
                    <div class="heading mt-4px uppercase font-bold text-[#db562b]">
                        Bài viết liên quan
                    </div>
                    <div class="flex mt-[18px]">
                        <div>
                            <Link :href="route('post', 'tam-biet-ban-nhe')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="">
                            </Link>
                            <div class="mr-[6px]">
                                <Link :href="route('post', 'tam-biet-ban-nhe')">
                                    <div class="font-bold text-[15px] mt-[8px]">
                                        Tổng Bí thư Nguyễn Phú Trọng nhấn mạnh 3 vấn đề cốt yếu
                                    </div>
                                    <div class="flex items-center mt-[6px]">
                                        <Link :href="route('list-category', 'kinh-te')">
                                            <div class="text-[14px] text-[#076db6] font-bold">Kinh tế</div>
                                        </Link>
                                        <div class="text-[12px] ml-[16px]">1 giờ trước</div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                        <div class="mx-[12px] pb-[12px]">
                            <Link :href="route('post', 'tam-biet-ban-nhe')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="">
                            </Link>
                            <div class="mr-[6px]">
                                <Link :href="route('post', 'tam-biet-ban-nhe')">
                                    <div class="font-bold text-[15px] mt-[8px]">
                                        Tổng Bí thư Nguyễn Phú Trọng nhấn mạnh 3 vấn đề cốt yếu
                                    </div>
                                    <div class="flex items-center mt-[6px]">
                                        <Link :href="route('list-category', 'kinh-te')">
                                            <div class="text-[14px] text-[#076db6] font-bold">Kinh tế</div>
                                        </Link>
                                        <div class="text-[12px] ml-[16px]">1 giờ trước</div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                        <div>
                            <Link :href="route('post', 'tam-biet-ban-nhe')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="">
                            </Link>
                            <div class="mr-[6px]">
                                <Link :href="route('post', 'tam-biet-ban-nhe')">
                                    <div class="font-bold text-[15px] mt-[8px]">
                                        Tổng Bí thư Nguyễn Phú Trọng nhấn mạnh 3 vấn đề cốt yếu
                                    </div>
                                    <div class="flex items-center mt-[6px]">
                                        <Link :href="route('list-category', 'kinh-te')">
                                            <div class="text-[14px] text-[#076db6] font-bold">Kinh tế</div>
                                        </Link>
                                        <div class="text-[12px] ml-[16px]">1 giờ trước</div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <LoginForm ref="loginForm" @login="login"></LoginForm>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import moment from "moment";
import { ElMessage } from 'element-plus'
import LoginForm from '../Components/Auth/Login.vue';

export default{
    components:{
        AppLayout,
        Link,
        LoginForm,  
    },
    data() {
        return {
            filters: {
                tabComment: 'tab-0',
                page: 0,
            },
            dataForm: {
                id: '',
                title: '',
                slug: '',
                title: '',
                description: '',
                image: '',
                categorySlug: '',
                categoryName: '',
                is_save: false,
                creator: '',
                creatorCode: '',
                created_at: '',
                updated_at: '',
                hagtags: [],
                hagtagNames: [],
            },
            contentComment: '',
            comments: [],
            pageComment: 2,
            totalcomment: 0,
            nextComment: false,
            errors: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async fetchData() {
            const response = await axios.get(route('post.get-post', this.$page.props.slug))
            this.dataForm = response.data.data
            this.fetchDataComment()

        },
        async fetchDataComment() {
            const responseComment = await axios.get(route('get-comments', {
                id: this.dataForm.id,
                page_number: this.pageComment
            }))
            this.comments = responseComment.data.data
            this.totalcomment = responseComment.data.meta.total
            if(responseComment.data.meta.last_page == responseComment.data.meta.current_page) {
                this.nextComment = false
            }
            else{
                this.nextComment = true
            }
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
        changeTabComment(tab) {
            this.filters.tabComment = tab
        },
        sendComment() {
            if(this.$page.props.auth.account) {
                const pagram = {
                    ...{
                        'content': this.contentComment
                    }
                }
                axios.post(route('create-comment', this.dataForm.id), pagram)
                    .then(response => {
                        ElMessage({
                            showClose: true,
                            message: 'Thêm bình luận thành công',
                            type: 'success',
                        })
                        this.contentComment = ''
                        this.fetchDataComment()
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors
                    })
                }
            else {
                this.$refs.loginForm.open()
            }
        },
        loadComment() {
            this.pageComment += 2
            this.fetchDataComment()
        },
        changeStatusLike(comment) {
            if(this.$page.props.auth.account) {
                if(comment.is_like_comment) {
                    axios.get(route('unlike-comment', comment.id))
                        .then(response => {
                            this.fetchDataComment()

                        })
                        .catch(errors => {})
                }
                else {
                    axios.get(route('like-comment', comment.id))
                        .then(response => {
                            this.fetchDataComment()

                        })
                        .catch(errors => {})
                }
            }
            else {
                this.$refs.loginForm.open()
            }
        },
        login() {
            location.reload()
        },
        backPage() {
            history.back()
        },
        backHome() {
            window.location = route('home')
        },
        savePost() {
            if(this.$page.props.auth.account) {
                if(this.dataForm.is_save) {
                    axios.get(route('unsave-post', this.dataForm.id))
                    this.dataForm.is_save = false
                }
                else{
                    axios.get(route('save-post', this.dataForm.id))
                    this.dataForm.is_save = true
                }
            }
            else {
                this.$refs.loginForm.open()
            }
        },
        reportPost() {
            if(this.$page.props.auth.account) {

            }
            else {
                this.$refs.loginForm.open()
            }
        }
    }
}

</script>
<style scoped>
main .main {
    background-color: #fff;
    padding: 12px;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}
.active-comment {
    color: #db562b;
    padding-bottom: 12px;
    border-bottom: 2px solid #db562b;
}
main .main .comment {
    border-top: 1px solid #bdc1c5;
}
main .main .heading {
    margin-top: 4px;
    text-transform: uppercase;
    color: #db562b;
    border-left: 4px solid #db562b;
    padding-left: 12px;
    font-size: 0.96rem;
}
main .main .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>
  