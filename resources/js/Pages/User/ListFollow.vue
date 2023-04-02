<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="min-w-[280px] w-[280px]">
                <Navigation :currentTab="'tab-1'"/>
            </div>
            <div class="flex-auto ml-[16px]">
                <div class="py-[20px] bg-[#fff] box-shadow">
                    <div class="border-b-[2px] mb-[8px]">
                        <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                            Danh sách theo dõi
                        </div>
                    </div>
                    <template v-if="formData.length == 0">
                        <div class="text-center text-[16px] mt-[18px] mb-[6px]">
                            Bạn chưa theo dõi tác giả nào
                        </div>
                    </template>
                    <template v-else>
                        <div class="mt-[8px] mb-[16px] mx-[12px] grid grid-cols-2 gap-2">
                            <div v-for="item in formData" class="mt-[8px]">
                                <div class="mt-[8px] px-[8px] py-[12px] border-[2px] flex hover:bg-[#e9ecef] rounded-[4px]">
                                    <Link class="flex flex-auto" :href="route('creator', item.code)">
                                        <img v-if="item.image" :src="item.image" alt="" class="min-w-[60px] h-[60px] object-cover rounded-[50%]">
                                        <div v-else class="min-w-[60px] h-[60px] rounded-[50%] flex justify-center
                                            items-center bg-[#5c6bc0] text-white">
                                            {{ item.first_name[0] }}
                                        </div>
                                        <div class="ml-[10px] mt-[1px]">
                                            <div class="text-[15px] font-bold">{{ item.first_name + ' ' + item.last_name }}</div>
                                            <div class="description text-[13px]">{{ item.description }}</div>
                                        </div>
                                    </Link>
                                    <div class="flex items-center text-[26px] ml-[8px] mr-[8px] text-[#adb5bd] cursor-pointer hover:text-[#6c757d]" 
                                     @click="unFollow(item.code, item.first_name + ' ' + item.last_name)">
                                        <i class="bi bi-check-lg"></i>
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
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import { h } from 'vue'
import Navigation from '@/Components/User/Navigation.vue'

export default{
    components:{
        AppLayout,
        Link,
        Navigation
    },
    data() {
        return {
            currentTab: 'tab-2',
            formData: []
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        async fetchData() {
            const response = await axios.get(route('list-follows')  )
            this.formData = response.data.data
        },
        unFollow(code, name) {
            ElMessageBox({
                title: 'Hủy theo dõi',
                message: h('p', null, [
                    h('span', null, `Bạn có muốn hủy theo dõi ${ name } ?`),
                ]),
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy bỏ',
                beforeClose: (action, instance, done) => {
                    if (action === 'confirm') {
                        instance.confirmButtonLoading = true
                        instance.confirmButtonText = 'Loading...'
                        instance.closeForm = false
                        axios.get(route('unfollow-account', code))
                            .then(response => {
                                done()
                            })
                            .catch(() => {
                            })
                    } else {
                        done()
                    }
                },
            }).then(() => {
                ElMessage({
                    type: 'success',
                    message: `Hủy theo dõi ${name} thành công`,
                })
                this.fetchData()
            }).catch(() => {})
        }
    }
}

</script>
<style scoped>
.box-shadow {
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
  