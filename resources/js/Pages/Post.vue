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
                        <!-- <img :src="dataForm.image" alt="" class="w-[100%] min-h-[400px]"> -->
                        <el-image
                            style="width: 100%; height: 100%;"
                            :src="dataForm.image"
                            :zoom-rate="1.2"
                            preview-teleported="true"
                            hide-on-click-modal="true"
                            :preview-src-list="[dataForm.image]"
                            :initial-index="1"
                            fit="cover"
                        />
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
                             :class="{ 'active-comment' : filters.tabComment == 'tab-0'}">Mới nhất</div>
                            <div class="text-[15px] font-bold cursor-pointer"
                              @click="changeTabComment('tab-1')"
                             :class="{ 'active-comment' : filters.tabComment == 'tab-1'}">Quan tâm nhất</div>
                        </div>
                        <div class="mt-[18px] mb-[52px] mx-[8px]">
                            <template v-if="comments.length > 0" v-for="comment in comments">
                                <div class="relative flex mb-[20px]" 
                                 :class="{ 'comment-active mb-[200px]' : idOpenFormComment == comment.id }">
                                    <Link :href="route('creator', comment.commentator_code)">
                                        <img v-if="comment.commentator_image" :src="comment.commentator_image" alt="" 
                                            class="w-[46px] min-w-[46px] h-[46px] rounded-[50%]">
                                        <div v-else class="bg-[#5c6bc0] w-[46px] h-[46px] border-[1px] rounded-[50%]
                                                flex justify-center items-center">
                                            <span class="text-[#fff] text-[14px]">{{
                                                comment.commentator[0] }}</span>
                                        </div>
                                    </Link>
                                    <div :id="comment.id" class="relative ml-[12px] mt-[-4px] pr-[52px] comment-load-more comment-hidden">
                                        <span class="font-bold text-[16px]">
                                            <Link :href="route('creator', comment.commentator_code)">
                                                <span v-if="dataForm.creatorCode == comment.commentator_code">Tác giả: </span>
                                                <span v-else>{{ comment.commentator }}: </span>
                                            </Link>
                                        </span>
                                        <!-- comment content -->
                                        <span class="text-[15px] whitespace-pre-line">
                                            <span class="comment-content-cut">
                                                {{ comment.content.substring(0, 220) }}
                                                <span v-if="comment.content.length > 220"  class="text-[16px]">...</span>
                                            </span>
                                            <span class="comment-content-all">
                                                {{ comment.content }}
                                            </span>
                                            <div v-if="comment.content.length > 220" @click="loadMoreComment(comment.id)"
                                             class="comment-load-more-btn font-bold text-[#495057] text-[14px] mt-[4px] mb-[6px] cursor-pointer">
                                                Đọc thêm
                                            </div>
                                        </span>
                                        <div class="mt-[4px] text-[14px] text-[#9F9F9F] flex items-center">
                                            <span class="cursor-pointer flex items-center">
                                                <i class="bi bi-hand-thumbs-up-fill hover:text-[red] text-[18px]" 
                                                  :class="{ 'text-[#0d6efd]' : comment.is_like_comment }" @click="changeStatusLike(comment)"></i>
                                                <span v-if="comment.count_like_comment > 0" class="ml-[4px] mb-[2px]">{{ comment.count_like_comment }}</span>
                                            </span>
                                            <span class="mx-[24px] mb-[2px] hover:text-[red] cursor-pointer" @click="openCommentForm(comment.id)">
                                                Trả lời
                                            </span>
                                            <span class="mb-[2px] text-[13px]">{{ convertTime(comment.created_at) }}</span>
                                        </div>
                                        <div class="mt-[4px]" v-if="comment.count_comment_child != 0">
                                            <div class="text-[17px] text-[#065fd4] px-[12px] h-[36px] leading-[36px] text-center border-[2px] ml-[-24px]
                                             border-[#fff] w-[130px] rounded-[18px] cursor-pointer hover:bg-[#f2f8ff] hover:border-[#e9ecef] btn"
                                             @click="openComment(comment.id)">
                                                <i class="comment-icon bi bi-caret-down-fill"></i>
                                                <span class="ml-[6px] text-[15px]">Phản hồi</span>
                                            </div>
                                            <div class="comment-item">
                                                <div class="flex mt-[8px] relative" v-if="comment.comment_child.length > 0" 
                                                    v-for="commentChild in comment.comment_child">
                                                    <Link :href="route('creator', commentChild.commentator_code)">
                                                        <img v-if="commentChild.commentator_image" :src="commentChild.commentator_image" alt="" 
                                                            class="w-[36px] min-w-[36px] h-[36px] rounded-[50%]">
                                                        <div v-else class="bg-[#5c6bc0] w-[36px] h-[36px] border-[1px] rounded-[50%]
                                                                flex justify-center items-center">
                                                            <span class="text-[#fff] text-[14px]">
                                                                {{commentChild.commentator[0] }}
                                                            </span>
                                                        </div>
                                                    </Link>
                                                    <div :id="commentChild.id" class="ml-[12px] mt-[-4px] comment-child-load-more">
                                                        <span class="font-bold text-[15px]">
                                                            <Link :href="route('creator', commentChild.commentator_code)">
                                                                <span v-if="dataForm.creatorCode == commentChild.commentator_code">Tác giả: </span>
                                                                <span v-else>{{ commentChild.commentator }}: </span>
                                                            </Link>
                                                        </span>
                                                        <span class="text-[15px] whitespace-pre-line">
                                                            <span class="comment-child-content-cut">
                                                                {{ commentChild.content.substring(0, 220) }}
                                                                <span v-if="commentChild.content.length > 220"  class="text-[16px]">...</span>
                                                            </span>
                                                            <!-- comment child content -->
                                                            <span class="comment-child-content-all">
                                                                {{ commentChild.content }}
                                                            </span>
                                                            <div v-if="commentChild.content.length > 220" @click="loadMoreCommentChild(commentChild.id)"
                                                            class="comment-child-load-more-btn font-bold text-[#495057] text-[14px] mt-[4px] mb-[6px] cursor-pointer">
                                                                Đọc thêm
                                                            </div>
                                                        </span>
                                                        <div class="mt-[4px] text-[14px] text-[#9F9F9F] flex items-center">
                                                            <span class="cursor-pointer flex items-center">
                                                                <i class="bi bi-hand-thumbs-up-fill hover:text-[red] text-[18px]" 
                                                                :class="{ 'text-[#0d6efd]' : commentChild.is_like_comment }" @click="changeStatusLike(commentChild)"></i>
                                                                <span v-if="commentChild.count_like_comment > 0" class="ml-[4px] mb-[2px]">{{ commentChild.count_like_comment }}</span>
                                                            </span>
                                                            <span class="ml-[24px] mb-[2px] text-[13px]">{{ convertTime(commentChild.created_at) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="btn absolute top-[-2px] right-[-52px] text-[24px] h-[36px] w-[36px] flex 
                                                        items-center justify-center text-center cursor-pointer rounded-[50%] hover:bg-[#e9ecef]">
                                                        <el-dropdown>
                                                            <span class="text-[24px]">
                                                                <i class="bi bi-three-dots"></i>
                                                            </span>
                                                            <template #dropdown>
                                                                <el-dropdown-menu>
                                                                    <template v-if="this.$page.props.auth.account && commentChild.commentator_code == this.$page.props.auth.account.code">
                                                                        <el-dropdown-item  @click="openEditCommentForm(commentChild)">
                                                                            Chỉnh sửa
                                                                        </el-dropdown-item>
                                                                        <el-dropdown-item @click="deleteComment(commentChild)">
                                                                            Xóa bình luận
                                                                        </el-dropdown-item>
                                                                    </template>
                                                                    <el-dropdown-item v-else @click="reportUser(commentChild)">
                                                                        Báo cáo vi phạm
                                                                    </el-dropdown-item>
                                                                </el-dropdown-menu>
                                                            </template>
                                                        </el-dropdown>
                                                    </div>
                                                </div>
                                                <div v-if="comment.is_load_comment_child" class="ml-[48px] text-[15px] mt-[4px] cursor-pointer
                                                    text-[#065fd4] btn" @click="loadCommentChild(comment)">
                                                    Đọc thêm
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn absolute top-[-2px] right-0 text-[24px] h-[36px] w-[36px] flex 
                                            items-center justify-center text-center cursor-pointer rounded-[50%] hover:bg-[#e9ecef]">
                                            <el-dropdown>
                                                <span class="text-[24px]">
                                                    <i class="bi bi-three-dots"></i>
                                                </span>
                                                <template #dropdown>
                                                    <el-dropdown-menu>
                                                        <template v-if="this.$page.props.auth.account && comment.commentator_code == this.$page.props.auth.account.code">
                                                            <el-dropdown-item  @click="openEditCommentForm(comment)">
                                                                Chỉnh sửa
                                                            </el-dropdown-item>
                                                            <el-dropdown-item @click="deleteComment(comment)">
                                                                Xóa bình luận
                                                            </el-dropdown-item>
                                                        </template>
                                                        <el-dropdown-item v-else @click="reportUser(comment)">
                                                            Báo cáo vi phạm
                                                        </el-dropdown-item>
                                                    </el-dropdown-menu>
                                                </template>
                                            </el-dropdown>
                                        </div>
                                    </div>
                                    <div v-if="this.$page.props.auth.account" class="comment-form absolute top-[100%] mt-[6px] left-[52px] right-0 bg-[#f8f9fa] z-50 
                                        border-[1px] p-[18px] rounded-[8px] box-shadow">
                                        <div class="flex">
                                            <img v-if="this.$page.props.auth.account.image" :src="this.$page.props.auth.account.image" alt="" 
                                                class="w-[36px] min-w-[36px] h-[36px] rounded-[50%]">
                                            <div v-else class="bg-[#5c6bc0] w-[36px] h-[36px] border-[1px] rounded-[50%]
                                                    flex justify-center items-center">
                                                <span class="text-[#fff] text-[14px]">{{
                                                    this.$page.props.auth.account.first_name[0] }}</span>
                                            </div>
                                            <div class="ml-[12px] flex-auto">
                                                <el-input
                                                    v-model="contentCommentChild"
                                                    :autosize="{ minRows: 3, maxRows: 3 }"
                                                    type="textarea"
                                                    placeholder="Nhập bình luận"
                                                />
                                                <div v-if="errors.contentChild" class="mt-[5px] text-[#ff0000] text-[15px]">
                                                    {{ errors.contentChild }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-[12px] mr-[18px]">
                                            <div class="btn border-[1px] border-[#adb5bd] px-[32px] py-[8px] bg-[#fff] text-[14px] cursor-pointer 
                                                rounded-[4px] active:scale-95 mr-[18px]"
                                                @click="openCommentForm(comment.id)">
                                                Đóng
                                            </div>
                                            <div class="btn border-[1px] px-[16px] py-[8px] bg-[#2877af] text-white text-[14px] cursor-pointer 
                                                rounded-[4px] active:scale-95"
                                                @click="sendCommentChild(comment.id)">
                                                Gửi bình luận
                                            </div>
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
                <div class="py-[12px] pt-[12px]">
                    <div class="heading mt-4px uppercase font-bold text-[#db562b]">
                        Bài viết liên quan
                    </div>
                    <div class="mt-[18px] grid grid-cols-3 gap-3 mb-[18px]">
                        <template v-for="post in listPostRelates">
                            <div class="mt-[8px]">
                                <Link :href="route('post', post.slug)">
                                    <img :src="post.image" class="h-[200px] object-cover w-[100%] post-image">
                                </Link>
                                <div class="px-[2px]">
                                    <Link :href="route('post', post.slug)">
                                        <div class="font-bold text-[15px] mt-[8px]">{{ post.title }}</div>
                                    </Link>
                                    <div class="flex items-center mt-[4px]">
                                        <Link :href="route('list-category', post.categorySlug)">
                                            <div class="text-[14px] font-bold text-[#076db6]">{{ post.categoryName }}</div>
                                        </Link>
                                        <div class="ml-[16px] text-[13px] mt-[4px]">{{ convertTime(post.created_at) }}</div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div v-if="isLoadPost" class="btn mt-[28px] mx-[8px] border-[1px] border-[#adb5bd] py-[8px] 
                        flex justify-center cursor-pointer text-[15px] active:bg-[#eff1f3]" @click="loadPost">
                        Xem thêm bài viết
                    </div>
                </div>
            </div>

            <LoginForm ref="loginForm" @login="login"/>
            <ShowFormReport ref="showFormReport"/>
            <EditFormComment ref="editFormComment" @change-update="fetchDataComment"/>
            <ShowFormReportUser ref="showFormReportUser" @change-update="fetchDataComment"/>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import moment from "moment";
import { ElMessage, ElMessageBox } from 'element-plus'
import LoginForm from '../Components/Auth/Login.vue';
import ShowFormReport from '../Components/Post/ShowFormReport.vue';
import ShowFormReportUser from '../Components/Post/ShowFormReportUser.vue';
import EditFormComment from '../Components/Post/EditFormComment.vue';
import axios from 'axios';

export default{
    components:{
        AppLayout,
        Link,
        LoginForm,  
        ShowFormReport,
        EditFormComment,
        ShowFormReportUser
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
            listPostRelates: [],
            idOpenFormComment: '',
            contentComment: '',
            contentCommentChild: '',
            comments: [],
            comment: {},
            pageComment: 6,
            totalcomment: 0,
            nextComment: false,
            isLoadPost: true,
            number_data: 6,
            errors: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        moment,
        async loadPost() {
            const responseRelates = await axios.get(route('post.get-list-post-relate', 
                {'id': this.dataForm.id, number_data: this.number_data}))

            this.listPostRelates = responseRelates.data.data
            if(responseRelates.data.meta.current_page === responseRelates.data.meta.last_page) {
                this.isLoadPost = false
            }
            else{
                this.number_data += 6
            }
        },
        async fetchData() {
            const response = await axios.get(route('post.get-post', this.$page.props.slug))
            this.dataForm = response.data.data
            this.fetchDataComment()
            this.loadPost()
        },
        async fetchDataComment() {
            const responseComment = await axios.get(route('get-comments', {
                id: this.dataForm.id,
                page_number: this.pageComment,
                comment_id: this.comment ? this.comment.id : '',
                page_number_child: this.comment ? Number(this.comment.page_number_comment_child) + 6 : ''
            }))
            this.comments = responseComment.data.data

            this.totalcomment = 0
            responseComment.data.data.forEach(element => {
                this.totalcomment += 1 + element.count_comment_child
            });

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
                this.$refs.showFormReport.open(this.dataForm.id)
            }
            else {
                this.$refs.loginForm.open()
            }
        },
        openCommentForm(row) {
            if(this.$page.props.auth.account) {
                if (row == this.idOpenFormComment) {
                    this.contentCommentChild = ''
                    this.errors = []
                    this.idOpenFormComment = ''
                }
                else {
                    this.contentCommentChild = ''
                    this.idOpenFormComment = row
                }
            }
            else {
                this.$refs.loginForm.open()
            }
        },
        sendCommentChild(id) {
            if(this.contentCommentChild) {
                const pagram = {
                    ...{
                        'content': this.contentCommentChild
                    }
                }
                axios.post(route('create-comment-child', id), pagram)
                    .then(response => {
                        ElMessage({
                            showClose: true,
                            message: 'Thêm bình luận thành công',
                            type: 'success',
                        })
                        this.contentCommentChild = ''
                        this.errors = []
                        this.fetchDataComment()
                    })
                    .catch(() => {})
            }
            else {
                this.errors.contentChild = 'Trường nội dung là bắt buộc'
            }
        },
        loadCommentChild(comment) {
            this.comment = comment
            this.fetchDataComment()
        },
        openEditCommentForm(comment) {
            this.$refs.editFormComment.open(comment.id)
        },
        reportUser(comment) {
            if(this.$page.props.auth.account) {
                this.$refs.showFormReportUser.open(comment.commentator_code)
            }
            else {
                this.$refs.loginForm.open()
            }
        },
        deleteComment(comment) {
            ElMessageBox.confirm(
                'Bạn có muốn xóa bình luận vừa chọn không?',
                'Warning',
                {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy bỏ',
                    type: 'warning',
                })
                .then(() => {
                    axios.get(route('delete-comment', comment.id))
                        .then(() => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Xóa bình luận thành công',
                            })
                        })
                        .catch(error => {
                            ElMessage({
                                type: 'error',
                                message: error.message,
                            })
                        })
                })
        },

        // js default
        openComment(id) {
            document.getElementById(`${id}`).classList.toggle('comment-hidden')
            document.getElementById(`${id}`).querySelector('.comment-icon').classList.toggle('bi-caret-up-fill')
        },
        loadMoreComment(id) {
            document.getElementById(`${id}`).classList.toggle('comment-load-more')
            if(document.getElementById(`${id}`).classList.contains('comment-load-more')) {
                document.getElementById(`${id}`).querySelector('.comment-load-more-btn').textContent = "Đọc thêm"
            }
            else{
                document.getElementById(`${id}`).querySelector('.comment-load-more-btn').textContent = "Ẩn bớt"
            }
        },
        loadMoreCommentChild(id) {
            document.getElementById(`${id}`).classList.toggle('comment-child-load-more')
            if(document.getElementById(`${id}`).classList.contains('comment-child-load-more')) {
                document.getElementById(`${id}`).querySelector('.comment-child-load-more-btn').textContent = "Đọc thêm"
            }
            else{
                document.getElementById(`${id}`).querySelector('.comment-child-load-more-btn').textContent = "Ẩn bớt"
            }
        }

    }
}

</script>
<style scoped>
.comment-hidden .comment-item{
    display: none;
}
.comment-content-cut {
    display: none;
}
.comment-content-all{
    display: contents;
}
.comment-load-more .comment-content-cut {
    display: contents;
}
.comment-load-more .comment-content-all {
    display: none
}
.comment-child-content-cut {
    display: none;
}
.comment-child-content-all{
    display: contents;
}
.comment-child-load-more .comment-child-content-cut {
    display: contents;
}
.comment-child-load-more .comment-child-content-all {
    display: none
}
main .main {
    background-color: #fff;
    padding: 12px 12px 48px 12px;
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
.comment-form {
    display: none;
}
.comment-active .comment-form {
    display: block;
}
</style>