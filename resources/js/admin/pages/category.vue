<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Products
                        <Button @click="addModal=true">
                            <Icon type="md-add"/>
                            Create new category
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
<!--                                <th>Image icon</th>-->
                                <th>Category name</th>
                                <th>Description</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->

                            <tr v-for="(category,i) in categoryLists" :key="i" v-if="categoryLists.length">
                                <td>{{category.id}}</td>
<!--                                <td class="table_image"><img :src="`${category.iconImage}`"/></td>-->
                                <td class="_table_name">{{category.categoryName}}</td>
                                <td class="text-uppercase">{{category.description}}</td>
                                <td>{{category.created_at}}</td>
                                <td>
                                    <Button v-if="isUpdatePermitted" type="info" size="small" @click="showEditModal(category,i)">Edit</Button>
                                    <Button v-if="isDeletePermitted" type="error" size="small" @click="showDeletingModal(category,i)"
                                            :loading="category.isDeleting">Delete
                                    </Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->


                        </table>
                    </div>

                    <!-- tag Modal -->
                    <Modal
                        v-model="addModal"
                        title="Add category"
                        :mask-closable="false"
                        :closable="false"
                    >

                        <div class="space">
                            <Input v-model="data.categoryName" size="large" placeholder="Add category name"/>
                        </div>
                        <div class="space">
                            <Input v-model="data.description" size="large" placeholder="Add description"/>
                        </div>


<!--                        <div class="space">-->
<!--                            <Upload-->
<!--                                ref="uploads"-->
<!--                                multiple-->
<!--                                type="drag"-->
<!--                                :headers="{'x-csrf-token':token,'X-Requested-With':'XMLHttpRequest'}"-->
<!--                                :on-success="handleSuccess"-->
<!--                                :on-error="handleError"-->
<!--                                :max-size="2048"-->
<!--                                :on-format-error="handleFormatError"-->
<!--                                :format="['jpg','jpeg','png']"-->
<!--                                :on-exceeded-size="handleMaxSize"-->

<!--                                action="/app/upload">-->
<!--                                <div style="padding: 20px 0">-->
<!--                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>-->
<!--                                    <p>Click or drag files here to upload</p>-->
<!--                                </div>-->
<!--                            </Upload>-->
<!--                            <div class="demo-upload-list" v-if="data.iconImage">-->
<!--                                <img :src="`${data.iconImage}`"/>-->
<!--                                <div class="demo-upload-list-cover">-->
<!--                                    <Icon type="ios-trash-outline" @click="deleteImage"></Icon>-->
<!--                                </div>-->

<!--                            </div>-->
<!--                        </div>-->
                        <div slot="footer">
                            <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Adding..':'Add category'}}
                            </Button>
                            <Button type="default" @click="addModal=false">Close</Button>
                        </div>
                    </Modal>

                    <!--Edit modal -->
                    <Modal
                        v-model="editModal"
                        title="Edit category"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <div class="space">
                            <Input v-model="editData.categoryName" size="large" placeholder="Edit category name"/>
                        </div>
                        <div class="space">
                            <Input v-model="editData.description" size="large" placeholder="Edit description"/>
                        </div>
<!--                        <div class="space">-->
<!--                            <Upload v-show="isIconImageNew"-->
<!--                                    ref="editDataUploads"-->
<!--                                    multiple-->
<!--                                    type="drag"-->
<!--                                    :headers="{'x-csrf-token':token,'X-Requested-With':'XMLHttpRequest'}"-->
<!--                                    :on-success="handleSuccess"-->
<!--                                    :on-error="handleError"-->
<!--                                    :max-size="2048"-->
<!--                                    :on-format-error="handleFormatError"-->
<!--                                    :format="['jpg','jpeg','png']"-->
<!--                                    :on-exceeded-size="handleMaxSize"-->

<!--                                    action="/app/upload">-->
<!--                                <div style="padding: 20px 0">-->
<!--                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>-->
<!--                                    <p>Click or drag files here to upload</p>-->
<!--                                </div>-->
<!--                            </Upload>-->
<!--                            <div class="demo-upload-list" v-if="editData.iconImage">-->
<!--                                <img :src="`${editData.iconImage}`"/>-->
<!--                                <div class="demo-upload-list-cover">-->
<!--                                    <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>-->
<!--                                </div>-->

<!--                            </div>-->

