<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Users
                        <Button @click="addModal = true">
                            <Icon type="md-add"/>
                            Create new user
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Usertype</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(user, i) in users" :key="i" v-if="users.length">
                                <td>{{ user.id }}</td>
                                <td class="_table_name">{{ user.fullName }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.userType }}</td>
                                <td>{{ user.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(user, i)"
                                    >Edit
                                    </Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(user, i)"
                                        :loading="user.isDeleting"
                                    >Delete
                                    </Button
                                    >
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>

                    <!-- tag Modal -->
                    <Modal
                        v-model="addModal"
                        title="Add user"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <div class="space">
                            <Input
                                type="text"
                                v-model="data.fullName"
                                size="large"
                                placeholder="Fullname"
                            />
                        </div>
                        <div class="space">
                            <Input
                                type="email"
                                v-model="data.email"
                                size="large"
                                placeholder="Email"
                            />
                        </div>
                        <div class="space">
                            <Input
                                type="password"
                                v-model="data.password"
                                size="large"
                                placeholder="Password"
                            />
                        </div>

                        <div class="space">
                            <Select
                                v-model="data.role_id"
                                placeholder="Select admin type"
                                style="width: 200px"
                            >
                                <Option :value="role.id" v-for="(role,i) in roles" :key="i" v-if="roles.length">
                                    {{role.roleName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
                        </div>

                        <div slot="footer">
                            <Button
                                type="primary"
                                @click="addAdmin"
                                :disabled="isAdding"
                                :loading="isAdding"
                            >
                                {{ isAdding ? "Adding.." : "Add user" }}
                            </Button>
                            <Button type="default" @click="addModal = false">Close</Button>
                        </div>
                    </Modal>

                    <!--Edit modal -->
                    <Modal
                        v-model="editModal"
                        title="Edit user"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <div class="space">
                            <Input
                                type="text"
                                v-model="editData.fullName"
                                size="large"
                                placeholder="Fullname"
                            />
                        </div>
                        <div class="space">
                            <Input
                                type="email"
                                v-model="editData.email"
                                size="large"
                                placeholder="Email"
                            />
                        </div>
                        <div class="space">
                            <Input
                                type="password"
                                v-model="editData.password"
                                size="large"
                                placeholder="Password"
                            />
                        </div>

                        <div class="space">
                            <Select
                                v-model="editData.role_id"
                                placeholder="Select admin type"
                                style="width: 200px"
                            >
                                <Option :value="role.id" v-for="(role,i) in roles" :key="i" v-if="roles.length">
                                    {{role.roleName}}
                                </Option>
                            </Select>
                        </div>

                        <div slot="footer">
                            <Button
                                type="primary"
                                @click="editAdmin"
                                :disabled="isAdding"
                                :loading="isAdding"
                            >
                                {{ isAdding ? "Editing.." : "Edit Admin" }}
                            </Button>
                            <Button type="default" @click="editModal = false">Close</Button>
                        </div>
                    </Modal>

                    <!--Delete alert modal -->
                    <!--                    <Modal v-model="showDeleteModal" width="360">-->
                    <!--                        <p slot="header" style="color:#f60;text-align:center">-->
                    <!--                            <Icon type="ios-information-circle"></Icon>-->
                    <!--                            <span>Delete confirmation</span>-->
                    <!--                        </p>-->
                    <!--                        <div style="text-align:center">-->
                    <!--                            <p>Are you sure you want to delete tag ?.</p>-->

                    <!--                        </div>-->
                    <!--                        <div slot="footer">-->
                    <!--                            <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting"  @click="deleteTag">Delete</Button>-->
                    <!--                        </div>-->
                    <!--                    </Modal>-->
                    <delete-modal></delete-modal>
                </div>
                <Page :total="100"/>
            </div>
        </div>
    </div>
</template>

<script>
    import deleteModal from "../components/deleteModal.vue";
    import {mapGetters} from "vuex";
    import role from "./role";

    export default {
        data() {
            return {
                data: {
                    fullName: "",
                    email: "",
                    password: "",
                    userType: "",
                    role_id: null,
                    created_id:null
                },
                addModal: false,
                editModal: false,
                isAdding: false,
                users: [],
                editData: {
                    fullName: "",
                    email: "",
                    password: "",
                    userType: "",
                    role_id:null,
                    created_id:null
                },
                index: -1,
                showDeleteModal: false,
                isDeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                roles: []
            };
        },
        methods: {
            async addAdmin() {
                if (this.data.fullName.trim() == "") {
                    return this.e("Full name is required");
                }
                if (this.data.email.trim() == "") {
                    return this.e("Email is required");
                }
                if (this.data.password.trim() == "") {
                    return this.e("Password is required");
                }
                if (!this.data.role_id) {
                    return this.e("Role id is required");
                }

                this.data.userType=this.roles.find(role=>role.id==this.data.role_id).roleName;



                if (this.data.userType.trim() == "") {
                    return this.e("Usertype is required");
                }
                //console.log(this.data.password)


                // console.log(this.data.userType)
                //console.log(this.data);
                const res = await this.callApi("post", "app/create_user", this.data);
                if (res.status === 201) {
                    this.users.unshift(res.data);
                    this.s("Admin has been created successfully!");
                    this.addModal = false;
                } else {
                    if (res.status == 422) {
                        //   if (res.data.errors.fullName) {
                        //     this.e(res.data.errors.fullName[0]);
                        //   }
                        for (let i of res.data.errors) {
                            this.e(res.data.errors[i][0]);
                        }
                    } else {
                        this.swr();
                    }
                }
            },
            async editAdmin() {
                if (this.editData.fullName.trim() == "") {
                    return this.e("Full name is required");
                }
                if (this.editData.email.trim() == "") {
                    return this.e("Email is required");
                }
                if (!this.editData.role_id) {
                    return this.e("Role id is required");
                }

                this.editData.userType=this.roles.find(role=>role.id==this.editData.role_id).roleName;
                const res = await this.callApi("post", "app/edit_user", this.editData);

                if (res.status === 200) {
                    this.users[this.index] = this.editData;

                    this.s("User has been updated successfully!");
                    this.editModal = false;
                } else {
                    if (res.status == 422) {
                        for (let i of res.data.errors) {
                            this.e(res.data.errors[i][0]);
                        }
                    } else {
                        this.swr();
                    }
                }
            },
            showEditModal(user, index) {
                let obj = {
                    id: user.id,
                    fullName: user.fullName,
                    email: user.email,
                    userType: user.userType,
                    role_id:user.role_id
                };
                this.editData = obj;
                this.editModal = true;
                this.index = index;
            },

            showDeletingModal(tag, i) {
                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl: "app/delete_tag",
                    data: tag,
                    deletingIndex: i,
                    isDeleted: false,
                };

                this.$store.commit("setDeletingModalObj", deleteModalObj);
                // this.deleteItem=tag;
                // this.deletingIndex=i
                // this.showDeleteModal=true
            },
        },
        async created() {
            const [res, resRole] = await Promise.all([
                this.callApi("get", "app/get_users"),
                this.callApi('get', 'app/get_roles')
            ]);

            if (res.status == 200) {
                this.users = res.data;
            } else {
                this.swr();
            }

            if (resRole.status == 200) {
                this.roles = resRole.data
            } else {
                this.swr();
            }
        },
        components: {
            deleteModal,
        },
        computed: {
            ...mapGetters(["getDeleteModalObj"]),
        },
        watch: {
            getDeleteModalObj(obj) {
                console.log(obj);
                if (obj.isDeleted) {
                    this.users.splice(obj.deletingIndex, 1);
                }
            },
        },
    };
</script>
