<template>
    <div>

        <div v-if="$store.state.user">
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>

                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li v-for="(menuItem, i) in permission" :key="i" v-if="permission.length && menuItem.read">
                                <router-link :to="'/'+menuItem.name">
                                    <Icon type="ios-speedometer"/>
                                    {{menuItem.resourceName}}
                                </router-link>
                            </li>


                            <!--                        <li><router-link to="/"><Icon type="ios-speedometer" /> Dashboard</router-link></li>-->
                            <!--                        <li><router-link to="tags"><Icon type="ios-speedometer" /> Tags</router-link></li>-->
                            <!--                        <li><router-link to="category"><Icon type="ios-speedometer" /> Category</router-link></li>-->
                            <!--                        <li><router-link to="adminusers"><Icon type="ios-speedometer" /> Admin users</router-link></li>-->
                            <!--                        <li><router-link to="role"><Icon type="ios-speedometer" /> Role Management</router-link></li>-->
                            <!--                        <li><router-link to="assignRole"><Icon type="ios-speedometer" /> Assign role</router-link></li>-->

                            <li><a href="/logout">
                                <Icon type="ios-speedometer"/>
                                Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button ">
                            <li>
                                <Icon type="ios-list"/>
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                            <li>
                                {{user.fullName}}
                            </li>
                            <li>
                                <noitificationBellIcon></noitificationBellIcon>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view :user="user" />
    </div>
</template>

<script>
    import noitificationBellIcon from "../admin/components/noitificationBellIcon";


    export default {
        props: ['user', 'permission'],
        data() {
            return {
                isLoggedin: false
            }
        },
        created() {
            this.$store.commit('setUpdateUser', this.user);
            this.$store.commit('setUserPermission', this.permission);
            // console.log(this.user);
            // console.log(this.permission);
            // var pusher = new Pusher('83cd2bbd6854b79aa72e', {
            //     cluster: 'ap1'
            // });
            //
            // var channel = pusher.subscribe('new-order');
            // channel.bind('get-order', function(data) {
            //     console.log(data)
            //     //app.messages.push(JSON.stringify(data));
            // });
            // Echo.private('App.User' + this.user.id).notification(notification => {
            //     console.log(notification)
            // });
        },
        components: {
            noitificationBellIcon
        }
    }
</script>
