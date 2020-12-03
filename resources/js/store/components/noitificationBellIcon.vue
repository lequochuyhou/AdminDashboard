<template>
    <div>
        <Dropdown>
            <Button ghost trigger="click" @click="removeCounter" type="text">
                <notification-bell :size="20" :count="count"></notification-bell>
                <Icon type="ios-arrow-down"></Icon>
            </Button>

            <DropdownMenu   v-for="(notification,i) in notifications" :key="i" slot="list"  >
<!--                <div style="overflow: scroll;">-->
                    <DropdownItem  class="border-top"><router-link :to="'/store/order-details/'+notification.order.id">New order by </router-link></DropdownItem>
<!--                </div>-->
<!--                <DropdownItem style="height: 80px;" v-if="i==3"><router-link to="/">Show all</router-link></DropdownItem>-->
            </DropdownMenu>
            <footer>

            </footer>


        </Dropdown>


        <!--        <b-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret>-->
        <!--            <b-dropdown-item href="#">Action</b-dropdown-item>-->
        <!--            <b-dropdown-item href="#">Another action</b-dropdown-item>-->
        <!--            <b-dropdown-item href="#">Something else here...</b-dropdown-item>-->
        <!--        </b-dropdown>-->

    </div>
</template>


<script>
    import NotificationBell from 'vue-notification-bell'
    import {mapGetters} from 'vuex'

    export default {
        props: ['message', 'users', 'user'],
        data() {
            return {
                count: 0,
                 notifications:[],
                // [
                //     // {name: 'Bạn có đơn đặt hàng mới 1', order_id: 1},
                //     // {name: 'Bạn có đơn đặt hàng mới 2', order_id: 2},
                //     // {name: 'Bạn có đơn đặt hàng mới 3', order_id: 3},
                //     // {name: 'Bạn có đơn đặt hàng mới 1', order_id: 1},
                //     // {name: 'Bạn có đơn đặt hàng mới 2', order_id: 2},
                //     // {name: 'Bạn có đơn đặt hàng mới 3', order_id: 3},
                //     // {name: 'Bạn có đơn đặt hàng mới 1', order_id: 1},
                //     // {name: 'Bạn có đơn đặt hàng mới 2', order_id: 2},
                //     // {name: 'Bạn có đơn đặt hàng mới 3', order_id: 3},
                // ],
                showDropDownMenu:false
            };
        },
        methods: {
            async login() {
                if (this.data.email.trim() == "") {
                }
            },
            removeCounter() {
                this.showDropDownMenu=true
                this.count = 0;
            },
            getUserFullname(notification){
                let fullName=this.users.find(user=>user.id===notification.user_id).fullName;
                return fullName;
            }

        },
        components: {
            NotificationBell
        },
        computed: {
            ...mapGetters(['getNotificationData'])
        },
        mounted() {
            // console.log('Mounted function ')
            // Echo.private("newOrder").notification(notification => {
            //    // this.notifications.unshift(notification.notification);
            //     console.log(notification)
            // });
        }
        ,
       async created() {
            // Echo.private("newOrder").notification(notification => {
            //     // this.notifications.unshift(notification.notification);
            //     console.log(notification)
            // });
            const res = await this.callApi('get', '/store/get_notifications', this.data);

            if (res.status === 200) {
                // this.notifications = res.data


                res.data.forEach(e=>{
                    //console.log(e.data)
                    this.notifications.push(JSON.parse(e.data));
                });


                console.log(this.notifications)

                // console.log(this.orderLists)

            } else {
                this.swr();
            }
        },
        watch:{
            getNotificationData(obj){
                // console.log('Hello')
                 console.log(obj)
                if(obj) {
                    this.notifications.push(obj.data)
                    console.log(this.notifications)
                    this.count++;
                }
            }
        }
    };
</script>


<style scoped>

    .dropdown {
        display: inline-block;
        margin-left: 20px;
        padding: 10px;
    }


    .glyphicon-bell {

        font-size: 1.5rem;
    }

    .notifications {
        min-width: 420px;
    }

    .notifications-wrapper {
        overflow: auto;
        max-height: 250px;
    }

    .menu-title {
        color: #ff7788;
        font-size: 1.5rem;
        display: inline-block;
    }

    .glyphicon-circle-arrow-right {
        margin-left: 10px;
    }


    .notification-heading, .notification-footer {
        padding: 2px 10px;
    }


    .dropdown-menu.divider {
        margin: 5px 0;
    }

    .item-title {

        font-size: 1.3rem;
        color: #000;

    }

    .notifications a.content {
        text-decoration: none;
        background: #ccc;

    }

    .notification-item {
        padding: 10px;
        margin: 5px;
        background: #ccc;
        border-radius: 4px;
    }


</style>


