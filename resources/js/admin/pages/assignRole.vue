<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Role permission
                        <Select
                            v-model="data.id"
                            placeholder="Select admin type"
                            style="width: 300px"
                            @on-change="changeAdmin"
                        >
                            <Option :value="role.id" v-for="(role,i) in roles" :key="i" v-if="roles.length" >
                                {{role.roleName}}
                            </Option>
                            <!--                <Option value="Editor">Editor</Option>-->
                        </Select>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table text-center">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Resource name</th>
                                <th>Read</th>
                                <th>Write</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->

                            <tr v-for="(resource,i) in resources" :key="i">
                                <td>{{resource.resourceName}}</td>
                                <td> <Checkbox v-model="resource.read"></Checkbox></td>
                                <td><Checkbox v-model="resource.write"></Checkbox></td>
                                <td><Checkbox v-model="resource.update"></Checkbox></td>
                                <td><Checkbox v-model="resource.delete"></Checkbox></td>
                            </tr>
                            <!-- ITEMS -->
                            <div >
                                 <Button  class="left" type="primary" :loading="isSending" :disabled="isSending" @click="assignRoles">Assign</Button>
                            </div>

                        </table>
                    </div>


                    <!-- tag Modal -->


                    <!--Edit modal -->


                    <!--                    <delete-modal></delete-modal>-->
                </div>
                <Page :total="100"/>
            </div>
        </div>
    </div>
</template>

<script>
    import deleteModal from "../components/deleteModal.vue";
    import {mapGetters} from "vuex";

    export default {
        data() {
            return {
                data: {
                    roleName: "",
                    id: null
                },
                isSending:false,
                roles: [],
                resources: [
                    {resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/'},
                    {resourceName: 'Products', read: true, write: false, update: false, delete: false, name: 'product'},
                    {resourceName: 'Suppliers', read: false, write: false, update: false, delete: false, name: 'supplier'},
                    {resourceName: 'Brands', read: false, write: false, update: false, delete: false, name: 'brand'},
                    {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                    {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category'},
                    {resourceName: 'Create blogs', read: false, write: false, update: false, delete: false, name: 'createBlog'},
                    {resourceName: 'Admin & Users', read: false, write: false, update: false, delete: false, name: 'adminusers'},
                    {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role'},
                    {resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name: 'assignRole'},



                ],
                defaultResources: [
                    {resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/'},
                    {resourceName: 'Products', read: false, write: false, update: false, delete: false, name: 'product'},
                    {resourceName: 'Suppliers', read: false, write: false, update: false, delete: false, name: 'supplier'},
                    {resourceName: 'Brands', read: false, write: false, update: false, delete: false, name: 'brand'},
                    {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                    {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category'},
                    {resourceName: 'Create blogs', read: false, write: false, update: false, delete: false, name: 'createBlog'},
                    {resourceName: 'Admin & Users', read: false, write: false, update: false, delete: false, name: 'adminusers'},
                    {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role'},
                    {resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name: 'assignRole'},
                ],
            };
        },
        methods: {
            async assignRoles(){
                let data= JSON.stringify(this.resources);
                const res=await this.callApi('post','app/assign_roles',{'permission':data,'id':this.data.id});
                if(res.status==200){
                    this.s('Role has been assigned successfully');
                    let index=this.roles.findIndex(role=>role.id==this.data.id);
                    this.roles[index].permission=data;
                }
                else
                {
                    this.swr();
                }

            },
            changeAdmin(){

                // this.defaultResources=[];
                this.resources=[];

                let index=this.roles.findIndex(role=>role.id==this.data.id);
                let permission=this.roles[index].permission;
                if(permission){
                    this.resources=JSON.parse(permission);
                }else
                {
                    this.resources=this.defaultResources;
                }
             //   console.log(permission);
            }
        },
        async created() {
            console.log(this.$route)
            const res = await this.callApi('get', 'app/get_roles')
            if (res.status == 200) {
                this.roles = res.data;
                if(res.data.length) {
                    this.data.id = res.data[0].id;
                    if(res.data[0].permission)
                    {
                        this.resources=JSON.parse(res.data[0].permission);
                    }
                }
            } else {
                this.swr();
            }


        }
    };
</script>
