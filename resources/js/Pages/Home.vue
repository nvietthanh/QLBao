<template>
    <AppLayout :currentTab="'home'" :title="'Trang chủ'">
        <template v-slot:main-1>
            <div class="main">
                <div class="row p-[8px]">
                    <template v-for="(post, index) in listPostPopular">
                        <div v-if="index == 0" class="border-b-[2px] pb-[18px]">
                            <Link :href="route('post', post.slug)">
                                <img class="w-[100%] h-[480px] object-cover" :src="post.image" :alt="post.description">
                                <div class="font-bold text-[21px] py-2">{{ post.title }}</div>
                            </Link>
                            <div class="flex items-end">
                                <Link :href="route('list-category', post.categorySlug)">
                                    <div class="text-[#076db6] text-[16px] font-bold">
                                        {{ post.categoryName }}
                                    </div>
                                </Link>
                                <div class="text-[15px] mx-[16px]">{{ convertTime(post.created_at) }}</div>
                                <div class="text-[15px]">1000 liên quan</div>
                            </div>
                        </div>
                        <div v-else-if="index < 4" class="col-4 py-[24px] border-b-[2px]">
                            <Link :href="route('post', post.slug)">
                                <img :src="post.image" :alt="post.description" class="w-[100%] h-[140px] object-cover">
                                <div class="py-2 font-bold text-[16px]">{{ post.title }}</div>
                            </Link>
                            <div>
                                <Link :href="route('list-category', post.categorySlug)">
                                    <div class="text-[#076db6] font-bold text-[14px]">
                                        {{ post.categoryName }}
                                    </div>
                                </Link>
                                <div class="text-[14px] mt-[2px]">{{ convertTime(post.created_at) }}</div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="flex py-[18px] border-b-[2px]">
                                <Link :href="route('post', post.slug)">
                                    <img :src="post.image" :alt="post.description" class="w-[220px] h-[150px] object-cover">
                                </Link>
                                <div class="ml-[12px]">
                                    <Link :href="route('post', post.slug)">
                                        <div class="text-[16px] font-bold">
                                            {{ post.title }}
                                        </div>
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
                        </div>
                    </template>
                    <!-- <div class="border-b-[2px] pb-[16px]">
                        <Link :href="route('post', 'bai-bao-moi-nay-cua-chung-ta')">
                            <img class="w-[100%]"
                                src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ">
                            <div class="font-bold text-[22px] py-2">Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ</div>
                        </Link>
                        <div class="flex items-end">
                            <Link :href="route('home')">
                                <div class="text-[#076db6] text-[16px] font-bold">
                                    Kinh tế chính trị
                                </div>
                            </Link>
                            <div class="text-[15px] mx-[16px]">1 giờ trước</div>
                            <div class="text-[15px]">1000 liên quan</div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-[18px] border-b-[2px] pb-[18px]">
                        <div>
                            <Link :href="route('post', 'bai-bao-moi-nay-cua-chung-ta')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="CSGT khẳng định không làm thay nhiệm vụ đăng kiểm của Bộ Giao thông vận tải">
                                <div class="py-2 font-bold text-[16px]">Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ</div>
                            </Link>
                            <div class="default">
                                <Link :href="route('home')">
                                    <div class="text-[#076db6] font-bold text-[14px]">
                                        Kinh tế chính trị
                                    </div>
                                </Link>
                                <div class="text-[14px]">1 giờ trước</div>
                            </div>
                        </div>
                        <div class="mx-[12px]">
                            <Link :href="route('post', 'bai-bao-moi-nay-cua-chung-ta')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="CSGT khẳng định không làm thay nhiệm vụ đăng kiểm của Bộ Giao thông vận tải">
                                <div class="py-2 font-bold text-[16px]">Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ</div>
                            </Link>
                            <div class="default">
                                <Link :href="route('home')">
                                    <div class="text-[#076db6] font-bold text-[14px]">
                                        Kinh tế chính trị
                                    </div>
                                </Link>
                                <div class="text-[14px]">1 giờ trước</div>
                            </div>
                        </div>
                        <div>
                            <Link :href="route('post', 'bai-bao-moi-nay-cua-chung-ta')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="CSGT khẳng định không làm thay nhiệm vụ đăng kiểm của Bộ Giao thông vận tải">
                                <div class="py-2 font-bold text-[16px]">Giá xăng dầu ngày mai 13/3 có thể tăng nhẹ</div>
                            </Link>
                            <div class="default">
                                <Link :href="route('home')">
                                    <div class="text-[#076db6] font-bold text-[14px]">
                                        Kinh tế chính trị
                                    </div>
                                </Link>
                                <div class="text-[14px]">1 giờ trước</div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-[6px]">
                        <div class="flex py-[18px] border-b-[2px]">
                            <Link :href="route('home')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="" class="min-w-[220px] w-[220px] h-[150px]">
                            </Link>
                            <div class="ml-[12px]">
                                <Link :href="route('home')">
                                    <div class="text-[16px] font-bold">
                                        Cơi nới, chở quá tải mức thấp, tài xế xin 'đừng giữ xe' nhưng bất thành
                                    </div>
                                </Link>
                                <div class="mt-[12px] flex items-end">
                                    <Link :href="route('home')">
                                        <div class="text-[15px] font-bold text-[#076db6]">
                                            Kinh tế chính trị
                                        </div>
                                    </Link>
                                    <div class="text-[13px] mx-[16px]">1 giờ trước</div>
                                    <div class="text-[13px]">1000 liên quan</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-[18px] border-b-[2px]">
                            <Link :href="route('home')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="" class="min-w-[220px] w-[220px] h-[150px]">
                            </Link>
                            <div class="ml-[12px]">
                                <Link :href="route('home')">
                                    <div class="text-[16px] font-bold">
                                        Cơi nới, chở quá tải mức thấp, tài xế xin 'đừng giữ xe' nhưng bất thành
                                    </div>
                                </Link>
                                <div class="mt-[12px] flex items-end">
                                    <Link :href="route('home')">
                                        <div class="text-[15px] font-bold text-[#076db6]">
                                            Kinh tế chính trị
                                        </div>
                                    </Link>
                                    <div class="text-[13px] mx-[16px]">1 giờ trước</div>
                                    <div class="text-[13px]">1000 liên quan</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-[18px] border-b-[2px]">
                            <Link :href="route('home')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="" class="min-w-[220px] w-[220px] h-[150px]">
                            </Link>
                            <div class="ml-[12px]">
                                <Link :href="route('home')">
                                    <div class="text-[16px] font-bold">
                                        Cơi nới, chở quá tải mức thấp, tài xế xin 'đừng giữ xe' nhưng bất thành
                                    </div>
                                </Link>
                                <div class="mt-[12px] flex items-end">
                                    <Link :href="route('home')">
                                        <div class="text-[15px] font-bold text-[#076db6]">
                                            Kinh tế chính trị
                                        </div>
                                    </Link>
                                    <div class="text-[13px] mx-[16px]">1 giờ trước</div>
                                    <div class="text-[13px]">1000 liên quan</div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="mt-[20px]">
                    <div class="border-l-[5px] pl-[12px] border-l-[red] font-bold text-[red]">
                        Năng lượng tích cực
                    </div>
                    <div class="mt-[2px]">
                        <div class="flex py-[18px] border-b-[2px]">
                            <Link :href="route('home')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="" class="min-w-[220px] w-[220px] h-[150px]">
                            </Link>
                            <div class="ml-[12px]">
                                <Link :href="route('home')">
                                    <div class="text-[16px] font-bold">
                                        Cơi nới, chở quá tải mức thấp, tài xế xin 'đừng giữ xe' nhưng bất thành
                                    </div>
                                </Link>
                                <div class="mt-[12px] flex items-end">
                                    <Link :href="route('home')">
                                        <div class="text-[15px] font-bold text-[#076db6]">
                                            Kinh tế chính trị
                                        </div>
                                    </Link>
                                    <div class="text-[13px] mx-[16px]">1 giờ trước</div>
                                    <div class="text-[13px]">1000 liên quan</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-[18px] border-b-[2px]">
                            <Link :href="route('home')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="" class="min-w-[220px] w-[220px] h-[150px]">
                            </Link>
                            <div class="ml-[12px]">
                                <Link :href="route('home')">
                                    <div class="text-[16px] font-bold">
                                        Cơi nới, chở quá tải mức thấp, tài xế xin 'đừng giữ xe' nhưng bất thành
                                    </div>
                                </Link>
                                <div class="mt-[12px] flex items-end">
                                    <Link :href="route('home')">
                                        <div class="text-[15px] font-bold text-[#076db6]">
                                            Kinh tế chính trị
                                        </div>
                                    </Link>
                                    <div class="text-[13px] mx-[16px]">1 giờ trước</div>
                                    <div class="text-[13px]">1000 liên quan</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-[18px]">
                            <Link :href="route('home')">
                                <img src="\image\cf2a58bd5ff0b6aeefe1.jpg" alt="" class="min-w-[220px] w-[220px] h-[150px]">
                            </Link>
                            <div class="ml-[12px]">
                                <Link :href="route('home')">
                                    <div class="text-[16px] font-bold">
                                        Cơi nới, chở quá tải mức thấp, tài xế xin 'đừng giữ xe' nhưng bất thành
                                    </div>
                                </Link>
                                <div class="mt-[12px] flex items-end">
                                    <Link :href="route('home')">
                                        <div class="text-[15px] font-bold text-[#076db6]">
                                            Kinh tế chính trị
                                        </div>
                                    </Link>
                                    <div class="text-[13px] mx-[16px]">1 giờ trước</div>
                                    <div class="text-[13px]">1000 liên quan</div>
                                </div>
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

export default{
    components:{
        AppLayout,
        Link,
    },
    data() {
        return {
            currentTab: 'tab-0',
            listPostPopular: [],
            listHagtagPopular: [],
        }  
    },
    created() {
        this.fecthData()
    },
    methods: {
        moment,
        async fecthData() {
            await axios.get(route('post.get-list-post-popular'))
                .then(response => {
                    this.listPostPopular = response.data.data
                })
                .catch(errors => {})
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
  