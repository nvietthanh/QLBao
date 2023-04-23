<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="main mx-auto mb-[24px] w-[940px] bg-[#fff] border-[2px]">
                <div class= "my-[24px] mx-[24px] border-[2px] px-[48px] py-[24px] rounded-[5px]">
                    <div class="text-center text-[18px] uppercase font-bold my-[8px]">Chính sách bảo mật</div>
                    <div class="text-[15px] mt-[20px]">
                        <div v-html="dataForm.title" class="text-[18px] my-[8px] font-bold"></div>
                        <div v-html="dataForm.content"></div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import axios from 'axios';

export default{
    components:{
        AppLayout,
        Link,
    },
    data() {
        return {
            filters: {
                tabComment: 'tab-0',
                page: 0,
            },
            dataForm: {}
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        changeTabComment(tab) {
            this.filters.tabComment = tab
        },
        fetchData() {
            axios.get(route('get-private-policy'))
                .then(response => {
                    this.dataForm = response.data
                })
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
  