<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Role management
                        <Button @click="addModal=true" v-if="isWritePermitted">
                            <Icon type="md-add"/>
                            Create new role
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Role name</th>
                                <th>Is Admin</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->

                            <tr v-for="(role,i) in roles" :key="i" v-if="roles.length">
                                <td>{{role.id}}</td>
                                <td >{{role.roleName}}</td>
                                <td>{{role.isAdmin==0?'No':'Yes'}}</td>
                                <td>{{role.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(role,i)" v-if="isUpdatePermitted">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(role,i)"
                                            v-if="isDeletePermitted"
                                            :loading="role.isDeleting">Delete
                                    </Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->


                        </table>
                    </div>

                    <!-- tag Modal -->
                    <Modal
                        v-model="addModal"
                        title="Add role"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input v-model="data.roleName" size="large" placeholder="Role name"/>

                        <div class="space">
                        <Select
                            v-model="data.isAdmin"
                            placeholder="Admin or not"
                            style="width: 300px"
                        >
                            <Option value="1">
                                Yes
                            </Option>
                            <Option value="0">
                                No
                            </Option>
                            <!--                <Option value="Editor">Editor</Option>-->
                        </Select>
                        </div>
                        <div slot="footer">
                            <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Adding..':'Add role'}}
                            </Button>
                            <Button type="default" @click="addModal=false">Close</Button>
                        </div>
                    </Modal>

                    <!--Edit modal -->
                    <Modal
                        v-model="editModal"
                        title="Edit role"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input v-model="editData.roleName" size="large" placeholder="Edit role name"/>

                        <Select
                            v-model="editData.isAdmin"
                            placeholder="Admin or not"
                            style="width: 300px"
                        >
                            <Option value="1">
                                Yes
                            </Option>
                            <Option value="0">
                                No
                            </Option>
                            <!--                <Option value="Editor">Editor</Option>-->
                        </Select>

                        <div slot="footer">
                            <Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Editing..':'Edit tag'}}
                            </Button>
                            <Button type="default" @click="editModal=false">Close</Button>
                        </div>
                    </Modal>


                    <delete-modal></delete-modal>
                </div>
                <Page :total="100"/>

            </div>
        </div>
    </div>
</template>

<script>
    import deleteModal from '../components/deleteModal.vue'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                data: {
                    roleName: '',
                    isAdmin:null
                },
                addModal: false,
                editModal: false,
                isAdding: false,
                roles: [],
                editData: {
                    roleName: '',
                    isAdmin:null
                },
                index: -1,
                showDeleteModal: false,
                isDeleting: false,
                deleteItem: {},
                deletingIndex: -1,

            }
        },
        methods: {
            async add() {
                if (this.data.roleName.trim() == '') {
                    return this.e('Role name is required');
                }


                const res = await this.callApi('post', 'app/create_role', this.data);
                this.data.roleName = '';
                this.data.isAdmin=null;
                if (res.status === 201) {
                    this.roles.unshift(res.data);
                    this.s('Role has been added successfully!');
                    this.addModal = false;
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.roleName) {
                            this.e(res.data.errors.roleName[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            }, async edit() {
                if (this.editData.roleName.trim() == '') {
                    return this.e('Role name is required');
                }
                const res = await this.callApi('post', 'app/edit_role', this.editData);
                if (res.status === 200) {

                    this.roles[this.index].roleName = this.editData.roleName;
                    this.roles[this.index].isAdmin = this.editData.isAdmin;
                    this.s('Role has been added successfully!');
                    this.editModal = false;
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.roleName) {
                            this.e(res.data.errors.roleName[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            },
            showEditModal(role, index) {
                let obj = {
                    id: role.id,
                    roleName: role.roleName,
                    isAdmin:role.isAdmin
                }

                this.editData = obj
                this.editModal = true
                this.index = index;
            },
            showDeletingModal(role, i) {

                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl: 'app/delete_tag',
                    data: role,
                    deletingIndex: i,
                    isDeleted: false

                }

                this.$store.commit('setDeletingModalObj', deleteModalObj);
                // this.deleteItem=tag;
                // this.deletingIndex=i
                // this.showDeleteModal=true
            }
        },
        async created() {
            const res = await this.callApi('get', 'app/get_roles');

            if (res.status == 200) {
                this.roles = res.data
                console.log(this.roles)
            } else {
                this.swr();
            }


        },
        components: {
            deleteModal
        },
        computed: {
            ...mapGetters([
                'getDeleteModalObj'
            ])
        },
        watch: {
            getDeleteModalObj(obj) {
                //console.log(obj);
                if (obj.isDeleted) {
                    this.roles.splice(obj.deletingIndex, 1);
                }
            }
        }


    }
</script>
