<template>
    <AppLayout :currentTab="'home'" :title="'Trang chủ'">
        <template v-slot:main-1>
            <div class="main">
                <div class="row p-[8px]">
                    <template v-for="(post, index) in listPostPopular">
                        <div v-if="index == 0" class="post-item border-b-[2px] pb-[18px]">
                            <Link :href="route('post', post.slug)">
                                <img class="post-image w-[100%] h-[480px] object-cover" :src="post.image" :alt="post.description">
                                <div class="post-title font-bold text-[21px] py-2">{{ post.title }}</div>
                            </Link>
                            <div class="flex items-end">
                                <Link :href="route('list-category', post.categorySlug)">
                                    <div class="text-[#076db6] text-[16px] font-bold">
                                        {{ post.categoryName }}
                                    </div>
                                </Link>
                                <div class="text-[15px] mx-[16px]">{{ convertTime(post.created_at) }}</div>
                            </div>
                        </div>
                        <div v-else-if="index < 4" class="post-item col-4 py-[24px] border-b-[2px]">
                            <Link :href="route('post', post.slug)">
                                <img :src="post.image" :alt="post.description" class="post-image w-[100%] h-[140px] object-cover">
                                <div class="post-title py-2 font-bold text-[16px]">{{ post.title }}</div>
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
                            <div class="post-item flex py-[18px] border-b-[2px]">
                                <Link :href="route('post', post.slug)">
                                    <img :src="post.image" :alt="post.description" class="post-image w-[220px] min-w-[220px] h-[150px] object-cover">
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
                        </div>
                    </template>
                </div>
                <div v-for="(hagtag, index) in listHagtagPopular" class="mt-[15px]">
                    <template v-if="1 > 0">
                        <div class="border-l-[5px] pl-[12px] border-l-[red] font-bold text-[red]">
                            <Link :href="route('list-post-hagtag', hagtag.slug)">
                                {{ hagtag.name }}
                            </Link>
                        </div>
                        <div v-for="post in listPosts[index]" class="mt-[2px]">
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
                        </div>
                    </template>
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
            listPosts: []
        }  
    },
    created() {
        this.fecthData()
        this.listHagtagPopular = this.$page.props.hagtags
        document.title = "Trang chủ"
    },
    methods: {
        moment,
        async fecthData() {
            await axios.get(route('post.get-list-post-popular'))
                .then(response => {
                    this.listPostPopular = response.data.data
                })
                .catch(errors => {})

            const pagram = { ...this.listHagtagPopular }
            await axios.post(route('post.get-list-hagtag-popular'), pagram)
                .then(response => {
                    this.listPosts = response.data
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
  