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
                    <div class="mt-[8px] mb-[16px] mx-[12px] grid grid-cols-2 gap-2">
                        <div v-for="item in formData" class="mt-[8px]">
                            <div class="mt-[8px] px-[8px] py-[12px] border-[2px] flex hover:bg-[#e9ecef] rounded-[4px]">
                                <Link class="flex flex-auto" :href="route('creator', item.id)">
                                    <div class="flex flex-auto">
                                        <img :src="item.image" alt="" class="w-[60px] h-[60px] rounded-[50%]">
                                        <div class="ml-[10px] mt-[1px]">
                                            <div class="text-[15px] font-bold">{{ item.name }}</div>
                                            <div class="text-[13px]">{{ item.description }}</div>
                                        </div>
                                    </div>
                                </Link>
                                <div class="flex items-center text-[26px] mr-[8px] text-[#adb5bd] cursor-pointer hover:text-[#6c757d]" 
                                 @click="unFollow(item.id, item.name)">
                                    <i class="bi bi-check-lg"></i>
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
            isEditProfile: false,
            imageSelected: '',
            formData: [
                {
                    name: 'Nguyễn Viết Thanh',
                    description: 'Chuyên viên kinh doanh',
                    image: '/image/avatar.jpg',
                    id: '1',
                },
                {
                    name: 'Nguyễn Viết Thanh',
                    description: 'Chuyên viên kinh doanh',
                    image: '/image/avatar.jpg',
                    id: '2'
                },
                {
                    name: 'Nguyễn Viết Thanh',
                    description: 'Chuyên viên kinh doanh',
                    image: '/image/avatar.jpg',
                    id: '3'
                },
                {
                    name: 'Nguyễn Viết Thanh',
                    description: 'Chuyên viên kinh doanh',
                    image: '/image/avatar.jpg',
                    id: '4',
                },
            ]
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.isEditProfile = false
            this.imageSelected = '/image/avatar.jpg'
            this.formData.firstname = 'Nguyễn Viết'
            this.fetchData.lastname = 'Thanh'
            this.formData.male = '0'
            this.formData.phone = '0358387102'
            this.formData.img = ''
        },
        unFollow(id, name) {
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
                        setTimeout(() => {
                            instance.confirmButtonLoading = false
                            done()
                        }, 3000)
                    } else {
                        done()
                    }
                },
            }).then(() => {
                ElMessage({
                    type: 'success',
                    message: `Hủy theo dõi ${name} thành công`,
                })
                this.isEditProfile = 'tab-0'
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
</style>
  