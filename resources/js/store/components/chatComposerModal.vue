<template>
    <div>
        <div v-model="getChatLogModalObj.showChatLogModal" class="flex">
            <input type="text" placeholder="Start typing your message" style="width: 400px;height: 30px;"
                   v-model="messageText" @keyup.enter="sendMessage"/>
            <button class="btn btn-primary" style="border-radius: 2rem;height: 30px;" @click="sendMessage">Send</button>
        </div>

    </div>
</template>


<script>
    import chatmessage from "./chatMessageModal";
    import {mapGetters} from "vuex";

    export default {
        props: ['user'],
        data() {
            return {
                messageText: ''
            };
        },
        methods: {
            sendMessage() {
                //console.log(this.messageText)
                // console.log(this.user.fullName)
                this.$emit('messagesent', {
                    message: this.messageText,
                    user_id: this.user.id
                // fullName:this.user.fullName


            })
                this.messageText = ''


            }
        },
        computed: {
            ...mapGetters(['getChatLogModalObj', 'setChatLogModalObj'])
        },
        components:
            {}

    };
</script>


<style scoped>
    ._1adminOverveiw_table_recent {
        margin: 0 auto;
        margin-top: 220px;
    }

    .login_footer {
        text-align: center;
    }

    .login_header {
        text-align: center;
        margin-bottom: 25px;
    }
</style>
