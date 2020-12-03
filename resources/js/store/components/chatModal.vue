<template>
    <div>
        <beautiful-chat
            :participants="participants"
            :titleImageUrl="titleImageUrl"
            :onMessageWasSent="onMessageWasSent"
            :messageList="messageList"
            :newMessagesCount="newMessagesCount"
            :isOpen="isChatOpen"
            :close="closeChat"
            :open="openChat"
            :showEmoji="true"
            :showFile="true"
            :showTypingIndicator="showTypingIndicator"
            :colors="colors"
            :alwaysScrollToBottom="alwaysScrollToBottom"
            :messageStyling="messageStyling"/>

    </div>
</template>


<script>
    import {mapGetters} from 'vuex'


    export default {
        props: ['user'],
        name: 'app',
        data() {
            return {
                data: {
                    for_user_id: 5,
                    author: this.user.fullName,
                    participants:[],
                },
                messages: [],
                isLogging: false,
                usersInRoom: [],
                users: [],
                participants: [
                    // {
                    //     id: this.user.id,
                    //     name: this.user.fullName,
                    //     imageUrl: 'https://avatars3.githubusercontent.com/u/1915989?s=230&v=4'
                    // },
                    // {
                    //     id: 'user2',
                    //     name: 'Support',
                    //     imageUrl: 'https://avatars3.githubusercontent.com/u/37018832?s=200&v=4'
                    // }
                ], // the list of all the participant of the conversation. `name` is the user name, `id` is used to establish the author of a message, `imageUrl` is supposed to be the user avatar.
                titleImageUrl: 'https://a.slack-edge.com/66f9/img/avatars-teams/ava_0001-34.png',
                messageList: [
                    // {type: 'text', author: `me`, data: {text: `Say yes!`}},
                    // {type: 'text', author: `user1`, data: {text: `No.`}}
                ], // the list of the messages to show, can be paginated and adjusted dynamically
                newMessagesCount: 0,
                isChatOpen: false, // to determine whether the chat window should be open or closed
                showTypingIndicator: '', // when set to a value matching the participant.id it shows the typing indicator for the specific user
                colors: {
                    header: {
                        bg: '#4e8cff',
                        text: '#ffffff'
                    },
                    launcher: {
                        bg: '#4e8cff'
                    },
                    messageList: {
                        bg: '#ffffff'
                    },
                    sentMessage: {
                        bg: '#4e8cff',
                        text: '#ffffff'
                    },
                    receivedMessage: {
                        bg: '#eaeaea',
                        text: '#222222'
                    },
                    userInput: {
                        bg: '#f4f7f9',
                        text: '#565867'
                    }
                }, // specifies the color scheme for the component
                alwaysScrollToBottom: false, // when set to true always scrolls the chat to the bottom when new events are in (new message, user starts typing...)
                messageStyling: true // enables *bold* /emph/ _underline_ and such (more info at github.com/mattmezza/msgdown)
            }
        },
        methods: {
            async login() {

                this.isLogging = false;
            }, closeModal() {
                // this.isShowing = false;
                const chatLogModalObj = {
                    showChatLogModal: false,
                }
                this.$store.commit('setChatLogModalObj', chatLogModalObj)
            },
            sendMessage(text) {
                if (text.length > 0) {
                    this.newMessagesCount = this.isChatOpen ? this.newMessagesCount : this.newMessagesCount + 1

                    const message = {
                        author: 'me',
                        type: 'text',
                        data: {text}
                    }
                    //console.log(message)
                    this.onMessageWasSent(message)
                }
            },
            async onMessageWasSent(message) {
                // called when the user sends a message
                // console.log(message)

                const data = {
                    message: message,
                    for_user_id: this.data.for_user_id,
                    user:{
                        user_id: this.user.id,
                        name: this.user.fullName,
                    }

                }
                this.messageList = [...this.messageList, message]
              //  console.log(data)
                // console.log(this.user)
                const res = await this.callApi('post', '/store/sendmessage', data);

                if (res.status === 201) {
                    //   console.log('Successfully');
                }

            },
            openChat() {
                // called when the user clicks on the fab button to open the chat
                this.isChatOpen = true
                this.newMessagesCount = 0
            },
            closeChat() {
                // called when the user clicks on the botton to close the chat
                this.isChatOpen = false
            }
        },
        async created() {
            const res = await this.callApi('get', '/store/messages');

            if (res.status === 200) {
                this.messages = res.data.messages
                this.users = res.data.users;

                // console.log(this.messages)
                // console.log(this.users)
            } else {
                // console.log(hello)
                if (res.status === 401) {
                    this.i(res.data.msg);
                } else if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0])
                    }
                } else {
                    this.swr();
                }
            }

            let pusher = new Pusher('83cd2bbd6854b79aa72e', {
                cluster: 'ap1'
            });


            let channel = pusher.subscribe('new-message' + this.data.for_user_id);
            channel.bind('get-message', (data) => {
                // console.log(data)
                // console.log(data.user.user_id)
                // console.log(data.for_user_id)
                // console.log(data.user.name)
                //console.log(data.message.author)
                if (data.user.user_id != this.user.id) {
                  //  console.log(data.name)
                    data.message.author = data.user.name
                   // console.log(data.message)
                    this.messageList = [...this.messageList, data.message]
                }

                //console.log(data)

            })
        },
        computed: {
            ...mapGetters(['getChatLogModalObj', 'setChatLogModalObj'])
        },
        components:
            {
                // chatComposerModal,
                // chatMessageModal
            }

    };
</script>


<style scoped>
    #chat-dialouge {
        position: absolute;
    }
</style>
