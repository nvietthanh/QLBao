<template>
    <div class="px-[6px] py-[12px] bg-[#fff] box-shadow">
        <div class="flex justify-center mt-[24px] mb-[30px]">
           <div class="flex flex-col items-center">
                <div v-if="!dataInfor.image"  class="bg-[#5c6bc0] w-[110px] h-[110px] border-[1px] rounded-[50%]
                 flex justify-center items-center">
                    <span class="text-[#fff] text-[30px]">{{ dataInfor.first_name[0] }}</span>
                </div>
                <img v-else :src="dataInfor.image" alt="" class="rounded-[50%] w-[110px] h-[110px]">
                <div class="text-[16=7px] font-bold mt-[12px]">
                    {{ dataInfor.first_name + ' ' + dataInfor.last_name }}
                </div>
           </div>
        </div>
        <div>
            <Link :href="route('user.my-profile')">
                <div class="py-[12px] px-[12px] text-[17px] border-b-[1px] cursor-pointer hover:bg-[#e9ecef]"
                :class="{ 'bg-[#e9ecef] text-[#0d6efd] font-bold' :currentTab == 'tab-0' }">
                    Thông tin chung
                </div>
            </Link>
            <Link :href="route('user.my-post')" v-if="this.$page.props.roles.find(d => d === 'Creator')">
                <div class="py-[12px] px-[12px] text-[17px] border-b-[1px] cursor-pointer hover:bg-[#e9ecef]"
                :class="{ 'bg-[#e9ecef] text-[#0d6efd] font-bold' :currentTab == 'tab-4' }">
                    Bài viết của bạn
                </div>
            </Link>
            <Link :href="route('user.list-follow')">
                <div class="py-[12px] px-[12px] text-[17px] border-b-[1px] cursor-pointer hover:bg-[#e9ecef]"
                :class="{ 'bg-[#e9ecef] text-[#0d6efd] font-bold' :currentTab == 'tab-1' }">
                    Tác giả đã theo dõi
                </div>
            </Link>
            <Link :href="route('user.list-read')">
                <div class="py-[12px] px-[12px] text-[17px] border-b-[1px] cursor-pointer hover:bg-[#e9ecef]"
                :class="{ 'bg-[#e9ecef] text-[#0d6efd] font-bold' :currentTab == 'tab-2' }">
                    Đọc gần đây
                </div>
            </Link>
            <Link :href="route('user.list-save')">
                <div class="py-[12px] px-[12px] text-[17px] border-b-[1px] cursor-pointer hover:bg-[#e9ecef]"
                :class="{ 'bg-[#e9ecef] text-[#0d6efd] font-bold' :currentTab == 'tab-3' }">
                    Bài viết đã lưu
                </div>
            </Link>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link
    },
    props: {
        currentTab: {
            type: String,
        }
    },
    data() {
        return {
            dataInfor: {
                first_name: '',
                last_name: '',
                image: ''
            }
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        async fetchData() {
            await axios.get(route('profiles.index'))
                .then(response => {
                    this.dataInfor = response.data.data
                })
                .catch(()=>{})
        }
    }
}
</script>