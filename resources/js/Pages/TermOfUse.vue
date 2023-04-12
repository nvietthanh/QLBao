<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="main mx-auto mb-[24px] w-[940px] bg-[#fff] border-[2px]">
                <div class= "my-[24px] mx-[24px] border-[2px] px-[24px] py-[24px] rounded-[5px]">
                    <div class="text-center text-[18px] uppercase font-bold my-[8px]">Điều khoản sử dụng</div>
                    <div class="text-[15px] mt-[24px]">
                        Thỏa thuận sử dụng và bảo mật này (sau đây gọi là “Thỏa thuận”) được lập ra bởi và giữa bạn (“bạn”) và Công ty Cổ phần công nghệ ePi (“ePi” hoặc “chúng tôi”) về việc sử dụng bất kỳ hay tất cả các loại dịch vụ (“Dịch vụ”) của Baomoi.com (“Baomoi”) của bạn. Bằng việc sử dụng Dịch vụ, bạn đồng ý chịu ràng buộc bởi những điều khoản và điều kiện này.
                        Dịch vụ được thiết kế để giúp bạn tiếp cận thông tin tin tức được liên kết từ các trang không do ePi sở hữu hoặc quản lý. Cụ thể, Dịch vụ cung cấp những mô tả ngắn gọn về các bài báo để giúp bạn xác định nội dung chính của bài báo mà bạn quan tâm. Khi bạn lựa chọn một bài báo, bạn sẽ được kết nối tới website chứa bài báo đó (sau đây gọi là “website được kết nối”).
                        Thuật ngữ “bạn” để chỉ tất cả các cá nhân và/hoặc các tổ chức truy cập vào Baomoi vì bất kỳ lý do nào.
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'

export default{
    components:{
        AppLayout,
        Link,
    },
    data() {
        return {
            currentTab: 'kinh-te',
            filters: {
                tabComment: 'tab-0',
                page: 0,
            },
            comment: ''
        }  
    },
    created() {
    },
    mounted() {
        // let index = 0
        // setInterval(() => {
        //     document.querySelector('.partners .main > div').style.transform = `translateX(-${index}px)`
        //     index++
        //     if (index >= 300) {
        //         index = 0
        //     }
        // }, 20);
    },
    methods: {
        changeTabComment(tab) {
            this.filters.tabComment = tab
        },
        sendComment() {

        }
    }
}

</script>
<style scoped>
main .main {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}
</style>
  