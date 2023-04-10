<template>
    <AppLayoutAdmin>
        <template v-slot:main-full>
            <div class="h-[1500px]">
                aagag
            </div>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import { Link } from '@inertiajs/vue3'

export default{
    components:{
        AppLayoutAdmin,
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
    methods: {
    }
}

</script>
  