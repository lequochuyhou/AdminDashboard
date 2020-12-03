<template >
    <div>
<!--        <div>-->
<!--            <p>{{message.message}}</p>-->
<!--            <small>{{getFullName(message.user_id)}}</small>-->
<!--        </div>-->
        <div v-if="message.user_id!=user.id" class="container">
<!--            <img src="/w3images/bandmember.jpg" alt="Avatar">-->
            <p v-if="message.user_id"><h4>{{getFullName(message.user_id)}}</h4></p>
<!--            <p v-if="!message.user_id"><h4>{{message.fullName}}</h4></p>-->
            <p><b>{{message.message}}</b></p>
            <span class="time-right">{{message.created_at}}</span>
        </div>


        <div v-if="message.user_id==user.id" class="container darker">
            <p><h4 class="right">{{getFullName(message.user_id)}}</h4></p>
            <p><b>{{message.message}}</b></p>
            <span class="time-right">{{message.created_at}}</span>
        </div>

<!--        <basic-vue-chat />-->

    </div>
</template>


<script>
    import basicVueChat from 'basic-vue-chat'
    export default {
        props:['message','users','user'],
        data() {
            return {
                // message: 'Hello',
                // user: 'Jon Doe',
                // isLogging: false,
            };
        },
        methods: {
            async login() {
                if (this.data.email.trim() == "") {
                    return this.e("Email is required");
                }
                if (this.data.password.trim() == "") {
                    return this.e("Password is required");
                }
                if (this.data.password.length < 6) {
                    return this.e("Incorrect login details");
                }
                this.isLogging = true;

                const res = await this.callApi('post', 'store/login', this.data);

                if (res.status === 200) {
                    //this.s(res.data.msg);
                    //window.location='/'
                    console.log(res.data)
                } else {
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
                this.isLogging = false;
            },
            getFullName(user_id){
                let fullName=this.users.find(user=>user.id==user_id).fullName;
                return fullName;
            }
        },
        components:{
            basicVueChat
        }
    };
</script>


<style scoped>
    .container {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
        width: 450px;
        overflow: auto;
    }

    /* Darker chat container */
    .darker {
        border-color: #ccc;
        background-color: #ddd;
    }

    /* Clear floats */
    .container::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Style images */
    .container img {
        float: left;
        max-width: 60px;
        width: 100%;
        margin-right: 20px;
        border-radius: 50%;
    }

    .container h4.right{
        float: right;
    }

    /* Style the right image */
    /*.container img.right {*/
    /*    float: right;*/
    /*    margin-left: 20px;*/
    /*    margin-right:0;*/
    /*}*/

    /* Style time text */
    .time-right {
        float: right;
        color: #aaa;
    }

    /* Style time text */
    .time-left {
        float: left;
        color: #999;
    }
</style>
