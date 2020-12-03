<template>
    <div>
        <!--        <div class="dropdown show">-->
        <!--            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
        <!--                Dropdown link-->
        <!--            </a>-->

        <!--            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
        <!--                <a class="dropdown-item" href="#">Action</a>-->
        <!--                <a class="dropdown-item" href="#">Another action</a>-->
        <!--                <a class="dropdown-item" href="#">Something else here</a>-->
        <!--            </div>-->
        <!--        </div>-->
        <Dropdown>
            <Button ghost trigger="click" @click="removeCounter" @mouseleave="closeDropDownMenu" type="text">
                <notification-bell :size="20" :count="data.count"></notification-bell>
                <!--                <Icon type="ios-arrow-down"></Icon>-->
            </Button>

<!--            <DropdownMenu v-if="showDropDownMenu" v-for="(notification,i) in notifications" :key="i" slot="list">-->
<!--                &lt;!&ndash;                <div style="overflow: scroll;">&ndash;&gt;-->
<!--                <DropdownItem class="border-top" v-if="i<5">-->
<!--                    <router-link :to="'/store/order-details/'+notification.order.id">New order by</router-link>-->
<!--                </DropdownItem>-->
<!--                &lt;!&ndash;                </div>&ndash;&gt;-->
<!--                &lt;!&ndash;                <DropdownItem style="height: 80px;" v-if="i==3"><router-link to="/">Show all</router-link></DropdownItem>&ndash;&gt;-->
<!--            </DropdownMenu>-->

            <DropdownMenu v-if="showDropDownMenu" v-for="(order,i) in orderList" :key="i" slot="list">
                <!--                <div style="overflow: scroll;">-->
                <DropdownItem class="border-top" v-if="i<5">
                    <Icon type="md-cart" /> <router-link :to="'/order-details/'+order.id">New order by {{getUserFullname(order)}}</router-link>
                </DropdownItem>
                <!--                </div>-->
                <!--                <DropdownItem style="height: 80px;" v-if="i==3"><router-link to="/">Show all</router-link></DropdownItem>-->
            </DropdownMenu>


        </Dropdown>


    </div>
</template>


<script>
    import NotificationBell from 'vue-notification-bell'
    import {mapGetters} from 'vuex'

    export default {
        // props: ['message', 'users', 'user'],
        data() {
            return {
                counter: 0,
                notifications: [],
                orderList: [],
                userList:[],
                data: {
                    count: 0,
                    orderList: [],
                },
                showDropDownMenu: false
            };
        },
        methods: {
            async login() {
                if (this.data.email.trim() == "") {
                }
            },
            removeCounter() {
                this.showDropDownMenu = true
                this.data.count = 0;
            },
            closeDropDownMenu() {
                this.showDropDownMenu = false
            },
            getUserFullname(order) {
                let fullName = this.userList.find(user => user.id === order.user_id).fullName;
                return fullName;
            },
            // updateCount(){
            //     this.data.count=this.counter
            //
            //     return this.data.count
            // }

        },
        components: {
            NotificationBell
        },
        computed: {
            ...mapGetters(['getNotificationData'])
        },
        mounted() {

        }
        ,
        async created() {

            var counter = 0;
            // const res = await this.callApi('get', 'app/get_notification');
            const [res, resOrder,resAllUsers] = await Promise.all([
                this.callApi('get', 'app/get_notification'),
                this.callApi('get', 'app/get_order'),
                this.callApi('get', 'app/get_allusers')
            ]);
            if (res.status === 200) {

                res.data.forEach(e => {
                    this.notifications.push(JSON.parse(e.data));
                });


            } else {
                this.swr();
            }

            if (resOrder.status === 200) {
                this.orderList = resOrder.data


            } else {
                this.swr();
            }


            if (resAllUsers.status === 200) {
                this.userList = resAllUsers.data


            } else {
                this.swr();
            }
            let pusher = new Pusher('83cd2bbd6854b79aa72e', {
                cluster: 'ap1'
            });


            let channel = pusher.subscribe('new-order');
            channel.bind('get-order', (data) => {
                if(this.data.count==0){
                    counter=0;
                }
                if (data) {
                    counter++;
                    this.data.count = counter;
                    // console.log(data.order)
                    // console.log(data.order.user_id)

                  this.orderList.unshift(data.order);
                }


            });
        },
        watch: {
            getNotificationData(obj) {
                if (obj) {
                    this.notifications.push(obj.data)
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