<!--                       // </div>-->
                        <div slot="footer">
                            <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Editing..':'Edit category'}}
                            </Button>
                            <Button type="default" @click="closeEditModal">Close</Button>
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
                    <!--                            <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting"-->
                    <!--                                    @click="deleteTag">Delete-->
                    <!--                            </Button>-->
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
    import deleteModal from '../components/deleteModal.vue'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                data: {
                    iconImage: '',
                    categoryName: '',
                    description:''
                },
                addModal: false,
                editModal: false,
                isAdding: false,
                categoryLists: [],
                editData: {
                    iconImage: '',
                    categoryName: '',
                    description:''
                },
                index: -1,
                showDeleteModal: false,
                isDeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                token: '',
                isIconImageNew: false,
                isEditingItem: false
            }
        },
        methods: {
            async addCategory() {
                if (this.data.categoryName.trim() == '') {
                    return this.e('Category name is required');
                }
                // if (this.data.iconImage.trim() == '') {
                //     return this.e('Image name is required');
                // }

                this.data.iconImage=`${this.data.iconImage}`
                const res = await this.callApi('post', 'app/create_category', this.data);
                if (res.status === 201) {
                    this.categoryLists.unshift(res.data);
                    this.s('Category has been added successfully!');
                    this.addModal = false;
                   // this.data.iconImage = ''
                    this.data.categoryName = ''
                    this.data.description = ''
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.categoryName) {
                            this.e(res.data.errors.categoryName[0]);
                        }
                        if (res.data.errors.iconImage) {
                            this.e(res.data.errors.iconImage[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            },
            async editCategory() {
                if (this.editData.categoryName.trim() == '') {
                    return this.e('Category name is required');
                }
                // if (this.editData.iconImage.trim() == '') {
                //     return this.e('Image name is required');
                // }

                const res = await this.callApi('post', 'app/edit_category', this.editData);
                if (res.status === 200) {

                    this.categoryLists[this.index].categoryName = this.editData.categoryName;
                    this.categoryLists[this.index].description = this.editData.description;
                    this.s('Category has been add successfully!');
                    this.editModal = false;
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.categoryName) {
                            this.e(res.data.errors.categoryName[0]);
                        }
                        if (res.data.errors.iconImage) {
                            this.e(res.data.errors.iconImage[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            },
            showEditModal(category, index) {
                // let obj = {
                //     id: tag.id,
                //     tagName: tag.tagName
                // }

                this.editData = category
                this.editModal = true
                this.index = index;
                this.isEditingItem = true
            },
            // async deleteTag() {
            //     this.isDeleting = true
            //     const res = await this.callApi('post', 'app/delete_tag', this.deleteItem);
            //     if (res.status === 200) {
            //         this.tags.splice(this.deletingIndex, 1);
            //         this.s('Tag has been delete it successfully!');
            //         this.showDeleteModal = false;
            //     } else {
            //         this.swr();
            //     }

            //     this.isDeleting = false
            //     this.showDeleteModal = false;

            // },
            showDeletingModal(category, i) {

                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl:'app/delete_category',
                    data: category,
                    deletingIndex: i,
                    isDeleted: true
                }

                //this.categoryLists.splice(i,1);
                this.$store.commit('setDeletingModalObj',deleteModalObj);


                // this.deleteItem = tag;
                // this.deletingIndex = i
                // this.showDeleteModal = true
            },
            handleSuccess(res, file) {
                res = `/uploads/${res}`;
                if (this.isEditingItem) {
                    console.log('inside');
                    return this.editData.iconImage = res
                }

                this.data.iconImage = res

                // console.log(this.data.iconImage)
                // file.url = 'https://o5wwk8baw.qnssl.com/7eb99afb9d5f317c912f08b5212fd69a/avatar';
                // file.name = '7eb99afb9d5f317c912f08b5212fd69a';
            },
            handleFormatError(file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize(file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
            handleError(res, file) {
                // console.log('res',res);
                // console.log('file',file);
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`
                });
            }, handleBeforeUpload() {
                const check = this.uploadList.length < 5;
                if (!check) {
                    this.$Notice.warning({
                        title: 'Up to five pictures can be uploaded.'
                    });
                }
                return check;
            },
            async deleteImage(isAdd = true) {
                let image;
                if (!isAdd)//for edit image
                {
                    this.isIconImageNew = true
                    image = this.data.editData
                    this.editData.iconImage = ''
                    this.$refs.editDataUploads.clearFiles()
                } else {
                    image = this.data.iconImage
                    this.data.iconImage = ''
                    this.$refs.uploads.clearFiles()
                }

                const res = await this.callApi('post', 'app/delete_image', {imageName: image});
                if (res.status != 200) {
                    this.data.iconImage = image;
                    this.swr()
                }
            },
            closeEditModal() {
                this.isEditingItem = false
                this.editModal = false
            }
        },
        async created() {
            this.token = window.Laravel.csrfToken;
            const res = await this.callApi('get', 'app/get_category');
            if (res.status == 200) {
                this.categoryLists = res.data
            } else {
                this.swr();
            }
        },
        components: {
            deleteModal
        },
        computed:{
            ...mapGetters(["getDeleteModalObj"])
        },
        watch: {
               getDeleteModalObj(obj){
              //  console.log(obj);
                if(obj.isDeleted){
                  this.categoryLists.splice(obj.deletingIndex,1);
                }
            }
        },


    }
</script>
