<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="bg-[#fff] flex w-[100%] box-shadow">
                <div class="min-w-[380px] w-[380px] border-r-[2px] py-[12px]">
                    <div class="px-[24px] w-[100%]">
                        <div class="font-bold mt-[8px]">Cuộc trò chuyện</div>
                        <div class="border-b-[2px] mt-[12px] pb-[18px] w-[100%] search">
                            <Dropdown align="left" class="right-0 w-[100%] text-[#000]" :contentClasses="[backgroundColor]">
                                <template #trigger>
                                    <el-input @keyup="searchAccount()" v-model="accountSearch" placeholder="Tìm cuộc trò chuyện" class="w-[100%]"/>
                                </template>
                                <template class="w-[100%]" #content>
                                    <div class="px-[2px] w-[100%] py-[6px]">
                                        <div v-if="listAccountSearch.length == 0" class="w-[100%] text-center text-[14px] py-[12px]">
                                            Không có dữ liệu
                                        </div>
                                        <div v-else class="w-[100%] max-h-[200px] overflow-y-scroll">
                                            <template v-for="account in listAccountSearch">
                                                <Link :href="route('user.list-message', account.account_id ?? 1)">
                                                    <div class="flex items-center hover:bg-[#f1f3f6] py-[8px] px-[12px]">
                                                        <img v-if="account.account_image" :src="account.account_image" alt="" class="w-[28px] h-[28px] rounded-[50%]">
                                                        <div v-else class="bg-[#5c6bc0] min-w-[28px] w-[28px] h-[28px] border-[1px] rounded-[50%]
                                                                flex justify-center items-center">
                                                            <span class="text-[#fff] text-[18px]">
                                                                {{ account.account_name[0] }}
                                                            </span>
                                                        </div>
                                                        <div class="ml-[10px]">
                                                            <div class="text-[14px] font-bold">{{ account.account_name }}</div>
                                                        </div>
                                                    </div>
                                                </Link>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <div class="pl-[24px]">
                        <div class="overflow-y-scroll max-h-[480px] h-[480px] mt-[8px]">
                            <template v-for="account in listAccount">
                                <Link :href="route('user.list-message', account.account_id)">
                                    <div class="flex items-center justify-between cursor-pointer rounded-[4px] px-[8px] py-[12px] active:bg-[#d4d5d6]"
                                     :class="{ 'bg-[#f1f3f6]' : account.account_id == accountSelect.account_id}">
                                        <div class="flex items-center">
                                            <img v-if="account.account_image" :src="account.account_image" alt="" class="w-[48px] h-[48px] rounded-[50%]">
                                            <div v-else class="bg-[#5c6bc0] min-w-[48px] w-[48px] h-[48px] border-[1px] rounded-[50%]
                                                    flex justify-center items-center">
                                                <span class="text-[#fff] text-[18px]">
                                                    {{ account.account_name[0] }}
                                                </span>
                                            </div>
                                            <div class="ml-[10px]">
                                                <div class="text-[14px] font-bold">{{ account.account_name }}</div>
                                                <div class="text-[13px] flex">
                                                    <span class="message-content">
                                                        <span :class="{ 'font-bold' : account.last_account_id && !account.status }">{{ !account.last_account_id ? 'Bạn: ' : '' }}{{ account.last_message }}</span>
                                                    </span>
                                                    <span class="ml-[12px] text-[12px]">{{ convertTime(account.last_message_time) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <template v-if="account.status == -1">
                                            <div class="ml-[12px] text-[20px] min-w-[10px]">...</div>
                                        </template>
                                        <template v-else>
                                            <div v-if="account.last_account_id && !account.status" class="ml-[12px] min-w-[10px] h-[10px] bg-[#0099FF] rounded-[50%]"></div>
                                        </template>
                                    </div>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="flex-auto">
                    <template v-if="accountSelect">
                        <div class="flex items-center border-b-[2px] h-[62px] px-[12px]"
                         :class="{ ' bg-[#3578E5] text-white' : !seenMessage}">
                            <div class="flex items-center">
                                <img v-if="accountSelect.account_image" :src="accountSelect.account_image" alt="" class="w-[42px] h-[42px] rounded-[50%]">
                                <div v-else class="bg-[#5c6bc0] min-w-[42px] w-[42px] h-[42px] border-[1px] rounded-[50%]
                                        flex justify-center items-center">
                                    <span class="text-[#fff] text-[18px]">
                                        {{ accountSelect.account_name[0] }}
                                    </span>
                                </div>
                                <span class="ml-[10px]">
                                    <div class="text-[15px] font-bold">{{ accountSelect.account_name }}</div>
                                    <div class="text-[12px]">Đang hoạt động</div>
                                </span>
                            </div>
                        </div>
                        <div class="overflow-y-scroll px-[12px] pb-[8px] flex flex-col-reverse"
                         :class="{ 'border-r-[2px] border-r-[#3578E5]' : !seenMessage, 'h-[498px] max-h-[498px]' : fileImageSelects.length == 0,
                         'h-[415px] max-h-[415px]' : fileImageSelects.length > 0 }" @click="changeStatus">
                            <div class="flex justify-end text-[12px] mt-[2px]" v-if="!accountSelect.last_account_id">
                                {{ accountSelect.status == -1 ? 'Đang gửi' : (accountSelect.status ? 'Đã xem' : 'Đã gửi') }}
                            </div>
                            <template v-for="(message, index) in listMessage">
                                <template v-if="message.account_send_id == this.$page.props.auth.account.id">
                                    <div v-if="message.type == 0" class="flex justify-end items-end text-white mt-[4px]">
                                        <div class="text-[15px] ml-[8px] bg-[#3578E5] max-w-[400px] py-[8px] px-[18px] rounded-[8px]">
                                            {{ message.content }}
                                        </div>
                                    </div>
                                    <div v-else-if="message.type == 1" class="flex justify-end items-end mt-[4px]">
                                        <template v-if="message.file.length >= 3">
                                            <div class="grid grid-cols-3 gap-1 w-[400px]">
                                                <template v-for="image in message.file">
                                                    <el-image
                                                        style="width: 100%; height: 120px; border-radius: 8px"
                                                        :src="image"
                                                        :zoom-rate="1.2"
                                                        preview-teleported="true"
                                                        hide-on-click-modal="true"
                                                        :preview-src-list="[image]"
                                                        :initial-index="1"
                                                        fit="cover"
                                                    />
                                                </template>
                                            </div>
                                        </template>
                                        <template v-else-if="message.file.length == 2">
                                            <div class="grid grid-cols-2 gap-1 w-[400px]">
                                                <template v-for="image in message.file">
                                                    <el-image
                                                        style="width: 100%; height: 180px; border-radius: 8px"
                                                        :src="image"
                                                        :zoom-rate="1.2"
                                                        preview-teleported="true"
                                                        hide-on-click-modal="true"
                                                        :preview-src-list="[image]"
                                                        :initial-index="1"
                                                        fit="cover"
                                                    />
                                                </template>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="w-[280px]">
                                                <el-image
                                                    style="width: 100%; height: 180px; border-radius: 8px"
                                                    :src="message.file[0]"
                                                    :zoom-rate="1.2"
                                                    preview-teleported="true"
                                                    hide-on-click-modal="true"
                                                    :preview-src-list="[message.file[0]]"
                                                    :initial-index="1"
                                                    fit="cover"
                                                />
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <div v-else class="flex items-end">
                                    <img v-if="message.account_send_image" :src="message.account_send_image" alt="" class="w-[32px] h-[32px] rounded-[50%]">
                                    <div v-else class="bg-[#5c6bc0] min-w-[32px] w-[32px] h-[32px] border-[1px] rounded-[50%]
                                            flex justify-center items-center">
                                        <span class="text-[#fff] text-[13px]">
                                            {{ message.account_send_name[0] }}
                                        </span>
                                    </div>
                                    <div v-if="message.type == 0" class="mt-[4px]">
                                        <div class="text-[15px] ml-[8px] bg-[#e9ecef] max-w-[400px] py-[8px] px-[18px] rounded-[8px]">
                                            {{ message.content }}
                                        </div>
                                    </div>
                                    <div v-else-if="message.type == 1" class="mt-[4px]">
                                        <div class="ml-[8px]">
                                            <template v-if="message.file.length == 3">
                                                <div class="grid grid-cols-3 gap-1 w-[400px]">
                                                    <template v-for="image in message.file">
                                                        <el-image
                                                            style="width: 100%; height: 120px; border-radius: 8px"
                                                            :src="image"
                                                            :zoom-rate="1.2"
                                                            preview-teleported="true"
                                                            hide-on-click-modal="true"
                                                            :preview-src-list="[image]"
                                                            :initial-index="1"
                                                            fit="cover"
                                                        />
                                                    </template>
                                                </div>
                                            </template>
                                            <template v-else-if="message.file.length == 2">
                                                <div class="grid grid-cols-2 gap-1 w-[400px]">
                                                    <template v-for="image in message.file">
                                                        <el-image
                                                            style="width: 100%; height: 180px; border-radius: 8px"
                                                            :src="image"
                                                            :zoom-rate="1.2"
                                                            preview-teleported="true"
                                                            hide-on-click-modal="true"
                                                            :preview-src-list="[image]"
                                                            :initial-index="1"
                                                            fit="cover"
                                                        />
                                                    </template>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="w-[280px]">
                                                    <el-image
                                                        style="width: 100%; height: 180px; border-radius: 8px"
                                                        :src="message.file[0]"
                                                        :zoom-rate="1.2"
                                                        preview-teleported="true"
                                                        hide-on-click-modal="true"
                                                        :preview-src-list="[message.file[0]]"
                                                        :initial-index="1"
                                                        fit="cover"
                                                    />
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="w-[100%]">
                            <div class="flex bg-[#e9ecef] pt-[12px] px-[12px] mx-[18px] rounded-t-[8px]"
                             v-if="fileImageSelects.length > 0">
                                <div class="mr-[12px] min-w-[70px] w-[70px] h-[70px] leading-[70px] text-center bg-[#fff] rounded-[8px]
                                 hover:bg-[#f8f9fa] cursor-pointer" @click="this.$refs.file.click()">
                                    <i class="bi bi-plus-lg"></i>
                                </div>
                                <template v-for="(image, index) in fileImageSelects">
                                    <div class="mr-[12px] min-w-[70px] w-[70px] h-[70px] relative object-cover">
                                        <img :src="image" alt="" class="rounded-[8px] w-[100%] h-[100%]">
                                        <span class="absolute top-[-4px] right-[-4px] bg-[#fff] rounded-[50%] text-[12px] w-[21px] h-[21px]
                                            leading-[23px] text-center border-[#ced4da] border-[1px] hover:bg-[#e9ecef] cursor-pointer"
                                            @click="deleteImageSelect(index)">
                                            <i class="bi bi-x-lg"></i>
                                        </span>
                                    </div>
                                </template>
                            </div>
                            <div class="flex border-t-[1px] text-[#3578E5] py-[8px]" @click="changeStatus">
                                <div class="mx-[18px] flex w-[100%] justify-between items-center">
                                    <div class="flex justify-between">
                                        <span class="text-[20px] cursor-pointer active:scale-[97%]">
                                            <i class="bi bi-plus-circle"></i>
                                        </span>
                                        <span class="ml-[10px] text-[20px] cursor-pointer active:scale-[97%]" :class="{ 'd-none' : this.isChangeMessage }"
                                         @click="this.$refs.file.click()">
                                            <i class="bi bi-image"></i>
                                            <input ref="file" type="file" accept=".jpg,.png,.bmp,.jpeg,.tif,.gif" multiple @change="changeImage" hidden>
                                        </span>
                                        <span class="ml-[10px] text-[20px] cursor-pointer active:scale-[97%]" :class="{ 'd-none' : this.isChangeMessage }">
                                            <i class="bi bi-file-earmark-plus"></i>
                                        </span>
                                        <span class="ml-[10px] text-[20px] cursor-pointer active:scale-[97%]" :class="{ 'd-none' : this.isChangeMessage }">
                                            <i class="bi bi-plus-circle"></i>
                                        </span>
                                    </div>
                                    <div class="flex-auto mx-[18px]">
                                        <el-input ref="message" @keyup.enter="sendMessage" v-model="dataForm.message" placeholder="Nhập nội dung tin nhắn" 
                                        @keyup="changeInput"/>
                                    </div>
                                    <span class="text-[24px] cursor-pointer" @click="sendMessage">
                                        <i class="bi bi-send-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="w-[100%] h-[100%] flex justify-center items-center">
                            <b>Không có cuộc hội thoại nào, hãy chọn cuộc hội thoại</b>
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
import moment  from 'moment'
import Navigation from '@/Components/User/Navigation.vue'
import Dropdown from "@/Components/Dropdown.vue";

export default{
    components:{
        AppLayout,
        Link,
        Navigation,
        Dropdown
    },
    props: {
        title: String,
        currentTab: { type: String, required: true },
        backgroundColor: {
            type: String,
            default: "bg-[#fff]",
        },
    },
    data() {
        return {
            fileImageSelects: [],
            accountSearch: '',
            accountSelect: '',
            listAccount: {},
            listAccountSearch: {},
            accountSelect: '',
            listMessage: [],
            isChangeMessage: false,
            seenMessage: true,
            dataForm: {
                message: '',
                images: []
            }
        }  
    },
    created() {
        document.title = `Danh sách cuộc trò chuyện`
        this.fetchData()
        Echo.channel(`send-message.${this.$page.props.auth.account.id}`).listen('SendMessageEvent', (e) => {
            const index = this.listAccount.findIndex(account => account.account_id == e.account_send_id)
            let account = this.listAccount.find(account => account.account_id == e.account_send_id)
            account.last_account_id = true
            account.last_message = e.message.content
            account.status = 0
            account.last_message_time = moment().format('YYYY/MM/DD H:mm:ss')
            this.listAccount.splice(index, 1)
            this.listAccount.unshift(account)

            if(e.account_send_id == this.accountSelect.account_id) {
                this.listMessage.unshift(e.message)
                this.accountSelect.is_account_send = 1
                if(!e.message.status) {
                    this.seenMessage = false
                }
                else {
                    this.seenMessage = true
                }
            }
        })

        Echo.channel(`change-status-message.${this.$page.props.auth.account.id}`).listen('ChangeStatusMessageEvent', (e) => {
            let accountFind = this.listAccount.find(account => account.account_id == e.account_send_id)
            if(accountFind) {
                accountFind = e.status
            }
            if(e.account_send_id == this.accountSelect.account_id) {
                this.accountSelect.status = e.status
            }
        })
    },
    methods: {
        moment,
        async fetchData() {
            await axios.get(route('list-account-message'))
                .then(response => {
                    this.listAccount = response.data.data
                })
                .catch(()=>{})
            
            if(this.$page.props.account_message_id) {
                this.listAccount.forEach(account => {
                    if(account.account_id == this.$page.props.account_message_id) {
                        this.accountSelect = account
                        return
                    }
                })
                if(!this.accountSelect) {
                    this.accountSelect = this.$page.props.accountSelect
                }
                else {
                    this.fetchListMessage()
                }
            }
        },
        async fetchListAccount() {
            await axios.get(route('list-account-message'))
                .then(response => {
                    this.listAccount = response.data.data
                })
                .catch(()=>{})
        },
        async fetchListMessage() {
            await axios.get(route('list-message', this.accountSelect.account_id))
                .then(response => {
                    this.listMessage = response.data.data.reverse()
                    if(this.listMessage.length > 0 && this.accountSelect.status == 0 && this.accountSelect.last_account_id) {
                        this.seenMessage = false
                    }
                    else {
                        this.seenMessage = true
                    }
                })
                .catch(()=>{})
        },
        searchAccount() {
            const pagram = {
                keyword: this.accountSearch
            }
            axios.get(route('search-account-message', pagram))
                    .then(response => {
                        this.listAccountSearch = response.data
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors
                    })
        },
        sendMessage() {
            if(this.dataForm.message || this.dataForm.images.length > 0) {
                this.accountSelect.is_account_send = 0
                this.accountSelect.status = 0
                
                const pagram = new FormData()
                pagram.append('id', this.accountSelect.account_id)
                pagram.append('message', this.dataForm.message)
                for(let image of this.dataForm.images) {
                    pagram.append('images[]', image)
                }
                const message = {
                    account_receive_id: this.accountSelect.id,
                    account_receive_image: this.accountSelect.image,
                    account_receive_name: this.accountSelect.name,
                    account_send_id: this.$page.props.auth.account.id,
                    account_send_image: this.$page.props.auth.account.id,
                    account_send_name: this.$page.props.auth.account.first_name + ' ' + this.$page.props.auth.account.last_name,
                    content: this.dataForm.message,
                    created_at: moment().format('YYYY/MM/DD H:mm:ss'),
                    file: JSON.parse(JSON.stringify(this.fileImageSelects)),
                    status: false,
                    type: this.dataForm.message ? 0 : 1,
                }
                this.listMessage.unshift(message)

                // clear data input message
                this.dataForm.message = ''
                this.dataForm.images = []
                this.fileImageSelects = []
                this.isChangeMessage = false

                this.accountSelect.status = -1
                this.accountSelect.last_account_id = false
                this.accountSelect.last_message_time = moment().format('YYYY/MM/DD H:mm:ss')
                let accountFind = this.listAccount.find(account => account.account_id == this.accountSelect.account_id)
                if(!accountFind) {
                    accountFind = this.listAccount.append(this.accountSelect)
                }
            
                accountFind.last_message = message.content
                accountFind.last_account_id = false
                accountFind.last_message_time = moment().format('YYYY/MM/DD H:mm:ss')
                accountFind.status = -1

                axios.post(route('send-message'), pagram)
                    .then(response => {
                        this.accountSelect.status = 0
                        accountFind.status = 0
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors
                    })
            }
        },
        changeStatus() {
            const lastMesssage = this.listMessage[0]
            if(lastMesssage && lastMesssage.account_receive_id == this.$page.props.auth.account.id && lastMesssage.status == 0) {
                this.seenMessage = true
                let accountFind = this.listAccount.find(account => account.account_id == this.accountSelect.account_id)
                if(accountFind) {
                    accountFind.status = 1
                }
                axios.get(route('change-status-message', this.accountSelect.account_id))
            }
        },
        changeInput() {
            if(this.dataForm.message.length > 0) {
                this.isChangeMessage = true
            }
            else {
                this.isChangeMessage = false
            }
            this.changeStatus()
        },
        async changeImage(e) {
            try {
                const files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;

                for(let file of files) {
                    const nameFile = file.name.substring(file.name.lastIndexOf('.'));
                    const valiFileType = ['.png', '.bmp', '.jpeg', '.tif', '.gif', '.jpg'];
                    if (!valiFileType.find((i) => i === nameFile)) {
                        this.$message.warning(
                            this.$i18n.t(`File sai định dạng. Cần thuộc các định dạng sau: `) + valiFileType.join(', ')
                        );

                        return false;
                    }
                    this.dataForm.images.push(file)
                    this.fileImageSelects.push(URL.createObjectURL(file))
                }
            } catch (err) {
                console.log('handleUploadContent', err);
            }
        },
        deleteImageSelect(index) {
            this.fileImageSelects.shift(index)
            this.dataForm.images.shift(index)
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
            else{
                return `1 giây trước`
            }
        },
    }
}

</script>
<style>
.box-shadow {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
.search .absolute  {
    width: 100% !important;
}
.message-content {
    max-width: 145px;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 1;
    display: -webkit-box;
    -webkit-box-orient: vertical;
}
</style>
  